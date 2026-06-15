<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\AffiliateRedirectController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (no authentication required)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::get('/go/{affiliateLink}', [AffiliateRedirectController::class, 'go'])->name('affiliate.go');

/*
|--------------------------------------------------------------------------
| Membership Routes (public listing, auth required for checkout)
|--------------------------------------------------------------------------
*/
Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/membership/{slug}/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::post('/membership/{slug}/checkout', [MembershipController::class, 'processCheckout'])->name('membership.checkout.process');
    Route::get('/dashboard/transactions', [MembershipController::class, 'transactions'])->name('membership.transactions');
    Route::get('/dashboard/transactions/{invoiceNumber}', [MembershipController::class, 'transactionDetail'])->name('membership.transactions.detail');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Member dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (require login + admin role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin-specific routes can be added here if needed outside Filament
});

/*
|--------------------------------------------------------------------------
| Auth Routes (from Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
