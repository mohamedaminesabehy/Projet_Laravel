<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BookInsightsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdminReviewStatisticsController;
use App\Http\Controllers\Admin\AdminReviewReactionController;
use App\Http\Controllers\Admin\AdminSentimentController;
use App\Http\Controllers\Admin\AdminCategoryStatisticsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewReactionController;
use App\Http\Controllers\CategoryFavoriteController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'show'])->defaults('page', 'index')->name('home');

Route::get('/about', [PageController::class, 'show'])->defaults('page', 'about')->name('about');
Route::get('/contact', [PageController::class, 'show'])->defaults('page', 'contact')->name('contact');
Route::get('/shop', [PageController::class, 'show'])->defaults('page', 'shop')->name('shop');
Route::get('/blog', [PageController::class, 'show'])->defaults('page', 'blog')->name('blog');
Route::get('/404', [PageController::class, 'show'])->defaults('page', '404')->name('404');
Route::get('/author-details', [PageController::class, 'show'])->defaults('page', 'author-details')->name('author-details');
Route::get('/author', [PageController::class, 'show'])->defaults('page', 'author')->name('author');
Route::get('/blog-details', [PageController::class, 'show'])->defaults('page', 'blog-details')->name('blog-details');
Route::get('/blog-sidebar-2', [PageController::class, 'show'])->defaults('page', 'blog-sidebar-2')->name('blog-sidebar-2');
Route::get('/blog-sidebar', [PageController::class, 'show'])->defaults('page', 'blog-sidebar')->name('blog-sidebar');
Route::get('/blog-standard', [PageController::class, 'show'])->defaults('page', 'blog-standard')->name('blog-standard');
Route::get('/cart', [PageController::class, 'show'])->defaults('page', 'cart')->name('cart');
Route::get('/checkout', [PageController::class, 'show'])->defaults('page', 'checkout')->name('checkout');
Route::get('/favorites', [PageController::class, 'show'])->defaults('page', 'favorites')->name('favorites');
Route::get('/profile', [PageController::class, 'show'])->defaults('page', 'profile')->name('profile');
Route::get('/shop-details', [PageController::class, 'show'])->defaults('page', 'shop-details')->name('shop-details');
Route::get('/shop-sidebar', [PageController::class, 'show'])->defaults('page', 'shop-sidebar')->name('shop-sidebar');
Route::get('/signin', [PageController::class, 'show'])->defaults('page', 'signin')->name('signin');
Route::get('/signup', [PageController::class, 'show'])->defaults('page', 'signup')->name('signup');
Route::get('/vendor-details', [PageController::class, 'show'])->defaults('page', 'vendor-details')->name('vendor-details');
Route::get('/vendor', [PageController::class, 'show'])->defaults('page', 'vendor')->name('vendor');
Route::get('/wishlist', [PageController::class, 'show'])->defaults('page', 'wishlist')->name('wishlist');

// Routes pour les avis (Reviews)
Route::middleware(['auth'])->group(function () {
    Route::resource('reviews', ReviewController::class);
    Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    
    // Routes pour les réactions aux avis
    Route::post('reviews/{review}/reactions', [ReviewReactionController::class, 'store'])->name('reviews.reactions.store');
    Route::get('reviews/{review}/reactions', [ReviewReactionController::class, 'show'])->name('reviews.reactions.show');
    Route::delete('reviews/{review}/reactions', [ReviewReactionController::class, 'destroy'])->name('reviews.reactions.destroy');
    Route::get('reviews/{review}/reactions/list', [ReviewReactionController::class, 'getReviewReactions'])->name('reviews.reactions.list');
    
    // Routes pour les favoris de catégories
    Route::get('category-favorites', [CategoryFavoriteController::class, 'index'])->name('category-favorites.index');
    Route::post('category-favorites/toggle/{category}', [CategoryFavoriteController::class, 'toggle'])->name('category-favorites.toggle');
    Route::post('category-favorites', [CategoryFavoriteController::class, 'store'])->name('category-favorites.store');
    Route::delete('category-favorites/{category}', [CategoryFavoriteController::class, 'destroy'])->name('category-favorites.destroy');
    Route::get('category-favorites/check/{category}', [CategoryFavoriteController::class, 'check'])->name('category-favorites.check');
    Route::get('category-favorites/statistics', [CategoryFavoriteController::class, 'statistics'])->name('category-favorites.statistics');
    Route::get('category-favorites/user', [CategoryFavoriteController::class, 'userFavorites'])->name('category-favorites.user');
});

// Route pour AI Insights (publique)
Route::get('/ai-insights', [BookInsightsController::class, 'index'])->name('ai-insights.index');
Route::get('/ai-insights/{book}', [BookInsightsController::class, 'show'])->name('ai-insights.show');

// Routes publiques pour les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// AI Category Recommendations Routes (must be before {category} route)
Route::get('/categories/ai-recommendations', [CategoryController::class, 'getRecommendations'])->name('categories.ai-recommendations');
Route::get('/categories/ai-predict', [CategoryController::class, 'predictNextFavorite'])->name('categories.ai-predict');
Route::get('/categories/{category}/similar', [CategoryController::class, 'getSimilarCategories'])->name('categories.similar');

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Route publique pour les catégories les plus favorites
Route::get('/category-favorites/most-favorited', [CategoryFavoriteController::class, 'mostFavorited'])->name('category-favorites.most-favorited');

// Route publique pour voir les avis d'un livre spécifique
Route::get('books/{book}/reviews', [ReviewController::class, 'getBookReviews'])->name('books.reviews');

// Route de test CRUD favoris
Route::get('/test-favoris-crud', function () {
    return view('test-favoris-crud');
})->middleware('auth')->name('test.favoris.crud');

// Routes de connexion simple pour tester
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $user = User::where('email', 'test@example.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect('/reviews')->with('success', 'Connexion réussie !');
    }
    return back()->with('error', 'Utilisateur non trouvé');
})->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Déconnexion réussie !');
})->name('logout');

// Route temporaire pour se connecter automatiquement comme admin
Route::get('/admin-login', function () {
    $user = User::first(); // Prendre le premier utilisateur
    if ($user) {
        Auth::login($user);
        return redirect('/admin/categories')->with('success', 'Connexion admin réussie !');
    }
    return redirect('/')->with('error', 'Aucun utilisateur trouvé');
})->name('admin.login.temp');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/authors', [AdminController::class, 'authors'])->name('authors');
    Route::get('/books', [AdminController::class, 'books'])->name('books');
    
    // Routes pour la gestion des catégories
    // IMPORTANT: Routes spécifiques AVANT les routes avec paramètres
    Route::get('categories/statistics', [AdminCategoryStatisticsController::class, 'index'])->name('categories.statistics');
    Route::get('categories/statistics/chart-data', [AdminCategoryStatisticsController::class, 'getChartData'])->name('categories.statistics.chart-data');
    Route::get('categories/statistics/export', [AdminCategoryStatisticsController::class, 'export'])->name('categories.statistics.export');
    
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/{category}', [AdminCategoryController::class, 'show'])->name('categories.show');
    Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::get('categories/{category}/details', [AdminCategoryController::class, 'getDetails'])->name('categories.details');
    Route::get('categories/{category}/edit-form', [AdminCategoryController::class, 'getEditForm'])->name('categories.edit-form');
    
    // Routes pour les statistiques des reviews
    Route::get('statistics/reviews', [AdminReviewStatisticsController::class, 'index'])->name('statistics.reviews');
    Route::get('statistics/reviews/analytics', [AdminReviewStatisticsController::class, 'getAnalyticsData'])->name('statistics.reviews.analytics');
    Route::get('statistics/reviews/export', [AdminReviewStatisticsController::class, 'export'])->name('statistics.reviews.export');
    Route::post('statistics/reviews/compare', [AdminReviewStatisticsController::class, 'comparePeriods'])->name('statistics.reviews.compare');
    
    // Routes pour la gestion des réactions aux avis (Admin)
    Route::get('review-reactions', [AdminReviewReactionController::class, 'index'])->name('review-reactions.index');
    Route::get('review-reactions/{reaction}', [AdminReviewReactionController::class, 'show'])->name('review-reactions.show');
    Route::delete('review-reactions/{reaction}', [AdminReviewReactionController::class, 'destroy'])->name('review-reactions.destroy');
    Route::post('review-reactions/bulk-delete', [AdminReviewReactionController::class, 'bulkDelete'])->name('review-reactions.bulk-delete');
    
    // Routes pour l'analyse de sentiment AI
    Route::get('sentiment', [AdminSentimentController::class, 'index'])->name('sentiment.index');
    Route::get('sentiment/{review}', [AdminSentimentController::class, 'show'])->name('sentiment.show');
    Route::post('sentiment/{review}/reanalyze', [AdminSentimentController::class, 'reanalyze'])->name('sentiment.reanalyze');
    Route::post('sentiment/bulk-analyze', [AdminSentimentController::class, 'bulkAnalyze'])->name('sentiment.bulk-analyze');
    Route::get('sentiment/analytics/data', [AdminSentimentController::class, 'analytics'])->name('sentiment.analytics');
    Route::get('sentiment/export/csv', [AdminSentimentController::class, 'export'])->name('sentiment.export');
    
    Route::get('/exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('/authors/add', [AdminController::class, 'addAuthor'])->name('add-author');
    Route::get('/books/add', [AdminController::class, 'addBook'])->name('add-book');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});
