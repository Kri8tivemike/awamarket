<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/shop-now', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('product.show');
Route::view('/about', 'pages.about');
Route::view('/contact', 'pages.contact');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout');
Route::post('/orders/create', [CartController::class, 'createOrder'])->name('orders.create');

// API Routes
Route::get('/api/whatsapp-settings', [HomeController::class, 'getWhatsAppSettings'])->name('api.whatsapp.settings');

// Admin Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}', [AdminController::class, 'showProduct'])->name('admin.products.show');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    
    // Categories API for dropdowns
    Route::get('/categories/api', [AdminController::class, 'getCategoriesApi']);
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    Route::post('/categories/bulk-delete', [AdminController::class, 'bulkDeleteCategories'])->name('admin.categories.bulk-delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('admin.orders.export');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('admin.orders.edit');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');
    Route::get('/banners', [AdminController::class, 'banners'])->name('admin.banners');
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('admin.banners.store');
    Route::put('/banners/{id}', [AdminController::class, 'updateBanner'])->name('admin.banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'deleteBanner'])->name('admin.banners.delete');
    Route::patch('/banners/{id}/toggle', [AdminController::class, 'toggleBannerStatus'])->name('admin.banners.toggle');
    Route::post('/promotion-banners', [AdminController::class, 'storePromotionBanner'])->name('admin.promotion-banners.store');
    Route::put('/promotion-banners/{id}', [AdminController::class, 'updatePromotionBanner'])->name('admin.promotion-banners.update');
    Route::delete('/promotion-banners/{id}', [AdminController::class, 'deletePromotionBanner'])->name('admin.promotion-banners.delete');
    Route::patch('/promotion-banners/{id}/toggle', [AdminController::class, 'togglePromotionBannerStatus'])->name('admin.promotion-banners.toggle');
    Route::get('/whatsapp', [AdminController::class, 'whatsapp'])->name('admin.whatsapp');
    Route::post('/whatsapp', [AdminController::class, 'saveWhatsAppSettings'])->name('admin.whatsapp.save');
});
