<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Sample data method for development
    public static function getSampleData()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'image' => 'electronics.jpg',
                'status' => true,
                'products_count' => 45,
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(5),
            ],
            (object) [
                'id' => 2,
                'name' => 'Clothing',
                'description' => 'Fashion and apparel items',
                'image' => 'clothing.jpg',
                'status' => true,
                'products_count' => 78,
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(3),
            ],
            (object) [
                'id' => 3,
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'image' => 'home-garden.jpg',
                'status' => true,
                'products_count' => 32,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(1),
            ],
            (object) [
                'id' => 4,
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'image' => 'sports.jpg',
                'status' => false,
                'products_count' => 23,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(2),
            ],
            (object) [
                'id' => 5,
                'name' => 'Books & Media',
                'description' => 'Books, movies, and digital media',
                'image' => 'books.jpg',
                'status' => true,
                'products_count' => 67,
                'created_at' => now()->subDays(10),
                'updated_at' => now(),
            ],
        ]);
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}