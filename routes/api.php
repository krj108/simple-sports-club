<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SportController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\TagsController;

// Public routes for registration and login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes, require authentication
Route::middleware('auth:api')->group(function () {
    
    // CRUD operations for articles
    Route::apiResource('articles', ArticleController::class);

    // CRUD operations for sports
    Route::apiResource('sports', SportController::class);
    
    // CRUD operations for facilities
    Route::apiResource('facilities', FacilityController::class);
    
    // CRUD operations for rooms
    Route::apiResource('rooms', RoomController::class);

    // CRUD operations for categories
    Route::apiResource('categories', CategoriesController::class);
    
    // CRUD operations for tags
    Route::apiResource('tags', TagsController::class);

    // CRUD operations for subscriptions
    Route::apiResource('subscriptions', SubscriptionController::class);

    // Additional subscription actions
    Route::post('subscriptions/{subscription}/approve', [SubscriptionController::class, 'approve']);
    Route::post('subscriptions/{subscription}/suspend', [SubscriptionController::class, 'suspend']);
    Route::post('subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew']);
    Route::post('subscriptions/{subscription}/apply-discount', [SubscriptionController::class, 'applyDiscount']);
  
    // Logout user
    Route::post('logout', [AuthController::class, 'logout']);
});
