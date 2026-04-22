<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileApiController;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/home', [MobileApiController::class, 'getHomeData']);
    Route::get('/products', [MobileApiController::class, 'getProducts']);
    Route::get('/products/{id}', [MobileApiController::class, 'getProductDetail']);
    Route::get('/categories', [MobileApiController::class, 'getCategories']);
    Route::get('/posts', [MobileApiController::class, 'getPosts']);
    
    // Auth routes
    Route::post('/login', [MobileApiController::class, 'login']);
    Route::post('/register', [MobileApiController::class, 'register']);
    Route::post('/password/email', [MobileApiController::class, 'forgotPassword']);
    Route::get('/social/token', [MobileApiController::class, 'getSocialToken']);
    
    // Blog/Posts routes
    Route::get('/posts', [MobileApiController::class, 'getPosts']);
    Route::get('/posts/{id}', [MobileApiController::class, 'getPostDetail']);

    // Protected routes (Requires Login)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [MobileApiController::class, 'logout']);
        Route::get('/profile', [MobileApiController::class, 'getProfile']);
        Route::put('/profile', [MobileApiController::class, 'updateProfile']);
        Route::get('/orders', [MobileApiController::class, 'getOrders']);
        Route::get('/orders/{id}', [MobileApiController::class, 'getOrderDetail']);
        Route::post('/orders/{id}/cancel', [MobileApiController::class, 'cancelOrder']);
        Route::post('/checkout', [MobileApiController::class, 'checkout']);
        Route::post('/coupon/verify', [MobileApiController::class, 'verifyCoupon']);
        Route::post('/reviews', [MobileApiController::class, 'submitReview']);
        Route::get('/wishlist', [MobileApiController::class, 'getWishlist']);
        Route::post('/wishlist/toggle/{productId}', [MobileApiController::class, 'toggleWishlist']);
        Route::post('/wishlist/clear', [MobileApiController::class, 'clearWishlist']);

        // Cart Sync
        Route::get('/cart', [MobileApiController::class, 'getCart']);
        Route::post('/cart', [MobileApiController::class, 'addToCart']);
        Route::put('/cart', [MobileApiController::class, 'updateCart']);
        Route::delete('/cart/clear', [MobileApiController::class, 'clearCart']);
        Route::delete('/cart/{productId}', [MobileApiController::class, 'removeFromCart']);
    });
});
