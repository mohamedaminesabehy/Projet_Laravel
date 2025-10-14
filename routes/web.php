<?php

use App\Http\Controllers\AiSummaryController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\AuthController;

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
Route::get('/api/ai-summary/{id}', [AiSummaryController::class, 'getSummary'])->name('api.ai-summary');
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
    Route::post('/cart/update', [CartController::class, 'bulkUpdate'])->name('cart.bulkUpdate');
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
    
    // Routes pour les événements
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::resource('books', AdminBookController::class);
});

// Routes PayPal
Route::post('/paypal/process', [App\Http\Controllers\PayPalController::class, 'processPayment'])->name('paypal.process');
Route::get('/paypal/success', [App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');
