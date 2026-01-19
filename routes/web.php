<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guests, Customers, Admins)
|--------------------------------------------------------------------------
*/

Route::middleware('role.access:public')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{id}', [ProductController::class, 'show'])->name('catalog.show');

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Customers + Admins)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Customer Routes (Authenticated Customers)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.access:customer'])->group(function () {

    // checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'checkout'])->name('checkout.process');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.access:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management Routes
    Route::resource('products', AdminProductController::class);

    // Categories Management Routes
    Route::resource('categories', CategoryController::class);

    // User management routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Orders routes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
});

require __DIR__.'/auth.php';
require __DIR__ . '/api.php';
