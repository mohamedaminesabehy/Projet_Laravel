<?php

namespace App\Services\AI;

use App\Models\Category;
use App\Models\CategoryFavorite;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CategoryRecommendationService
{
    /**
     * Get personalized category recommendations for a user
     */
    public function getRecommendationsForUser(User $user, int $limit = 5): array
    {
        // Get user's favorite categories
        $userFavorites = $user->favoriteCategories()->pluck('categories.id')->toArray();

        if (empty($userFavorites)) {
            // If user has no favorites, recommend popular categories
            return $this->getPopularCategories($limit);
        }

        // Get recommendations using multiple algorithms
        $collaborativeRecommendations = $this->getCollaborativeFilteringRecommendations($user, $userFavorites);
        $contentBasedRecommendations = $this->getContentBasedRecommendations($userFavorites);
        $trendingRecommendations = $this->getTrendingCategories($userFavorites);

        // Merge and score recommendations
        $recommendations = $this->mergeAndScoreRecommendations([
            'collaborative' => $collaborativeRecommendations,
            'content_based' => $contentBasedRecommendations,
            'trending' => $trendingRecommendations,
        ]);

        // Exclude already favorited categories
        $recommendations = $recommendations->filter(function ($item) use ($userFavorites) {
            return !in_array($item['category_id'], $userFavorites);
        });

        // Return top recommendations
        return $recommendations->take($limit)->values()->toArray();
    }

    /**
     * Collaborative Filtering: Find categories liked by similar users
     */
    private function getCollaborativeFilteringRecommendations(User $user, array $userFavorites): Collection
    {
        // Find users with similar taste (users who favorited same categories)
        $similarUsers = CategoryFavorite::whereIn('category_id', $userFavorites)
            ->where('user_id', '!=', $user->id)
            ->select('user_id', DB::raw('COUNT(*) as similarity_score'))
            ->groupBy('user_id')
            ->orderByDesc('similarity_score')
            ->limit(20)
            ->pluck('user_id');

        if ($similarUsers->isEmpty()) {
            return collect();
        }

        // Get categories favorited by similar users
        return CategoryFavorite::whereIn('user_id', $similarUsers)
            ->whereNotIn('category_id', $userFavorites)
            ->select('category_id', DB::raw('COUNT(*) as score'))
            ->groupBy('category_id')
            ->orderByDesc('score')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'score' => $item->score * 3, // Weight collaborative filtering higher
                    'reason' => 'Users with similar taste love this category',
                ];
            });
    }

    /**
     * Content-Based: Find similar categories based on characteristics
     */
    private function getContentBasedRecommendations(array $userFavorites): Collection
    {
        // Get user's favorite categories details
        $favoriteCategories = Category::whereIn('id', $userFavorites)->get();

        // Find categories with similar characteristics
        $recommendations = collect();

        foreach ($favoriteCategories as $favCategory) {
            // Find categories with similar name patterns or created by same user
            $similar = Category::where('id', '!=', $favCategory->id)
                ->whereNotIn('id', $userFavorites)
                ->where(function ($query) use ($favCategory) {
                    // Similar name patterns (e.g., "Science Fiction" and "Science")
                    $keywords = explode(' ', $favCategory->name);
                    foreach ($keywords as $keyword) {
                        if (strlen($keyword) > 3) {
                            $query->orWhere('name', 'LIKE', "%{$keyword}%");
                        }
                    }
                    // Same creator (if user-created categories)
                    if ($favCategory->user_id) {
                        $query->orWhere('user_id', $favCategory->user_id);
                    }
                })
                ->withCount('books', 'favorites')
                ->get()
                ->map(function ($cat) {
                    return [
                        'category_id' => $cat->id,
                        'score' => ($cat->books_count * 0.5) + ($cat->favorites_count * 2),
                        'reason' => 'Similar to categories you already love',
                    ];
                });

            $recommendations = $recommendations->merge($similar);
        }

        // Group by category_id and sum scores
        return $recommendations->groupBy('category_id')->map(function ($items) {
            return [
                'category_id' => $items->first()['category_id'],
                'score' => $items->sum('score') * 2,
                'reason' => $items->first()['reason'],
            ];
        })->values();
    }

    /**
     * Trending: Find categories gaining popularity
     */
    private function getTrendingCategories(array $excludeIds = []): Collection
    {
        // Get categories with recent growth in favorites
        $recentFavorites = CategoryFavorite::where('created_at', '>=', now()->subDays(30))
            ->whereNotIn('category_id', $excludeIds)
            ->select('category_id', DB::raw('COUNT(*) as recent_count'))
            ->groupBy('category_id')
            ->orderByDesc('recent_count')
            ->limit(10)
            ->get();

        return $recentFavorites->map(function ($item) {
            return [
                'category_id' => $item->category_id,
                'score' => $item->recent_count * 1.5,
                'reason' => 'Trending now - gaining popularity',
            ];
        });
    }

    /**
     * Get popular categories (fallback for new users)
     */
    private function getPopularCategories(int $limit = 5): array
    {
        $popular = Category::withCount(['favorites', 'books'])
            ->where('is_active', true)
            ->orderByDesc('favorites_count')
            ->orderByDesc('books_count')
            ->limit($limit)
            ->get();

        return $popular->map(function ($category) {
            return [
                'category_id' => $category->id,
                'category' => $category,
                'score' => ($category->favorites_count * 2) + $category->books_count,
                'reason' => 'Popular choice among all users',
                'confidence' => 'high',
            ];
        })->toArray();
    }

    /**
     * Merge and score recommendations from different algorithms
     */
    private function mergeAndScoreRecommendations(array $sources): Collection
    {
        $merged = collect();

        foreach ($sources as $source => $recommendations) {
            foreach ($recommendations as $rec) {
                $merged->push($rec);
            }
        }

        // Group by category_id and sum scores
        $grouped = $merged->groupBy('category_id')->map(function ($items, $categoryId) {
            $totalScore = $items->sum('score');
            $reasons = $items->pluck('reason')->unique()->toArray();
            
            // Load category details
            $category = Category::with('user')
                ->withCount(['books', 'favorites'])
                ->find($categoryId);

            if (!$category) {
                return null;
            }

            // Calculate confidence based on number of algorithms agreeing
            $confidence = 'low';
            if ($items->count() >= 3) {
                $confidence = 'high';
            } elseif ($items->count() >= 2) {
                $confidence = 'medium';
            }

            return [
                'category_id' => $categoryId,
                'category' => $category,
                'score' => $totalScore,
                'reasons' => $reasons,
                'confidence' => $confidence,
                'books_count' => $category->books_count,
                'favorites_count' => $category->favorites_count,
            ];
        })->filter()->sortByDesc('score');

        return $grouped->values();
    }

    /**
     * Get AI insights about recommendations
     */
    public function getRecommendationInsights(User $user): array
    {
        $userFavorites = $user->favoriteCategories()->withCount('books')->get();
        
        $insights = [
            'total_favorites' => $userFavorites->count(),
            'total_books_in_favorites' => $userFavorites->sum('books_count'),
            'most_popular_category' => $userFavorites->sortByDesc('books_count')->first(),
            'recommendation_quality' => $this->assessRecommendationQuality($user),
        ];

        return $insights;
    }

    /**
     * Assess the quality of recommendations based on user activity
     */
    private function assessRecommendationQuality(User $user): string
    {
        $favoritesCount = $user->favoriteCategories()->count();

        if ($favoritesCount >= 5) {
            return 'excellent - based on your rich favorite history';
        } elseif ($favoritesCount >= 3) {
            return 'good - we\'re learning your preferences';
        } elseif ($favoritesCount >= 1) {
            return 'fair - add more favorites for better recommendations';
        } else {
            return 'basic - based on popular choices';
        }
    }

    /**
     * Predict next favorite category for a user
     */
    public function predictNextFavorite(User $user): ?array
    {
        $recommendations = $this->getRecommendationsForUser($user, 1);

        if (empty($recommendations)) {
            return null;
        }

        $topRecommendation = $recommendations[0];

        return [
            'category' => $topRecommendation['category'],
            'confidence' => $topRecommendation['confidence'],
            'prediction' => "Based on your taste, we predict you'll love {$topRecommendation['category']->name}",
            'score' => round($topRecommendation['score'], 2),
        ];
    }

    /**
     * Find similar categories to a given category
     */
    public function getSimilarCategories(Category $category, int $limit = 5): Collection
    {
        // Find categories with similar characteristics
        $keywords = explode(' ', $category->name);
        
        $similar = Category::where('id', '!=', $category->id)
            ->where('is_active', true)
            ->where(function ($query) use ($keywords, $category) {
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 3) {
                        $query->orWhere('name', 'LIKE', "%{$keyword}%");
                    }
                }
                // Same creator
                if ($category->user_id) {
                    $query->orWhere('user_id', $category->user_id);
                }
            })
            ->withCount(['books', 'favorites'])
            ->limit($limit)
            ->get();

        return $similar;
    }
}
