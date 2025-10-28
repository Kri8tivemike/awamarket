<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system and A17 Pro chip',
                'short_description' => 'Premium smartphone with cutting-edge technology',
                'slug' => 'iphone-15-pro',
                'price' => 999.00,
                'sale_price' => 899.00,
                'sku' => 'IPH15PRO001',
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'category_id' => 1, // Electronics
                'weight' => 0.221,
                'dimensions' => '159.9 x 76.7 x 8.25 mm',
                'featured' => true,
                'images' => json_encode(['iphone15pro-1.jpg', 'iphone15pro-2.jpg']),
                'attributes' => json_encode(['color' => 'Space Black', 'storage' => '256GB']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Flagship Android smartphone with AI-powered features',
                'short_description' => 'Advanced Android smartphone with AI capabilities',
                'slug' => 'samsung-galaxy-s24',
                'price' => 849.00,
                'sale_price' => null,
                'sku' => 'SGS24001',
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'category_id' => 1, // Electronics
                'weight' => 0.196,
                'dimensions' => '158.5 x 75.9 x 7.7 mm',
                'featured' => true,
                'images' => json_encode(['galaxy-s24-1.jpg', 'galaxy-s24-2.jpg']),
                'attributes' => json_encode(['color' => 'Phantom Black', 'storage' => '128GB']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Max Air cushioning',
                'short_description' => 'Premium running shoes for everyday comfort',
                'slug' => 'nike-air-max-270',
                'price' => 150.00,
                'sale_price' => 120.00,
                'sku' => 'NAM270001',
                'stock_quantity' => 75,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'category_id' => 2, // Clothing (assuming shoes fall under clothing)
                'weight' => 0.8,
                'dimensions' => 'US Size 10',
                'featured' => false,
                'images' => json_encode(['nike-air-max-1.jpg', 'nike-air-max-2.jpg']),
                'attributes' => json_encode(['color' => 'Black/White', 'size' => '10']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'Professional laptop with M3 chip for creative professionals',
                'short_description' => 'High-performance laptop for professionals',
                'slug' => 'macbook-pro-14',
                'price' => 1999.00,
                'sale_price' => null,
                'sku' => 'MBP14M3001',
                'stock_quantity' => 20,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'category_id' => 1, // Electronics
                'weight' => 1.6,
                'dimensions' => '31.26 x 22.12 x 1.55 cm',
                'featured' => true,
                'images' => json_encode(['macbook-pro-1.jpg', 'macbook-pro-2.jpg']),
                'attributes' => json_encode(['color' => 'Space Gray', 'memory' => '16GB', 'storage' => '512GB']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald',
                'short_description' => 'Timeless classic of American literature',
                'slug' => 'the-great-gatsby',
                'price' => 12.99,
                'sale_price' => 9.99,
                'sku' => 'TGG001',
                'stock_quantity' => 100,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'category_id' => 5, // Books
                'weight' => 0.3,
                'dimensions' => '20.3 x 13.3 x 1.5 cm',
                'featured' => false,
                'images' => json_encode(['great-gatsby-1.jpg']),
                'attributes' => json_encode(['format' => 'Paperback', 'pages' => '180']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
