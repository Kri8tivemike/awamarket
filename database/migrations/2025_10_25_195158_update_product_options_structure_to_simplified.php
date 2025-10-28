<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Update options structure from {type, min_value, price} to {title, price}
     */
    public function up(): void
    {
        // Update existing options data structure
        $products = \DB::table('products')->whereNotNull('options')->get();
        
        foreach ($products as $product) {
            $oldOptions = json_decode($product->options, true);
            
            if (is_array($oldOptions)) {
                $newOptions = [];
                
                foreach ($oldOptions as $index => $option) {
                    // Convert old structure to new structure
                    // Old: {"type": "weight", "min_value": 1, "price": 24.99}
                    // New: {"title": "weight", "price": 24.99}
                    $newOptions[] = [
                        'title' => $option['type'] ?? 'Option ' . ($index + 1),
                        'price' => $option['price'] ?? 0
                    ];
                }
                
                \DB::table('products')
                    ->where('id', $product->id)
                    ->update(['options' => json_encode($newOptions)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse migration: convert back to old structure
        $products = \DB::table('products')->whereNotNull('options')->get();
        
        foreach ($products as $product) {
            $newOptions = json_decode($product->options, true);
            
            if (is_array($newOptions)) {
                $oldOptions = [];
                
                foreach ($newOptions as $option) {
                    // Convert new structure back to old structure
                    $oldOptions[] = [
                        'type' => $option['title'] ?? 'quantity',
                        'min_value' => 1,
                        'price' => $option['price'] ?? 0
                    ];
                }
                
                \DB::table('products')
                    ->where('id', $product->id)
                    ->update(['options' => json_encode($oldOptions)]);
            }
        }
    }
};
