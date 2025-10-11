<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewReaction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReviewReactionController extends Controller
{
    /**
     * Display a listing of all review reactions.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = ReviewReaction::with(['review.book', 'review.user', 'user']);

        // Filter by reaction type
        if ($request->has('reaction_type') && $request->reaction_type !== '') {
            $query->where('reaction_type', $request->reaction_type);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }

        // Filter by review
        if ($request->has('review_id') && $request->review_id !== '') {
            $query->where('review_id', $request->review_id);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('review.book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date !== '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $reactions = $query->paginate(20)->withQueryString();

        // Get statistics
        $stats = $this->getStatistics($request);

        return view('admin.review-reactions.index', compact('reactions', 'stats'));
    }

    /**
     * Display the specified review reaction.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $reaction = ReviewReaction::with(['review.book', 'review.user', 'user'])
            ->findOrFail($id);

        return view('admin.review-reactions.show', compact('reaction'));
    }

    /**
     * Remove the specified review reaction from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $reaction = ReviewReaction::findOrFail($id);
        $reaction->delete();

        return redirect()
            ->route('admin.review-reactions.index')
            ->with('success', 'Réaction supprimée avec succès');
    }

    /**
     * Bulk delete review reactions.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'reaction_ids' => 'required|array',
            'reaction_ids.*' => 'exists:review_reactions,id',
        ]);

        ReviewReaction::whereIn('id', $request->reaction_ids)->delete();

        return redirect()
            ->route('admin.review-reactions.index')
            ->with('success', count($request->reaction_ids) . ' réaction(s) supprimée(s) avec succès');
    }

    /**
     * Get statistics based on filters.
     *
     * @param Request $request
     * @return array
     */
    private function getStatistics(Request $request): array
    {
        $query = ReviewReaction::query();

        // Apply same filters as index
        if ($request->has('reaction_type') && $request->reaction_type !== '') {
            $query->where('reaction_type', $request->reaction_type);
        }
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('review_id') && $request->review_id !== '') {
            $query->where('review_id', $request->review_id);
        }
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date !== '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $total = (clone $query)->count();
        $likes = (clone $query)->where('reaction_type', 'like')->count();
        $dislikes = (clone $query)->where('reaction_type', 'dislike')->count();

        return [
            'total' => $total,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'likes_percentage' => $total > 0 ? ($likes / $total) * 100 : 0,
            'dislikes_percentage' => $total > 0 ? ($dislikes / $total) * 100 : 0,
        ];
    }
}
