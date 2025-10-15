<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\TrustScoreController;
use App\Http\Controllers\EventController as FrontEventController;
use App\Http\Controllers\EventController;


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
Route::get('/favorites', [PageController::class, 'show'])->defaults('page', 'favorites')->name('favorites');
Route::get('/profile', [PageController::class, 'show'])->defaults('page', 'profile')->name('profile');
Route::get('/shop-details/{id}', [PageController::class, 'bookDetails'])->name('shop-details');
Route::get('/shop-sidebar', [PageController::class, 'show'])->defaults('page', 'shop-sidebar')->name('shop-sidebar');
Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin.post');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/vendor-details', [PageController::class, 'show'])->defaults('page', 'vendor-details')->name('vendor-details');
Route::get('/vendor', [PageController::class, 'show'])->defaults('page', 'vendor')->name('vendor');
Route::get('/wishlist', [PageController::class, 'show'])->defaults('page', 'wishlist')->name('wishlist');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/authors', [AdminController::class, 'authors'])->name('authors');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('/authors/add', [AdminController::class, 'addAuthor'])->name('add-author');
    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('add-category');
    
    // Routes pour les événements pour admin 
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::resource('books', AdminBookController::class);
    
    // Routes pour les rendez-vous (Meetings) - Admin
    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/', [AdminMeetingController::class, 'index'])->name('index');
        Route::get('/dashboard', [AdminMeetingController::class, 'dashboard'])->name('dashboard');
        Route::get('/export', [AdminMeetingController::class, 'export'])->name('export');
        Route::get('/export-pdf', [AdminMeetingController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/{id}/cancel', [AdminMeetingController::class, 'cancel'])->name('cancel');
        Route::delete('/{id}', [AdminMeetingController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [AdminMeetingController::class, 'show'])->name('show');
    });

    // route event for user  
Route::middleware('auth')->prefix('events')->name('events.')->group(function () {
    Route::get('/', [FrontEventController::class, 'index'])->name('index');     // /events
    Route::get('/{event}', [FrontEventController::class, 'show'])->name('show'); // /events/{event}
});

    
    
    // Routes pour les Scores de Confiance IA (Trust Scores) - Admin
    Route::prefix('trust-scores')->name('trust-scores.')->group(function () {
        Route::get('/', [TrustScoreController::class, 'index'])->name('index'); // Dashboard principal
        Route::get('/users', [TrustScoreController::class, 'users'])->name('users'); // Liste complète des utilisateurs
        Route::get('/users/{user}', [TrustScoreController::class, 'show'])->name('show'); // Détails d'un utilisateur
        Route::post('/users/{user}/recalculate', [TrustScoreController::class, 'recalculate'])->name('recalculate'); // Recalculer un score
        Route::post('/users/{user}/reset', [TrustScoreController::class, 'reset'])->name('reset'); // Réinitialiser un score
        Route::post('/users/{user}/resolve-suspicious', [TrustScoreController::class, 'resolveSuspicious'])->name('resolve-suspicious'); // Résoudre une alerte
        Route::post('/recalculate-all', [TrustScoreController::class, 'recalculateAll'])->name('recalculate-all'); // Recalculer tous les scores
        Route::get('/stats-json', [TrustScoreController::class, 'statsJson'])->name('stats-json'); // API JSON pour graphiques
        Route::get('/export-csv', [TrustScoreController::class, 'exportCsv'])->name('export-csv'); // Export CSV
    });
});

// Routes PayPal
Route::post('/paypal/process', [App\Http\Controllers\PayPalController::class, 'processPayment'])->name('paypal.process');
Route::get('/paypal/success', [App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');




// User-facing Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/join', [EventController::class, 'join'])->name('events.join');





// CRUD Messages
Route::middleware('auth')->prefix('messages')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('pages.messages');
    Route::post('/', [MessageController::class, 'store'])->name('messages.store');
    Route::put('/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

// Routes Meetings (Rendez-vous) - Frontend
Route::middleware('auth')->prefix('meetings')->name('meetings.')->group(function () {
    // Afficher la liste des rendez-vous de l'utilisateur
    Route::get('/', [MeetingController::class, 'index'])->name('index');
    
    // Formulaire de création de rendez-vous
    Route::get('/create/new', [MeetingController::class, 'create'])->name('create');
    
    // Créer un nouveau rendez-vous
    Route::post('/', [MeetingController::class, 'store'])->name('store');
    
    // Formulaire d'édition de rendez-vous
    Route::get('/{id}/edit', [MeetingController::class, 'edit'])->name('edit');
    
    // Mettre à jour un rendez-vous
    Route::put('/{id}', [MeetingController::class, 'update'])->name('update');
    
    // Actions sur les rendez-vous (AJAX)
    Route::post('/{id}/confirm', [MeetingController::class, 'confirm'])->name('confirm');
    Route::post('/{id}/cancel', [MeetingController::class, 'cancel'])->name('cancel');
    Route::post('/{id}/complete', [MeetingController::class, 'complete'])->name('complete');
    Route::delete('/{id}', [MeetingController::class, 'destroy'])->name('destroy');
    
    // Afficher les détails d'un rendez-vous (doit être en dernier)
    Route::get('/{id}', [MeetingController::class, 'show'])->name('show');



    

});