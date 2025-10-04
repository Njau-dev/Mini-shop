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

Route::get('/products', [ProductApiController::class, 'index']);
Route::middleware(['auth'])->post('/orders', [OrderApiController::class, 'store']);
