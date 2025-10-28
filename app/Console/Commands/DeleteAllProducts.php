<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DeleteAllProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:delete-all {--force : Force deletion without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all products and their associated files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productCount = Product::count();
        
        if ($productCount === 0) {
            $this->info('No products found to delete.');
            return 0;
        }

        $this->info("Found {$productCount} products to delete.");

        // Show confirmation unless --force flag is used
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete ALL products? This action cannot be undone.')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Starting product deletion process...');
        
        // Get all products with their images
        $products = Product::all();
        $deletedImages = [];
        $failedImages = [];

        // Delete associated image files
        foreach ($products as $product) {
            // Delete featured image
            if ($product->featured_image) {
                $imagePath = public_path($product->featured_image);
                if (File::exists($imagePath)) {
                    try {
                        File::delete($imagePath);
                        $deletedImages[] = $product->featured_image;
                        $this->line("Deleted image: {$product->featured_image}");
                    } catch (\Exception $e) {
                        $failedImages[] = $product->featured_image;
                        $this->error("Failed to delete image: {$product->featured_image} - {$e->getMessage()}");
                    }
                }
            }

            // Delete images from images array
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    $imagePath = public_path('uploads/products/' . $image);
                    if (File::exists($imagePath)) {
                        try {
                            File::delete($imagePath);
                            $deletedImages[] = 'uploads/products/' . $image;
                            $this->line("Deleted image: uploads/products/{$image}");
                        } catch (\Exception $e) {
                            $failedImages[] = 'uploads/products/' . $image;
                            $this->error("Failed to delete image: uploads/products/{$image} - {$e->getMessage()}");
                        }
                    }
                }
            }
        }

        // Delete all products from database
        try {
            $deletedCount = Product::query()->delete();
            $this->info("Successfully deleted {$deletedCount} products from database.");
        } catch (\Exception $e) {
            $this->error("Failed to delete products from database: {$e->getMessage()}");
            return 1;
        }

        // Summary
        $this->info("\n=== DELETION SUMMARY ===");
        $this->info("Products deleted: {$deletedCount}");
        $this->info("Images deleted: " . count($deletedImages));
        
        if (count($failedImages) > 0) {
            $this->warn("Failed to delete " . count($failedImages) . " images:");
            foreach ($failedImages as $failedImage) {
                $this->line("  - {$failedImage}");
            }
        }

        $this->info("\nAll products have been successfully deleted!");
        
        return 0;
    }
}