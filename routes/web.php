<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController as AdminBookController;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/authors', [AdminController::class, 'authors'])->name('authors');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('/authors/add', [AdminController::class, 'addAuthor'])->name('add-author');
    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('add-category');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::resource('books', AdminBookController::class);
});
