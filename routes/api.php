<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Cart API routes
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart']);
Route::get('/cart', [App\Http\Controllers\CartController::class, 'getCart']);
Route::put('/cart/update', [App\Http\Controllers\CartController::class, 'updateQuantity']);
Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'removeItem']);
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clearCart']);

// Product options API
Route::get('/products/{id}/options', function ($id) {
    $product = DB::table('products')
        ->select('id', 'name', 'options', 'option_images', 'featured_image')
        ->where('id', $id)
        ->first();
    
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    // Parse JSON fields - handle potential double encoding
    $options = $product->options;
    // If it's a string, decode it
    if (is_string($options)) {
        $options = json_decode($options, true);
    }
    // If still a string after first decode (double-encoded), decode again
    if (is_string($options)) {
        $options = json_decode($options, true);
    }
    $options = $options ?? [];
    
    // Parse option_images - handle potential double encoding
    $optionImages = $product->option_images;
    if (is_string($optionImages)) {
        $optionImages = json_decode($optionImages, true);
    }
    // If still a string after first decode (double-encoded), decode again
    if (is_string($optionImages)) {
        $optionImages = json_decode($optionImages, true);
    }
    $optionImages = $optionImages ?? [];
    
    // Format options for the modal
    $formattedOptions = [];
    
    // Ensure $options is an array
    if (!is_array($options)) {
        $options = [];
    }
    
    foreach ($options as $index => $option) {
        if (is_array($option) && isset($option['title']) && isset($option['price'])) {
            $imagePath = null;
            
            // Get option image if available
            if (isset($optionImages[$index]) && $optionImages[$index]) {
                // Clean up the path - remove double backslashes and fix path
                $cleanPath = str_replace('\\\\', '', $optionImages[$index]);
                $imagePath = asset('storage/' . $cleanPath);
            } else if ($product->featured_image) {
                $imagePath = asset('storage/' . $product->featured_image);
            }
            
            $formattedOptions[] = [
                'name' => $option['title'],
                'price' => '₦' . number_format($option['price'], 2),
                'raw_price' => $option['price'],
                'image' => $imagePath
            ];
        }
    }
    
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'options' => $formattedOptions
    ]);
});
