<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewReactionController extends Controller
{
    /**
     * Store or update a reaction to a review.
     *
     * @param Request $request
     * @param int $reviewId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $reviewId)
    {
        $validator = Validator::make($request->all(), [
            'reaction_type' => 'required|in:like,dislike',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Type de réaction invalide',
                'errors' => $validator->errors()
            ], 422);
        }

        $review = Review::find($reviewId);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Avis non trouvé'
            ], 404);
        }

        // Empêcher l'utilisateur de réagir à son propre avis
        if ($review->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas réagir à votre propre avis'
            ], 403);
        }

        $userId = Auth::id();
        $reactionType = $request->input('reaction_type');

        // Vérifier si l'utilisateur a déjà réagi
        $existingReaction = ReviewReaction::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        if ($existingReaction) {
            // Si c'est la même réaction, la supprimer (toggle off)
            if ($existingReaction->reaction_type === $reactionType) {
                $existingReaction->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Réaction supprimée',
                    'action' => 'removed',
                    'reaction_type' => null,
                    'counts' => $this->getReactionCounts($reviewId)
                ]);
            }
            
            // Sinon, changer le type de réaction
            $existingReaction->reaction_type = $reactionType;
            $existingReaction->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Réaction mise à jour',
                'action' => 'updated',
                'reaction_type' => $reactionType,
                'counts' => $this->getReactionCounts($reviewId)
            ]);
        }

        // Créer une nouvelle réaction
        $reaction = ReviewReaction::create([
            'review_id' => $reviewId,
            'user_id' => $userId,
            'reaction_type' => $reactionType,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Réaction ajoutée',
            'action' => 'created',
            'reaction_type' => $reactionType,
            'counts' => $this->getReactionCounts($reviewId)
        ]);
    }

    /**
     * Get user's reaction for a specific review.
     *
     * @param int $reviewId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($reviewId)
    {
        $userId = Auth::id();
        
        $reaction = ReviewReaction::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        return response()->json([
            'success' => true,
            'reaction' => $reaction ? $reaction->reaction_type : null,
            'counts' => $this->getReactionCounts($reviewId)
        ]);
    }

    /**
     * Remove the user's reaction from a review.
     *
     * @param int $reviewId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($reviewId)
    {
        $userId = Auth::id();
        
        $reaction = ReviewReaction::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        if (!$reaction) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune réaction trouvée'
            ], 404);
        }

        $reaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Réaction supprimée',
            'counts' => $this->getReactionCounts($reviewId)
        ]);
    }

    /**
     * Get reaction counts for a review.
     *
     * @param int $reviewId
     * @return array
     */
    private function getReactionCounts($reviewId): array
    {
        $likes = ReviewReaction::where('review_id', $reviewId)
            ->where('reaction_type', 'like')
            ->count();
            
        $dislikes = ReviewReaction::where('review_id', $reviewId)
            ->where('reaction_type', 'dislike')
            ->count();

        return [
            'likes' => $likes,
            'dislikes' => $dislikes,
            'score' => $likes - $dislikes
        ];
    }

    /**
     * Get all reactions for a review with user details.
     *
     * @param int $reviewId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReviewReactions($reviewId)
    {
        $reactions = ReviewReaction::with('user:id,name')
            ->where('review_id', $reviewId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reaction) {
                return [
                    'id' => $reaction->id,
                    'user_name' => $reaction->user->name,
                    'reaction_type' => $reaction->reaction_type,
                    'created_at' => $reaction->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'reactions' => $reactions,
            'counts' => $this->getReactionCounts($reviewId)
        ]);
    }
}
