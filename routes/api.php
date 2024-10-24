<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\RestrauntController;

// use App\Http\Controllers\Backend\RestrauntController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//admin routes
Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    //user/customer routes
    // Route::get('/user', [CustomerController::class, 'dashboard']);
    // Customer/User Routes
    Route::middleware('customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard']);
        Route::get('/profile', [CustomerController::class, 'profile']);
        // Route::get('/restaurants', [CustomerController::class, 'restaurants']);
        // Route::get('/orders', [CustomerController::class, 'orders']);
        // Add other customer-specific routes here
    });

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/profile', [AdminController::class, 'profile']);

        // Restaurants create

            //api controller
            Route::post('/restaurants/store', [RestrauntController::class, 'store']);
            Route::get('/restaurants/get', [RestrauntController::class, 'get']);
            Route::get('/restaurants/edit/{id}', [RestrauntController::class, 'edit']);
            Route::put('/restaurants/update/{id}', [RestrauntController::class, 'update']);



    });

    // Delivery Boy Routes
    Route::middleware('delivery')->prefix('delivery')->group(function () {
        Route::get('/dashboard', [DeliveryController::class, 'dashboard']);
        Route::get('/profile', [DeliveryController::class, 'profile']);
    });

    // Customer Routes
    // Route::middleware('customer')->prefix('customer')->group(function () {
    //     Route::get('/restaurants', [CustomerController::class, 'restaurants']);
    // });
});