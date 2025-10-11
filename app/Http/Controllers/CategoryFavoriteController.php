<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryFavorite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CategoryFavoriteController extends Controller
{
    /**
     * Display a listing of user's favorite categories
     */
    public function index(): View
    {
        $user = Auth::user();
        
        $favoriteCategories = $user->favoriteCategories()
            ->withCount('books')
            ->with('user')
            ->orderBy('category_favorites.created_at', 'desc')
            ->paginate(12);

        $stats = [
            'total_favorites' => $user->favorite_categories_count,
            'active_categories' => $user->favoriteCategories()->where('is_active', true)->count(),
            'total_books' => $user->favoriteCategories()->withCount('books')->get()->sum('books_count'),
        ];

        return view('category-favorites.index', compact('favoriteCategories', 'stats'));
    }

    /**
     * Toggle favorite status for a category (add or remove)
     */
    public function toggle(Request $request, Category $category): JsonResponse|RedirectResponse
    {
        $request->validate([
            'category_id' => 'sometimes|exists:categories,id'
        ]);

        $userId = Auth::id();
        $categoryId = $category->id;

        // Toggle the favorite
        $isFavorited = CategoryFavorite::toggle($userId, $categoryId);

        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'favorited' => $isFavorited,
                'message' => $isFavorited 
                    ? 'Catégorie ajoutée aux favoris' 
                    : 'Catégorie retirée des favoris',
                'favorites_count' => CategoryFavorite::countForCategory($categoryId),
            ]);
        }

        // Regular request - redirect back with message
        $message = $isFavorited 
            ? 'La catégorie "' . $category->name . '" a été ajoutée à vos favoris!' 
            : 'La catégorie "' . $category->name . '" a été retirée de vos favoris.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Add a category to favorites
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id'
        ]);

        $userId = Auth::id();
        $categoryId = $request->category_id;

        // Check if already favorited
        if (CategoryFavorite::isFavorited($userId, $categoryId)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette catégorie est déjà dans vos favoris',
                ], 400);
            }
            return redirect()->back()->with('error', 'Cette catégorie est déjà dans vos favoris');
        }

        // Create favorite
        CategoryFavorite::create([
            'user_id' => $userId,
            'category_id' => $categoryId,
        ]);

        $category = Category::find($categoryId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie ajoutée aux favoris',
                'favorites_count' => CategoryFavorite::countForCategory($categoryId),
            ]);
        }

        return redirect()->back()->with('success', 'La catégorie "' . $category->name . '" a été ajoutée à vos favoris!');
    }

    /**
     * Remove a category from favorites
     */
    public function destroy(Category $category): JsonResponse|RedirectResponse
    {
        $userId = Auth::id();
        $categoryId = $category->id;

        $favorite = CategoryFavorite::where('user_id', $userId)
                                   ->where('category_id', $categoryId)
                                   ->first();

        if (!$favorite) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette catégorie n\'est pas dans vos favoris',
                ], 404);
            }
            return redirect()->back()->with('error', 'Cette catégorie n\'est pas dans vos favoris');
        }

        $favorite->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie retirée des favoris',
                'favorites_count' => CategoryFavorite::countForCategory($categoryId),
            ]);
        }

        return redirect()->back()->with('success', 'La catégorie "' . $category->name . '" a été retirée de vos favoris.');
    }

    /**
     * Get most favorited categories
     */
    public function mostFavorited(Request $request): JsonResponse|View
    {
        $limit = $request->input('limit', 10);
        
        $categories = Category::withCount('favorites')
            ->orderByDesc('favorites_count')
            ->limit($limit)
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        }

        return view('category-favorites.most-favorited', compact('categories'));
    }

    /**
     * Get user's favorite categories (API endpoint)
     */
    public function userFavorites(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $favorites = $user->favoriteCategories()
            ->withCount('books')
            ->get();

        return response()->json([
            'success' => true,
            'total' => $favorites->count(),
            'categories' => $favorites,
        ]);
    }

    /**
     * Check if category is favorited by current user
     */
    public function check(Category $category): JsonResponse
    {
        $userId = Auth::id();
        $isFavorited = CategoryFavorite::isFavorited($userId, $category->id);

        return response()->json([
            'success' => true,
            'favorited' => $isFavorited,
            'favorites_count' => CategoryFavorite::countForCategory($category->id),
        ]);
    }

    /**
     * Get statistics about category favorites
     */
    public function statistics(): JsonResponse
    {
        $user = Auth::user();

        $stats = [
            'total_favorites' => CategoryFavorite::countByUser($user->id),
            'recent_favorites' => CategoryFavorite::byUser($user->id)->recent()->count(),
            'active_categories' => $user->favoriteCategories()->where('is_active', true)->count(),
            'total_books_in_favorites' => $user->favoriteCategories()
                ->withCount('books')
                ->get()
                ->sum('books_count'),
            'most_favorited_category' => Category::withCount('favorites')
                ->orderByDesc('favorites_count')
                ->first(),
        ];

        return response()->json([
            'success' => true,
            'statistics' => $stats,
        ]);
    }
}
