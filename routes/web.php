<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\PostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\WishlistController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('categories.show');

Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/update-cart', [CartController::class, 'update'])->name('cart.update');
Route::get('/clear-cart', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/momo-return', [CheckoutController::class, 'momoReturn'])->name('momo.return');

Auth::routes();

// Social Login Routes
Route::get('login/{provider}', [App\Http\Controllers\Auth\SocialController::class, 'redirectToProvider'])->name('social.login');
Route::get('login/{provider}/callback', [App\Http\Controllers\Auth\SocialController::class, 'handleProviderCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Account Routes
Route::get('/my-orders', [AccountController::class, 'orders'])->name('account.orders');
Route::get('/my-order/{id}', [AccountController::class, 'showOrder'])->name('account.order_detail');
Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
Route::get('/my-wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
Route::post('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');

// AI Chat Route
Route::post('/ai-chat', [App\Http\Controllers\AIChatController::class, 'chat'])->name('ai.chat');

// Admin Routes
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::get('/admin/orders/customer/{id}', [AdminController::class, 'customerOrders'])->name('admin.orders.customer');
Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

// Admin Flash Sale Routes
Route::get('/admin/flash-sales', [AdminController::class, 'flashSales'])->name('admin.flash_sales');
Route::post('/admin/flash-sales/stop-all', [AdminController::class, 'stopAllFlashSales'])->name('admin.flash_sales.stop_all');
Route::post('/admin/flash-sales/global-end', [AdminController::class, 'updateGlobalFlashSaleEnd'])->name('admin.flash_sales.global_end');
Route::post('/admin/flash-sales/{id}', [AdminController::class, 'updateFlashSale'])->name('admin.flash_sales.update');

// Admin Product Management
Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
Route::post('/admin/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
Route::post('/admin/products/{id}/delete', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
Route::post('/admin/products/delete-all', [AdminController::class, 'deleteAllProducts'])->name('admin.products.delete-all');
Route::get('/admin/products/delete-image/{id}', [AdminController::class, 'deleteProductImage'])->name('admin.products.delete-image');
Route::get('/admin/products/{id}/delete-all-images', [AdminController::class, 'deleteAllProductImages'])->name('admin.products.delete-all-images');

// Admin Category Management
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
Route::post('/admin/categories/{id}/delete', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

// Admin Brand Management
Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
Route::post('/admin/brands', [AdminController::class, 'storeBrand'])->name('admin.brands.store');
Route::post('/admin/brands/{id}/delete', [AdminController::class, 'deleteBrand'])->name('admin.brands.delete');
Route::post('/admin/brands/{id}/delete-logo', [AdminController::class, 'deleteBrandLogo'])->name('admin.brands.delete_logo');

// Slide Management
Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
Route::post('/admin/slides', [AdminController::class, 'storeSlide'])->name('admin.slides.store');
Route::post('/admin/slides/update/{id}', [AdminController::class, 'updateSlide'])->name('admin.slides.update');
Route::post('/admin/slides/delete/{id}', [AdminController::class, 'deleteSlide'])->name('admin.slides.delete');

// Banner Management
Route::get('/admin/banners', [AdminController::class, 'banners'])->name('admin.banners');
Route::post('/admin/banners/update/{id}', [AdminController::class, 'updateBanner'])->name('admin.banners.update');

// Admin User Management
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::post('/admin/users/{id}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle_admin');
Route::post('/admin/users/{id}/toggle-write', [AdminController::class, 'toggleWritePermission'])->name('admin.users.toggle_write');

// Admin Post Management
Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts');
Route::get('/admin/posts/create', [AdminController::class, 'createPost'])->name('admin.posts.create');
Route::post('/admin/posts', [AdminController::class, 'storePost'])->name('admin.posts.store');
Route::get('/admin/posts/edit/{id}', [AdminController::class, 'editPost'])->name('admin.posts.edit');
Route::post('/admin/posts/update/{id}', [AdminController::class, 'updatePost'])->name('admin.posts.update');
Route::get('/admin/posts/delete/{id}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');

Route::get('/admin/subscribers', [AdminController::class, 'subscribers'])->name('admin.subscribers');
Route::get('/admin/subscribers/delete/{id}', [AdminController::class, 'deleteSubscriber'])->name('admin.subscribers.delete');

// Admin Voucher Management
Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
Route::post('/admin/coupons', [AdminController::class, 'storeCoupon'])->name('admin.coupons.store');
Route::post('/admin/coupons/{id}/delete', [AdminController::class, 'deleteCoupon'])->name('admin.coupons.delete');

// Admin Settings
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

// Admin Reports
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/reports/export', [AdminController::class, 'exportReport'])->name('admin.reports.export');

// Review Routes
Route::post('/product/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/review/{id}/reply', [\App\Http\Controllers\ReviewController::class, 'reply'])->name('reviews.reply')->middleware('auth');

// Notification Routes
Route::get('/notifications/mark-all-as-read', function() {
    auth()->user()->unreadNotifications()->update(['is_read' => true]);
    return redirect()->back();
})->name('notifications.markAllRead')->middleware('auth');

Route::get('/notifications/{id}/read', function($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->update(['is_read' => true]);
    return redirect($notification->link ?? '/');
})->name('notifications.read')->middleware('auth');

// Order Cancellation
Route::post('/account/orders/{id}/cancel', [\App\Http\Controllers\AccountController::class, 'cancelOrder'])->name('account.orders.cancel')->middleware('auth');
