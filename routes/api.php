<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('foods')->group(function () {
    Route::get('/', [FoodItemController::class, 'getAllFoodItems']);
    Route::get('/{id}', [FoodItemController::class, 'getFoodItemById']);
    Route::get('/featured', [FoodItemController::class, 'getFeaturedFoodItems']);
    Route::get('/top-rated', [FoodItemController::class, 'getTopRatedFoodItems']);
    Route::get('/{foodItemId}/reviews', [ReviewController::class, 'getReviews']);
});

// Authenticated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'getProfile']);
    });

    Route::prefix('cart')->group(function () {
        Route::post('/', [CartController::class, 'addToCart']);
        Route::get('/', [CartController::class, 'getCart']);
        Route::delete('/{itemId}', [CartController::class, 'removeCartItem']);
    });

    Route::prefix('orders')->group(function () {
        Route::post('/', [OrderController::class, 'createOrder']);
        Route::get('/my', [OrderController::class, 'getMyOrders']);
    });

    Route::prefix('foods')->group(function () {
        Route::post('/{foodItemId}/reviews', [ReviewController::class, 'createReview']);
    });

    // Admin routes
    Route::middleware('role:ADMIN')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'getDashboard']);
        Route::get('/orders', [AdminController::class, 'getAllOrders']);
        Route::get('/reports/daily', [AdminController::class, 'getDailyReport']);
        Route::get('/reports/weekly', [AdminController::class, 'getWeeklyReport']);
        Route::get('/reports/monthly', [AdminController::class, 'getMonthlyReport']);
        Route::get('/reports/profit-loss', [AdminController::class, 'getProfitLossReport']);
    });
});

