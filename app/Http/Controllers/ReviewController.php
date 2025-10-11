<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Jobs\AnalyzeReviewSentiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book', 'book.category', 'reactions']);

        // Filtres
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book', function ($bookQuery) use ($search) {
                      $bookQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['created_at', 'rating', 'is_approved'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(15)->withQueryString();

        // Charger les réactions de l'utilisateur connecté
        if (Auth::check()) {
            $userReactions = \App\Models\ReviewReaction::where('user_id', Auth::id())
                ->whereIn('review_id', $reviews->pluck('id'))
                ->pluck('reaction_type', 'review_id');
        } else {
            $userReactions = collect();
        }

        return view('reviews.index', compact('reviews', 'userReactions'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Request $request)
    {
        $bookId = $request->get('book_id');
        $book = null;

        if ($bookId) {
            $book = Book::findOrFail($bookId);
            
            // Vérifier si l'utilisateur a déjà un avis pour ce livre
            if (Auth::check()) {
                $existingReview = Review::where('user_id', Auth::id())
                                      ->where('book_id', $bookId)
                                      ->first();
                
                if ($existingReview) {
                    return redirect()->route('reviews.show', $existingReview)
                                   ->with('info', 'Vous avez déjà laissé un avis pour ce livre.');
                }
            }
        }

        $books = Book::with('category')
                    ->where('is_available', true)
                    ->orderBy('title')
                    ->get();

        return view('reviews.create', compact('books', 'book'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'book_id.required' => 'Veuillez sélectionner un livre.',
            'book_id.exists' => 'Le livre sélectionné n\'existe pas.',
            'rating.required' => 'Veuillez donner une note.',
            'rating.between' => 'La note doit être comprise entre 1 et 5.',
            'comment.required' => 'Veuillez écrire un commentaire.',
            'comment.min' => 'Le commentaire doit contenir au moins 10 caractères.',
            'comment.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà un avis pour ce livre
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('book_id', $validated['book_id'])
                               ->first();

        if ($existingReview) {
            return back()
                ->withErrors(['book_id' => 'Vous avez déjà laissé un avis pour ce livre.'])
                ->withInput();
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Par défaut, en attente d'approbation
        ]);

        // L'analyse de sentiment se fait manuellement via le dashboard admin
        // AnalyzeReviewSentiment::dispatch($review);

        return redirect()->route('reviews.show', $review)
                        ->with('success', 'Votre avis a été soumis avec succès ! Il sera publié après modération.');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'book', 'book.category']);

        // Vérifier les permissions : seul l'auteur de l'avis ou un admin peut voir un avis non approuvé
        if (!$review->is_approved && Auth::id() !== $review->user_id) {
            abort(403, 'Cet avis n\'est pas encore approuvé.');
        }

        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        // Vérifier que l'utilisateur peut éditer cet avis
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Vous ne pouvez pas modifier cet avis.');
        }

        $review->load(['book', 'book.category']);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Vérifier que l'utilisateur peut éditer cet avis
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Vous ne pouvez pas modifier cet avis.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rating.required' => 'Veuillez donner une note.',
            'rating.between' => 'La note doit être comprise entre 1 et 5.',
            'comment.required' => 'Veuillez écrire un commentaire.',
            'comment.min' => 'Le commentaire doit contenir au moins 10 caractères.',
            'comment.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Repasser en attente d'approbation après modification
        ]);

        // L'analyse de sentiment se fait manuellement via le dashboard admin
        // AnalyzeReviewSentiment::dispatch($review);

        return redirect()->route('reviews.show', $review)
                        ->with('success', 'Votre avis a été mis à jour ! Il sera publié après modération.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Vérifier que l'utilisateur peut supprimer cet avis
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Vous ne pouvez pas supprimer cet avis.');
        }

        $bookTitle = $review->book->title;
        $review->delete();

        return redirect()->route('reviews.index')
                        ->with('success', "Votre avis pour \"{$bookTitle}\" a été supprimé.");
    }

    /**
     * Approve a review (Admin only).
     */
    public function approve(Review $review)
    {
        // Cette méthode pourrait être utilisée par les administrateurs
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    /**
     * Reject a review (Admin only).
     */
    public function reject(Review $review)
    {
        // Cette méthode pourrait être utilisée par les administrateurs
        $review->update(['is_approved' => false]);

        return back()->with('success', 'Avis rejeté.');
    }

    /**
     * Get reviews for a specific book (API endpoint or partial view).
     */
    public function getBookReviews(Book $book)
    {
        $reviews = $book->approvedReviews()
                       ->with('user')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('reviews.partials.book-reviews', compact('reviews', 'book'));
    }
}