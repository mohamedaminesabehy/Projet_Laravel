<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookInsightsController extends Controller
{
    /**
     * Affiche la liste de tous les livres avec insights AI
     */
    public function index(Request $request)
    {
        // Filtres et tri
        $sortBy = $request->get('sort', 'reviews_count'); // Par défaut: plus populaires
        $sentiment = $request->get('sentiment'); // Filtrer par sentiment
        $search = $request->get('search'); // Recherche par titre/auteur
        
        // Query de base
        $query = Book::with(['insight', 'reviews', 'category'])
            ->whereHas('insight'); // Seulement les livres avec insights
        
        // Filtre par recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }
        
        // Filtre par sentiment
        if ($sentiment) {
            $query->whereHas('insight', function($q) use ($sentiment) {
                if ($sentiment === 'positive') {
                    $q->whereRaw('JSON_EXTRACT(sentiment_distribution, "$.positive") > JSON_EXTRACT(sentiment_distribution, "$.negative")');
                } elseif ($sentiment === 'negative') {
                    $q->whereRaw('JSON_EXTRACT(sentiment_distribution, "$.negative") > JSON_EXTRACT(sentiment_distribution, "$.positive")');
                } elseif ($sentiment === 'neutral') {
                    $q->whereRaw('JSON_EXTRACT(sentiment_distribution, "$.neutral") >= 40');
                }
            });
        }
        
        // Tri
        switch ($sortBy) {
            case 'reviews_count':
                $query->withCount('reviews')->orderBy('reviews_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'recent_insight':
                $query->join('book_insights', 'books.id', '=', 'book_insights.book_id')
                      ->orderBy('book_insights.last_generated_at', 'desc')
                      ->select('books.*');
                break;
            default:
                $query->withCount('reviews')->orderBy('reviews_count', 'desc');
        }
        
        // Pagination
        $books = $query->paginate(12);
        
        // Statistiques globales
        $stats = [
            'total_books' => Book::whereHas('insight')->count(),
            'total_reviews' => BookInsight::sum('total_reviews'),
            'avg_positive' => BookInsight::avg('average_rating'),
            'recent_updates' => BookInsight::where('last_generated_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('ai-insights.index', compact('books', 'stats', 'sortBy', 'sentiment', 'search'));
    }
    
    /**
     * Affiche les détails d'un insight AI pour un livre spécifique
     */
    public function show(Book $book)
    {
        // Charger le livre avec toutes ses relations
        $book->load(['insight', 'reviews' => function($query) {
            $query->where('status', 'approved')
                  ->with('user')
                  ->latest()
                  ->take(10);
        }, 'category']);
        
        // Vérifier si le livre a un insight
        if (!$book->insight) {
            return redirect()->route('ai-insights.index')
                ->with('error', 'Ce livre n\'a pas encore d\'analyse AI générée.');
        }
        
        // Statistiques supplémentaires
        $reviewsStats = [
            'total' => $book->reviews()->where('status', 'approved')->count(),
            'with_sentiment' => $book->reviews()->where('status', 'approved')->whereNotNull('sentiment_score')->count(),
            'avg_rating' => $book->reviews()->where('status', 'approved')->avg('rating'),
        ];
        
        return view('ai-insights.show', compact('book', 'reviewsStats'));
    }
    
    /**
     * Génère les AI Insights pour tous les livres éligibles
     */
    public function generateAll(Request $request)
    {
        try {
            $generated = 0;
            $skipped = 0;
            $errors = 0;
            
            // Trouver tous les livres avec 3+ avis analysés qui n'ont pas encore d'insight
            $eligibleBooks = Book::select('books.*')
                ->join('reviews', 'books.id', '=', 'reviews.book_id')
                ->whereNotNull('reviews.analyzed_at')
                ->where('reviews.status', 'approved')
                ->groupBy('books.id')
                ->havingRaw('COUNT(reviews.id) >= 3')
                ->doesntHave('insight')
                ->get();
            
            foreach ($eligibleBooks as $book) {
                try {
                    // Dispatcher le job de génération
                    \App\Jobs\GenerateBookInsightJob::dispatch($book);
                    $generated++;
                } catch (\Exception $e) {
                    Log::error("Erreur lors de la génération d'insight pour le livre {$book->id}: " . $e->getMessage());
                    $errors++;
                }
            }
            
            // Compter les livres qui ont déjà des insights
            $existingInsights = Book::has('insight')->count();
            
            if ($generated > 0) {
                $message = "✅ Génération lancée pour {$generated} livre(s). Les insights apparaîtront dans quelques instants.";
                if ($existingInsights > 0) {
                    $message .= " ({$existingInsights} insight(s) déjà existant(s))";
                }
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'generated' => $generated,
                    'existing' => $existingInsights,
                    'errors' => $errors
                ]);
            } else {
                $message = "ℹ️ Aucun nouveau livre éligible trouvé.";
                if ($existingInsights > 0) {
                    $message .= " {$existingInsights} insight(s) déjà généré(s).";
                } else {
                    $message .= " Assurez-vous que les avis sont analysés (3 avis minimum par livre).";
                }
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'generated' => 0,
                    'existing' => $existingInsights,
                    'errors' => 0
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération globale des insights: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "❌ Erreur: " . $e->getMessage()
            ], 500);
        }
    }
}
