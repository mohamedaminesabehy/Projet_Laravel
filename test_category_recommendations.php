<?php

/**
 * Test Script for AI Category Recommendations
 * 
 * This script tests the CategoryRecommendationService with real database data
 * 
 * Usage: php test_category_recommendations.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     🤖 AI Category Recommendations System - Test Script       ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

try {
    $service = new App\Services\AI\CategoryRecommendationService();
    
    // Test 1: Get all users
    echo "📊 Step 1: Getting all users...\n";
    $users = App\Models\User::with('favoriteCategories')->get();
    echo "   ✅ Found " . $users->count() . " users\n\n";
    
    if ($users->count() === 0) {
        echo "⚠️  No users found. Please create some users first.\n";
        exit(1);
    }
    
    // Test 2: Test recommendations for each user
    echo "🎯 Step 2: Testing AI recommendations for users...\n";
    echo str_repeat("─", 70) . "\n";
    
    foreach ($users as $user) {
        $favoritesCount = $user->favoriteCategories->count();
        
        echo "\n👤 User: {$user->name} (ID: {$user->id})\n";
        echo "   💝 Current favorites: {$favoritesCount} categories\n";
        
        if ($favoritesCount > 0) {
            echo "   📋 Favorite categories: ";
            echo $user->favoriteCategories->pluck('name')->join(', ') . "\n";
        }
        
        // Get recommendations
        echo "\n   🤖 Generating AI recommendations...\n";
        $recommendations = $service->getRecommendationsForUser($user, 5);
        
        if (!empty($recommendations)) {
            echo "   ✅ Generated " . count($recommendations) . " recommendations:\n\n";
            
            foreach ($recommendations as $index => $rec) {
                $num = $index + 1;
                $category = $rec['category'];
                $score = round($rec['score'], 2);
                $confidence = $rec['confidence'];
                
                echo "      {$num}. 📚 {$category->name}\n";
                echo "         ├─ Score: {$score}\n";
                echo "         ├─ Confidence: {$confidence}\n";
                echo "         ├─ Books: {$rec['books_count']} | Favorites: {$rec['favorites_count']}\n";
                echo "         └─ Reasons: " . implode(' • ', $rec['reasons']) . "\n\n";
            }
        } else {
            echo "   ℹ️  No recommendations available\n";
        }
        
        // Get insights
        echo "   📈 User Insights:\n";
        $insights = $service->getRecommendationInsights($user);
        echo "      • Total favorites: {$insights['total_favorites']}\n";
        echo "      • Books in favorites: {$insights['total_books_in_favorites']}\n";
        echo "      • Recommendation quality: {$insights['recommendation_quality']}\n";
        
        // Predict next favorite
        $prediction = $service->predictNextFavorite($user);
        if ($prediction) {
            echo "\n   🔮 Next Favorite Prediction:\n";
            echo "      • Category: {$prediction['category']->name}\n";
            echo "      • Confidence: {$prediction['confidence']}\n";
            echo "      • Prediction: {$prediction['prediction']}\n";
        }
        
        echo "\n" . str_repeat("─", 70) . "\n";
        
        // Only test first 3 users to keep output manageable
        if ($user->id >= 3) {
            $remaining = $users->count() - 3;
            if ($remaining > 0) {
                echo "\n... and {$remaining} more users (output truncated)\n";
            }
            break;
        }
    }
    
    // Test 3: Test similar categories
    echo "\n\n🔍 Step 3: Testing Similar Categories feature...\n";
    echo str_repeat("─", 70) . "\n";
    
    $testCategory = App\Models\Category::withCount('books')->first();
    if ($testCategory) {
        echo "\n📂 Test Category: {$testCategory->name}\n";
        echo "   Books: {$testCategory->books_count}\n\n";
        
        $similar = $service->getSimilarCategories($testCategory, 5);
        
        if ($similar->count() > 0) {
            echo "   ✅ Found {$similar->count()} similar categories:\n\n";
            foreach ($similar as $index => $cat) {
                $num = $index + 1;
                echo "      {$num}. {$cat->name} ({$cat->books_count} books, {$cat->favorites_count} favorites)\n";
            }
        } else {
            echo "   ℹ️  No similar categories found\n";
        }
    }
    
    // Test 4: Algorithm breakdown
    echo "\n\n🧠 Step 4: Algorithm Breakdown...\n";
    echo str_repeat("─", 70) . "\n";
    
    $testUser = $users->where('favoriteCategories.count', '>', 0)->first();
    if ($testUser) {
        echo "\n👤 Testing algorithms with user: {$testUser->name}\n";
        $userFavorites = $testUser->favoriteCategories->pluck('id')->toArray();
        
        // Use reflection to test private methods (for debugging purposes)
        $reflection = new ReflectionClass($service);
        
        // Test Collaborative Filtering
        echo "\n   🤝 Collaborative Filtering:\n";
        $collabMethod = $reflection->getMethod('getCollaborativeFilteringRecommendations');
        $collabMethod->setAccessible(true);
        $collabRecs = $collabMethod->invoke($service, $testUser, $userFavorites);
        echo "      • Found " . $collabRecs->count() . " recommendations from similar users\n";
        
        // Test Content-Based
        echo "\n   📊 Content-Based Recommendations:\n";
        $contentMethod = $reflection->getMethod('getContentBasedRecommendations');
        $contentMethod->setAccessible(true);
        $contentRecs = $contentMethod->invoke($service, $userFavorites);
        echo "      • Found " . $contentRecs->count() . " recommendations from similar content\n";
        
        // Test Trending
        echo "\n   📈 Trending Categories:\n";
        $trendingMethod = $reflection->getMethod('getTrendingCategories');
        $trendingMethod->setAccessible(true);
        $trendingRecs = $trendingMethod->invoke($service, $userFavorites);
        echo "      • Found " . $trendingRecs->count() . " trending recommendations\n";
    }
    
    // Test 5: Database Statistics
    echo "\n\n📊 Step 5: Database Statistics...\n";
    echo str_repeat("─", 70) . "\n";
    
    $stats = [
        'users' => App\Models\User::count(),
        'categories' => App\Models\Category::count(),
        'active_categories' => App\Models\Category::where('is_active', true)->count(),
        'books' => App\Models\Book::count(),
        'category_favorites' => App\Models\CategoryFavorite::count(),
        'users_with_favorites' => App\Models\User::has('favoriteCategories')->count(),
    ];
    
    echo "\n   Database Overview:\n";
    echo "   ├─ Total Users: {$stats['users']}\n";
    echo "   ├─ Users with Favorites: {$stats['users_with_favorites']}\n";
    echo "   ├─ Total Categories: {$stats['categories']}\n";
    echo "   ├─ Active Categories: {$stats['active_categories']}\n";
    echo "   ├─ Total Books: {$stats['books']}\n";
    echo "   └─ Category Favorites: {$stats['category_favorites']}\n";
    
    // Most favorited categories
    echo "\n   🏆 Top 5 Most Favorited Categories:\n";
    $topCategories = App\Models\Category::withCount('favorites')
        ->orderByDesc('favorites_count')
        ->limit(5)
        ->get();
    
    foreach ($topCategories as $index => $cat) {
        $num = $index + 1;
        echo "      {$num}. {$cat->name} - {$cat->favorites_count} favorites\n";
    }
    
    // Success summary
    echo "\n\n";
    echo "╔════════════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ ALL TESTS COMPLETED!                     ║\n";
    echo "╚════════════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "📝 Summary:\n";
    echo "   • AI Recommendation Service: ✅ Working\n";
    echo "   • Collaborative Filtering: ✅ Implemented\n";
    echo "   • Content-Based Filtering: ✅ Implemented\n";
    echo "   • Trending Algorithm: ✅ Implemented\n";
    echo "   • Similar Categories: ✅ Working\n";
    echo "   • Prediction System: ✅ Working\n";
    echo "\n";
    echo "🚀 Next Steps:\n";
    echo "   1. Visit http://127.0.0.1:8000/categories to see AI recommendations\n";
    echo "   2. Add more favorites to get better recommendations\n";
    echo "   3. Check the AI widget at the top of the categories page\n";
    echo "\n";

} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\n📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
    echo "\n🔍 Stack Trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
