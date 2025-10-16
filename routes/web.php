<?php

use App\Http\Controllers\AiSummaryController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BookInsightsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminCategoryStatisticsController;
use App\Http\Controllers\Admin\AdminReviewStatisticsController;
use App\Http\Controllers\Admin\AdminReviewReactionController;
use App\Http\Controllers\Admin\AdminSentimentController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CategoryFavoriteController;
use App\Http\Controllers\ReviewController;

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
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/blog', [PageController::class, 'show'])->defaults('page', 'blog')->name('blog');
Route::get('/404', [PageController::class, 'show'])->defaults('page', '404')->name('404');
Route::get('/author-details', [PageController::class, 'show'])->defaults('page', 'author-details')->name('author-details');
Route::get('/author', [PageController::class, 'show'])->defaults('page', 'author')->name('author');
Route::get('/blog-details', [PageController::class, 'show'])->defaults('page', 'blog-details')->name('blog-details');
Route::get('/blog-sidebar-2', [PageController::class, 'show'])->defaults('page', 'blog-sidebar-2')->name('blog-sidebar-2');
Route::get('/blog-sidebar', [PageController::class, 'show'])->defaults('page', 'blog-sidebar')->name('blog-sidebar');
Route::get('/blog-standard', [PageController::class, 'show'])->defaults('page', 'blog-standard')->name('blog-standard');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/checkout', [PageController::class, 'show'])->defaults('page', 'checkout')->name('checkout');
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [\App\Http\Controllers\CategoryFavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle/{category}', [\App\Http\Controllers\CategoryFavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/favorites', [\App\Http\Controllers\CategoryFavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{category}', [\App\Http\Controllers\CategoryFavoriteController::class, 'destroy'])->name('favorites.destroy');
});
Route::get('/profile', [PageController::class, 'show'])->defaults('page', 'profile')->name('profile');
// Breeze nav expects a 'dashboard' route; redirect to home to avoid 404
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');
// Breeze nav expects 'profile.edit'; map to existing profile page
Route::get('/profile/edit', [PageController::class, 'show'])
    ->defaults('page', 'profile')
    ->middleware(['auth'])
    ->name('profile.edit');
Route::get('/shop-details/{id}', [PageController::class, 'bookDetails'])->name('shop-details');
Route::get('/api/ai-summary/{id}', [AiSummaryController::class, 'getSummary'])->name('api.ai-summary');
Route::get('/shop-sidebar', [PageController::class, 'show'])->defaults('page', 'shop-sidebar')->name('shop-sidebar');

// Pages publiques supplémentaires
Route::get('/ai-insights', [BookInsightsController::class, 'index'])->name('ai-insights.index');
Route::get('/ai-insights/{book}', [BookInsightsController::class, 'show'])->name('ai-insights.show');

// Reviews (liste publique + CRUD basique)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Routes pour les réactions aux avis
    Route::post('/reviews/{review}/reactions', [ReviewController::class, 'addReaction'])->name('reviews.reactions.store');
    Route::get('/reviews/{review}/reactions/list', [ReviewController::class, 'getReactions'])->name('reviews.reactions.list');
});
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

// Pages d'auth (GET) via Breeze, en conservant les vues thémées
Route::get('/signin', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('signin');
Route::get('/signup', [RegisteredUserController::class, 'create'])->middleware('guest')->name('signup');

Route::get('/vendor-details', [PageController::class, 'show'])->defaults('page', 'vendor-details')->name('vendor-details');
Route::get('/vendor', [PageController::class, 'show'])->defaults('page', 'vendor')->name('vendor');
Route::get('/wishlist', [PageController::class, 'show'])->defaults('page', 'wishlist')->name('wishlist');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'bulkUpdate'])->name('cart.bulkUpdate');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
});

// API Routes for AI features
Route::post('/api/purchase-encouragement', [\App\Http\Controllers\PurchaseEncouragementController::class, 'generateEncouragement'])->name('api.purchase-encouragement');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/authors', [AdminController::class, 'authors'])->name('authors');
    // Routes de gestion des livres (resource)
    Route::resource('books', AdminBookController::class)->names([
        'index' => 'books',
        'create' => 'books.create',
        'store' => 'books.store',
        'show' => 'books.show',
        'edit' => 'books.edit',
        'update' => 'books.update',
        'destroy' => 'books.destroy',
    ]);
    
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

// Routes publiques pour les catégories
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/ai-recommendations', [\App\Http\Controllers\CategoryController::class, 'getRecommendations'])->name('categories.ai-recommendations');
Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

// Routes PayPal
Route::post('/paypal/process', [\App\Http\Controllers\PayPalController::class, 'processPayment'])->name('paypal.process');
Route::get('/paypal/success', [\App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [\App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');

// Routes Breeze (login, register, logout, etc.)
require __DIR__.'/auth.php';
