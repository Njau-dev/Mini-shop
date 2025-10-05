<?php

use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are intended for API calls and return JSON responses.
|
*/

// public route
Route::get('/products', [ProductApiController::class, 'index']);

// customer route
Route::middleware(['auth.message'])->post('/orders', [OrderApiController::class, 'store']);
