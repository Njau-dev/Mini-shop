<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// =======================================================
// Public Routes (Accessible by Everyone)
// =======================================================

// Landing page - accessible by everyone apart from admin
Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware('role.redirect');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index')->middleware('role.redirect');
Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show')->middleware('role.redirect');

// all authenticated users including admins
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================================================
// Customer Routes (Only Authenticated Customers)
// =======================================================
Route::middleware(['auth', 'role.redirect'])->group(function () {

    // Cart routes
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'checkout'])->name('checkout.process');
});


// =======================================================
// Admin Dashboard Routes (Only admins have access)
// =======================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management Routes
    Route::resource('products', ProductController::class);

    // Categories Management Routes
    Route::resource('categories', CategoryController::class);
    // Users Management
    Route::view('users', 'admin.users.index')->name('users.index');
});

require __DIR__.'/auth.php';
require __DIR__ . '/api.php';
