<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = Product::with('category');
        
        // Apply search if provided
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Apply category filter if provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Get filtered products
        $products = $query->orderBy('created_at', 'desc')->get();

        // Fetch active categories for filtering
        $categories = Category::where('is_active', true)
                             ->orderBy('name')
                             ->get();
        
        // Get selected category for UI
        $selectedCategory = $request->category;

        return view('pages.shop-now', compact('products', 'categories', 'selectedCategory'));
    }

    public function show($id)
    {
        // Fetch product with category
        $product = Product::with('category')->findOrFail($id);
        
        // Fetch related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->where('status', 'active')
                                  ->limit(4)
                                  ->get();

        return view('pages.product-details', compact('product', 'relatedProducts'));
    }
}
