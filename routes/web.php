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
// API: product search used by AJAX on compare page
Route::get('/api/products/search', [ProductController::class, 'search']);
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

    // Payment Simulation Routes
    Route::post('/dashboard/transactions/{invoiceNumber}/simulate-success', [MembershipController::class, 'simulatePaymentSuccess'])->name('membership.simulate.success');
    Route::post('/dashboard/transactions/{invoiceNumber}/simulate-failed', [MembershipController::class, 'simulatePaymentFailed'])->name('membership.simulate.failed');
    Route::post('/dashboard/transactions/{invoiceNumber}/simulate-pending', [MembershipController::class, 'simulatePaymentPending'])->name('membership.simulate.pending');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Smart dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Redirect admin to admin dashboard
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Redirect regular users to user dashboard
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| User Dashboard Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (require login + admin role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Reward Management
    Route::get('/rewards', [App\Http\Controllers\Admin\RewardController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/{reward}/approve', [App\Http\Controllers\Admin\RewardController::class, 'approve'])->name('rewards.approve');
    Route::post('/rewards/{reward}/reject', [App\Http\Controllers\Admin\RewardController::class, 'reject'])->name('rewards.reject');
    Route::post('/rewards/bulk-approve', [App\Http\Controllers\Admin\RewardController::class, 'bulkApprove'])->name('rewards.bulk-approve');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (from Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
