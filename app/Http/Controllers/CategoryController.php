<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\AI\CategoryRecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryRecommendationService $recommendationService;

    public function __construct(CategoryRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Display a listing of all categories with favorite status
     */
    public function index(): View
    {
        // Get all active categories with book count and favorite status
        $categories = Category::active()
            ->withCount(['books', 'favorites'])
            ->with(['user'])
            ->orderBy('name')
            ->get();

        // Get user's favorite categories count if authenticated
        $userFavoritesCount = 0;
        if (Auth::check()) {
            $userFavoritesCount = Auth::user()->favorite_categories_count;
        }

        return view('categories.index', compact('categories', 'userFavoritesCount'));
    }

    /**
     * Show category details
     */
    public function show(Category $category): View
    {
        $category->load(['books' => function ($query) {
            $query->with('user')->latest()->take(12);
        }]);
        
        $category->loadCount(['books', 'favorites']);

        return view('categories.show', compact('category'));
    }

    /**
     * Get AI-powered category recommendations for the authenticated user
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to get recommendations',
                'recommendations' => [],
            ], 401);
        }

        $user = Auth::user();
        $limit = $request->input('limit', 5);

        try {
            $recommendations = $this->recommendationService->getRecommendationsForUser($user, $limit);
            $insights = $this->recommendationService->getRecommendationInsights($user);

            return response()->json([
                'success' => true,
                'recommendations' => $recommendations,
                'insights' => $insights,
                'message' => count($recommendations) > 0 
                    ? 'AI recommendations generated successfully' 
                    : 'No new recommendations available',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating recommendations: ' . $e->getMessage(),
                'recommendations' => [],
            ], 500);
        }
    }

    /**
     * Predict next favorite category for the user
     */
    public function predictNextFavorite(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        try {
            $prediction = $this->recommendationService->predictNextFavorite(Auth::user());

            return response()->json([
                'success' => true,
                'prediction' => $prediction,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error predicting next favorite: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get similar categories to a given category
     */
    public function getSimilarCategories(Category $category, Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 5);
            $similar = $this->recommendationService->getSimilarCategories($category, $limit);

            return response()->json([
                'success' => true,
                'similar_categories' => $similar,
                'category' => $category->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error finding similar categories: ' . $e->getMessage(),
            ], 500);
        }
    }
}
