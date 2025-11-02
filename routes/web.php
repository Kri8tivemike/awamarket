<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

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

// Dashboard route that redirects to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Dashboard Routes - Protected by Authentication
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');
    
    // Categories
    Route::get('/categories/api', [CategoryController::class, 'api']);
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('admin.categories.bulk-delete');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('admin.orders.export');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.delete');
    
    // Banners
    Route::get('/banners', [BannerController::class, 'index'])->name('admin.banners');
    Route::post('/banners', [BannerController::class, 'storeBanner'])->name('admin.banners.store');
    Route::put('/banners/{id}', [BannerController::class, 'updateBanner'])->name('admin.banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'deleteBanner'])->name('admin.banners.delete');
    Route::patch('/banners/{id}/toggle', [BannerController::class, 'toggleBannerStatus'])->name('admin.banners.toggle');
    
    // Promotion Banners
    Route::post('/promotion-banners', [BannerController::class, 'storePromotionBanner'])->name('admin.promotion-banners.store');
    Route::put('/promotion-banners/{id}', [BannerController::class, 'updatePromotionBanner'])->name('admin.promotion-banners.update');
    Route::delete('/promotion-banners/{id}', [BannerController::class, 'deletePromotionBanner'])->name('admin.promotion-banners.delete');
    Route::patch('/promotion-banners/{id}/toggle', [BannerController::class, 'togglePromotionBannerStatus'])->name('admin.promotion-banners.toggle');
    
    // WhatsApp Settings
    Route::get('/whatsapp', [WhatsAppController::class, 'index'])->name('admin.whatsapp');
    Route::post('/whatsapp', [WhatsAppController::class, 'save'])->name('admin.whatsapp.save');
});

// Optional: User profile routes if needed
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
