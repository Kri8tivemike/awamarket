<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'status',
        'images',
        'category_id',
        'weight',
        'dimensions',
        'short_description',
        'attributes',
        'featured',
        'featured_image',
        'options',
        'option_images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'featured' => 'boolean',
        'images' => 'array',
        'attributes' => 'array',
        'options' => 'array',
        'option_images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Sample data method for development
    public static function getSampleData()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'WH-001',
                'stock_quantity' => 25,
                'category_id' => 1,
                'image' => 'headphones.jpg',
                'status' => true,
                'featured' => true,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(2),
            ],
            (object) [
                'id' => 2,
                'name' => 'Cotton T-Shirt',
                'description' => 'Comfortable 100% cotton t-shirt',
                'price' => 29.99,
                'sale_price' => null,
                'sku' => 'TS-001',
                'stock_quantity' => 50,
                'category_id' => 2,
                'image' => 'tshirt.jpg',
                'status' => true,
                'featured' => false,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(1),
            ],
        ]);
    }

    // Accessors
    public function getImageAttribute()
    {
        return $this->featured_image;
    }

    // Resolved image URL based on where files are stored
    public function getImageUrlAttribute()
    {
        return $this->resolvePathToUrl($this->featured_image);
    }

    public function getStockAttribute()
    {
        return $this->stock_quantity;
    }

    // Helper to normalize paths to public URLs
    protected function resolvePathToUrl(?string $path): string
    {
        if (!$path) {
            return asset('images/placeholder.png');
        }
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        // If path already points into public directory structures (not in storage)
        if (Str::startsWith($path, ['uploads/'])) {
            return asset($path);
        }
        // Option images and other files in storage/app/public
        if (Str::startsWith($path, ['option_images/', 'images/', 'products/'])) {
            return asset('storage/' . $path);
        }
        // Default to storage symlink
        return asset('storage/' . ltrim($path, '/'));
    }

    public function getOptionsAttribute($value)
    {
        if (is_string($value)) {
            // Decode if it's a JSON string
            $decoded = json_decode($value, true);
            // Check if it's still a JSON string (double encoded)
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return $decoded;
        }
        return $value;
    }

    public function getOptionImagesAttribute($value)
    {
        if (is_string($value)) {
            // Decode if it's a JSON string
            $decoded = json_decode($value, true);
            // Check if it's still a JSON string (double encoded)
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return $decoded;
        }
        return $value;
    }

    // Convenience: full URLs for each option image
    public function getOptionImagesUrlsAttribute(): array
    {
        $images = $this->option_images ?? [];
        if (!is_array($images)) return [];
        return array_map(function ($p) { return $this->resolvePathToUrl($p); }, $images);
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
