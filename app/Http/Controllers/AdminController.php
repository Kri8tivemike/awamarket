<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Banner;
use App\Models\PromotionBanner;
use App\Models\WhatsAppSetting;
use App\Utils\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get real statistics from database
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        
        // Calculate total revenue
        $totalRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])->sum('total');
        
        // Calculate monthly revenue (current month)
        $monthlyRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // Calculate previous month data for percentage changes
        $prevMonthProducts = Product::whereMonth('created_at', '<', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $productChange = $prevMonthProducts > 0 ? round((($totalProducts - $prevMonthProducts) / $prevMonthProducts) * 100) : 0;
        
        $prevMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $currentMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $orderChange = $prevMonthOrders > 0 ? round((($currentMonthOrders - $prevMonthOrders) / $prevMonthOrders) * 100) : 0;
        
        $prevMonthRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');
        $revenueChange = $prevMonthRevenue > 0 ? round((($monthlyRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100) : 0;
        
        // Get recent orders (last 5)
        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $data = [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'productChange' => $productChange,
            'orderChange' => $orderChange,
            'revenueChange' => $revenueChange,
            'recentOrders' => $recentOrders,
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Get categories for API (used in dropdowns)
     */
    public function getCategoriesApi()
    {
        $categories = Category::where('is_active', true)->get();
        return response()->json($categories);
    }

    public function products(Request $request)
    {
        // Start with base query
        $query = Product::with('category');
        
        // Apply category filter if provided
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Apply search filter if provided
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Get total counts for statistics (before pagination)
        $totalProducts = $query->count();
        $featuredProducts = (clone $query)->where('featured', true)->count();
        $outOfStock = (clone $query)->where('stock_quantity', '<=', 0)->count();
        
        // Apply pagination - 10 items per page
        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $products->appends($request->query());
        
        // Get all categories for the filter dropdown
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'featuredProducts' => $featuredProducts,
            'outOfStock' => $outOfStock,
            'filters' => [
                'category_id' => $request->category_id,
                'status' => $request->status,
                'search' => $request->search,
            ]
        ];

        return view('admin.products', $data);
    }

    public function categories(Request $request)
    {
        // Start with base query
        $query = Category::query();
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Apply search filter if provided
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Get total counts for statistics (before pagination)
        $totalCategories = $query->count();
        $activeCategories = (clone $query)->where('is_active', true)->count();
        $inactiveCategories = (clone $query)->where('is_active', false)->count();
        
        // Apply pagination - 10 items per page
        $categories = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $categories->appends($request->query());
        
        $data = [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'activeCategories' => $activeCategories,
            'inactiveCategories' => $inactiveCategories,
            'filters' => [
                'status' => $request->status,
                'search' => $request->search,
            ]
        ];

        return view('admin.categories', $data);
    }

    public function orders(Request $request)
    {
        $query = Order::query();

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Get paginated results
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Preserve query parameters in pagination links
        $orders->appends($request->query());

        return view('admin.orders', compact('orders'));
    }

    public function banners()
    {
        $banner = Banner::getActiveBanner();
        $promotionBanners = PromotionBanner::ordered()->get();
        
        $data = [
            'banner' => $banner,
            'hasBanner' => $banner !== null,
            'promotionBanners' => $promotionBanners,
        ];

        return view('admin.banners', $data);
    }

    public function whatsapp()
    {
        $settings = WhatsAppSetting::getSettings();

        return view('admin.whatsapp', compact('settings'));
    }

    public function saveWhatsAppSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'welcome_message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        $settings = WhatsAppSetting::first();
        
        if (!$settings) {
            $settings = new WhatsAppSetting();
        }

        $settings->phone_number = $request->phone_number;
        $settings->business_name = $request->business_name;
        $settings->welcome_message = $request->welcome_message;
        $settings->enable_chat_widget = $request->has('enable_whatsapp');
        $settings->save();

        return redirect()->back()->with('success', 'WhatsApp settings saved successfully!');
    }

    // Product CRUD Methods
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.create-product', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku',
                'featured_image' => ImageHandler::getValidationRules(false),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->sku = $request->sku;
            $product->stock_quantity = $request->stock_quantity;
            $product->manage_stock = $request->has('manage_stock');
            $product->in_stock = $request->stock_quantity > 0;
            $product->status = $request->status ?? 'active';
            $product->category_id = $request->category_id;
            $product->weight = $request->weight;
            $product->dimensions = $request->dimensions;
            $product->featured = $request->has('featured');
            $product->attributes = $request->attributes ? json_encode($request->attributes) : null;
            $product->images = $request->images ? json_encode($request->images) : null;
            
            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $product->featured_image = ImageHandler::uploadImage(
                    $request->file('featured_image'),
                    'uploads/products'
                );
            }
            
            // Handle options (simplified: title, price)
            if ($request->has('options')) {
                $options = [];
                foreach ($request->options as $option) {
                    if (!empty($option['title']) && !empty($option['price'])) {
                        $options[] = [
                            'title' => $option['title'],
                            'price' => floatval($option['price'])
                        ];
                    }
                }
                $product->options = !empty($options) ? json_encode($options) : null;
            }
            
            // Handle option images
            if ($request->hasFile('option_images')) {
                $optionImages = [];
                $existingOptionImages = $product->option_images ? json_decode($product->option_images, true) : [];
                
                foreach ($request->file('option_images') as $index => $image) {
                    if ($image && $image->isValid()) {
                        // Delete old image if exists
                        if (isset($existingOptionImages[$index]) && $existingOptionImages[$index]) {
                            $oldImagePath = public_path('storage/' . $existingOptionImages[$index]);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        
                        // Store new image
                        $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                        $imagePath = $image->storeAs('option_images', $imageName, 'public');
                        $optionImages[$index] = $imagePath;
                    } else if (isset($existingOptionImages[$index])) {
                        // Keep existing image if no new image uploaded
                        $optionImages[$index] = $existingOptionImages[$index];
                    }
                }
                
                // Handle image removals
                if ($request->has('remove_option_images')) {
                    foreach ($request->remove_option_images as $index => $remove) {
                        if ($remove && isset($existingOptionImages[$index])) {
                            $oldImagePath = public_path('storage/' . $existingOptionImages[$index]);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                            unset($optionImages[$index]);
                        }
                    }
                }
                
                $product->option_images = !empty($optionImages) ? json_encode($optionImages) : null;
            } else {
                // Handle image removals when no new images are uploaded
                if ($request->has('remove_option_images')) {
                    $existingOptionImages = $product->option_images ? json_decode($product->option_images, true) : [];
                    
                    foreach ($request->remove_option_images as $index => $remove) {
                        if ($remove && isset($existingOptionImages[$index])) {
                            $oldImagePath = public_path('storage/' . $existingOptionImages[$index]);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                            unset($existingOptionImages[$index]);
                        }
                    }
                    
                    $product->option_images = !empty($existingOptionImages) ? json_encode($existingOptionImages) : null;
                }
            }
            
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showProduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // If it's an AJAX request, return JSON (for backward compatibility)
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }
        
        // Otherwise, return the view
        return view('admin.products.show', compact('product'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        // If it's an AJAX request, return JSON (for backward compatibility)
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product,
                'categories' => $categories
            ]);
        }
        
        // Otherwise, return the view
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku,' . $id,
                'featured_image' => ImageHandler::getValidationRules(false),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->sku = $request->sku;
            $product->stock_quantity = $request->stock_quantity;
            $product->manage_stock = $request->has('manage_stock');
            $product->in_stock = $request->stock_quantity > 0;
            $product->status = $request->status ?? 'active';
            $product->category_id = $request->category_id;
            $product->weight = $request->weight;
            $product->dimensions = $request->dimensions;
            $product->featured = $request->has('featured');
            $product->attributes = $request->attributes ? json_encode($request->attributes) : null;
            $product->images = $request->images ? json_encode($request->images) : null;
            
            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $product->featured_image = ImageHandler::uploadImage(
                    $request->file('featured_image'),
                    'uploads/products',
                    $product->featured_image
                );
            }
            
            // Handle options - preserve array indices to match option_images
            if ($request->has('options')) {
                $options = [];
                foreach ($request->options as $index => $option) {
                    if (!empty($option['title']) && !empty($option['price'])) {
                        $options[$index] = [
                            'title' => $option['title'],
                            'price' => floatval($option['price'])
                        ];
                    }
                }
                $product->options = !empty($options) ? $options : null;
            }
            
            // Handle option images - preserve existing images and only update changed ones
            if ($request->hasFile('option_images')) {
                // Get existing option images (already cast as array in model)
                $optionImages = $product->option_images ?? [];
                
                foreach ($request->file('option_images') as $index => $image) {
                    if ($image && $image->isValid()) {
                        // Delete old image if exists
                        if (isset($optionImages[$index])) {
                            $oldImagePath = public_path('storage/' . $optionImages[$index]);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        
                        // Store new image
                        $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                        $imagePath = $image->storeAs('option_images', $imageName, 'public');
                        $optionImages[$index] = $imagePath;
                    }
                }
                
                // Save the array (model will auto-encode to JSON)
                $product->option_images = !empty($optionImages) ? $optionImages : null;
            }
            
            // Handle option image removals
            if ($request->has('remove_option_images')) {
                $optionImages = $product->option_images ?? [];
                
                foreach ($request->remove_option_images as $index => $shouldRemove) {
                    if ($shouldRemove && isset($optionImages[$index])) {
                        // Delete the image file
                        $imagePath = public_path('storage/' . $optionImages[$index]);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                        // Remove from array
                        unset($optionImages[$index]);
                    }
                }
                
                // Save the array (model will auto-encode to JSON)
                $product->option_images = !empty($optionImages) ? $optionImages : null;
            }
            
            $product->save();

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated image files
        if ($product->featured_image && file_exists(public_path($product->featured_image))) {
            unlink(public_path($product->featured_image));
        }
        
        // Delete option images if they exist
        if ($product->option_images) {
            $optionImages = json_decode($product->option_images, true);
            if (is_array($optionImages)) {
                foreach ($optionImages as $imagePath) {
                    $fullPath = public_path('storage/' . $imagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
        }
        
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully!');
    }

    private function getRecentOrders()
    {
        return collect([
            (object) [
                'id' => 1001,
                'customer_name' => 'John Doe',
                'total' => 299.99,
                'status' => 'pending',
                'created_at' => now()->subHours(2),
            ],
            (object) [
                'id' => 1002,
                'customer_name' => 'Jane Smith',
                'total' => 149.50,
                'status' => 'completed',
                'created_at' => now()->subHours(5),
            ],
            (object) [
                'id' => 1003,
                'customer_name' => 'Mike Johnson',
                'total' => 89.99,
                'status' => 'processing',
                'created_at' => now()->subHours(8),
            ],
        ]);
    }

    private function getTopProducts()
    {
        return collect([
            (object) [
                'name' => 'Wireless Headphones',
                'sales' => 45,
                'revenue' => 6749.55,
            ],
            (object) [
                'name' => 'Cotton T-Shirt',
                'sales' => 78,
                'revenue' => 2339.22,
            ],
            (object) [
                'name' => 'Smart Watch',
                'sales' => 32,
                'revenue' => 9599.68,
            ],
        ]);
    }

    private function getSampleOrders()
    {
        return collect([
            (object) [
                'id' => 1001,
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'total' => 299.99,
                'status' => 'pending',
                'items_count' => 3,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
            ],
            (object) [
                'id' => 1002,
                'customer_name' => 'Jane Smith',
                'customer_email' => 'jane@example.com',
                'total' => 149.50,
                'status' => 'completed',
                'items_count' => 2,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(3),
            ],
            (object) [
                'id' => 1003,
                'customer_name' => 'Mike Johnson',
                'customer_email' => 'mike@example.com',
                'total' => 89.99,
                'status' => 'processing',
                'items_count' => 1,
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(6),
            ],
            (object) [
                'id' => 1004,
                'customer_name' => 'Sarah Wilson',
                'customer_email' => 'sarah@example.com',
                'total' => 459.99,
                'status' => 'shipped',
                'items_count' => 4,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subHours(12),
            ],
        ]);
    }

    private function getSampleBanners()
    {
        return collect([
            (object) [
                'id' => 1,
                'title' => 'Summer Sale',
                'description' => 'Up to 50% off on selected items',
                'image' => 'summer-sale.jpg',
                'link' => '/shop-now',
                'status' => true,
                'sort_order' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(2),
            ],
            (object) [
                'id' => 2,
                'title' => 'New Arrivals',
                'description' => 'Check out our latest products',
                'image' => 'new-arrivals.jpg',
                'link' => '/shop-now',
                'status' => true,
                'sort_order' => 2,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDay(),
            ],
            (object) [
                'id' => 3,
                'title' => 'Free Shipping',
                'description' => 'Free shipping on orders over $100',
                'image' => 'free-shipping.jpg',
                'link' => '/shop-now',
                'status' => true,
                'sort_order' => 3,
                'created_at' => now()->subDays(5),
                'updated_at' => now(),
            ],
        ]);
    }

    public function storeCategory(Request $request)
    {
        try {
            $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => ImageHandler::getValidationRules(false),
            'is_active' => 'nullable|in:on,1,true,0,false'
        ]);

            // Generate unique slug
            $baseSlug = Str::slug($request->name);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Category::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'is_active' => $request->has('is_active') ? true : false
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('images/categories');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $image->move($uploadPath, $imageName);
                $data['image'] = 'images/categories/' . $imageName;
            }

            $category = Category::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => $category
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'nullable|string',
                'image' => ImageHandler::getValidationRules(false),
                'is_active' => 'nullable|in:on,1,true,0,false'
            ]);

            $category = Category::findOrFail($id);
            
            // Generate unique slug if name changed
            $slug = $category->slug;
            if ($category->name !== $request->name) {
                $baseSlug = Str::slug($request->name);
                $slug = $baseSlug;
                $counter = 1;
                
                while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            }
            
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'is_active' => $request->has('is_active') ? true : false
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('images/categories');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $image->move($uploadPath, $imageName);
                $data['image'] = 'images/categories/' . $imageName;
            }

            $category->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'category' => $category
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!'
        ]);
    }

    public function bulkDeleteCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'required|integer|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid category selection.'
            ], 400);
        }

        $categoryIds = $request->category_ids;
        
        try {
            // Check if any categories have products
            $categoriesWithProducts = Category::whereIn('id', $categoryIds)
                ->whereHas('products')
                ->pluck('name')
                ->toArray();

            if (!empty($categoriesWithProducts)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete categories that have products: ' . implode(', ', $categoriesWithProducts)
                ], 400);
            }

            // Delete the categories and their images
            $categories = Category::whereIn('id', $categoryIds)->get();
            
            foreach ($categories as $category) {
                // Delete image file if exists
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }
            }

            // Delete categories from database
            $deletedCount = Category::whereIn('id', $categoryIds)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} " . ($deletedCount === 1 ? 'category' : 'categories') . "!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting categories: ' . $e->getMessage()
            ], 500);
        }
    }

    // Order CRUD Methods
    public function showOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function editOrder($id)
    {
        $order = Order::findOrFail($id);
        $statuses = Order::getStatuses();
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', array_keys(Order::getStatuses())),
            'items_count' => 'required|integer|min:1',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        // Update order (admin override: allow changing to any status)
        $order->update($request->only([
            'customer_name', 'customer_email', 'customer_phone', 'total', 
            'status', 'items_count', 'shipping_address', 'billing_address', 'notes'
        ]));

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully!');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Check if order can be deleted (business rule: only pending orders can be deleted)
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('admin.orders')
                ->with('error', 'Only pending orders can be deleted. Current status: ' . ucfirst($order->status));
        }

        $orderNumber = $order->id;
        $order->delete();

        return redirect()->route('admin.orders')
            ->with('success', "Order #{$orderNumber} has been deleted successfully!");
    }

    /**
     * Validate status transitions based on business rules
     */
    private function isValidStatusTransition($currentStatus, $newStatus)
    {
        // Define valid transitions
        $validTransitions = [
            Order::STATUS_PENDING => [Order::STATUS_PROCESSING, Order::STATUS_ORDER_CANCELLED],
            Order::STATUS_PROCESSING => [Order::STATUS_COLLECTED_BY_DISPATCH, Order::STATUS_ORDER_CANCELLED],
            Order::STATUS_COLLECTED_BY_DISPATCH => [Order::STATUS_DELIVERED_SUCCESSFULLY, Order::STATUS_FAILED_DELIVERY],
            Order::STATUS_DELIVERED_SUCCESSFULLY => [], // Final state
            Order::STATUS_FAILED_DELIVERY => [Order::STATUS_COLLECTED_BY_DISPATCH], // Can retry delivery
            Order::STATUS_ORDER_CANCELLED => [], // Final state
        ];

        // Allow staying in the same status
        if ($currentStatus === $newStatus) {
            return true;
        }

        return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
    }

    // Banner CRUD Methods
    public function storeBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ImageHandler::getValidationRules(true),
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if a banner already exists
        $existingBanner = Banner::first();
        if ($existingBanner) {
            return redirect()->back()->with('error', 'A banner already exists. Please update the existing banner instead.');
        }

        $data = $request->only(['status']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/banners'
            );
        }

        Banner::create($data);

        return redirect()->route('admin.banners')->with('success', 'Banner created successfully!');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'image' => ImageHandler::getValidationRules(false),
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['status']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/banners',
                $banner->image
            );
        }

        $banner->update($data);

        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully!');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Delete image file if exists
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        
        $banner->delete();

        return redirect()->route('admin.banners')->with('success', 'Banner deleted successfully!');
    }

    public function toggleBannerStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['status' => !$banner->status]);

        $status = $banner->status ? 'activated' : 'deactivated';
        return redirect()->route('admin.banners')->with('success', "Banner {$status} successfully!");
    }

    // Promotion Banner CRUD Methods
    public function storePromotionBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => ImageHandler::getValidationRules(true),
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'alt_text', 'link', 'status', 'sort_order']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/promotion-banners'
            );
        }

        // Set default sort order if not provided
        if (!isset($data['sort_order'])) {
            $maxOrder = PromotionBanner::max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        PromotionBanner::create($data);

        return redirect()->route('admin.banners')->with('success', 'Promotion banner created successfully!');
    }

    public function updatePromotionBanner(Request $request, $id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => ImageHandler::getValidationRules(false),
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'alt_text', 'link', 'status', 'sort_order']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/promotion-banners',
                $promotionBanner->image
            );
        }

        $promotionBanner->update($data);

        return redirect()->route('admin.banners')->with('success', 'Promotion banner updated successfully!');
    }

    public function deletePromotionBanner($id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        
        // Delete image file if exists
        if ($promotionBanner->image && file_exists(public_path($promotionBanner->image))) {
            unlink(public_path($promotionBanner->image));
        }
        
        $promotionBanner->delete();

        return redirect()->route('admin.banners')->with('success', 'Promotion banner deleted successfully!');
    }

    public function togglePromotionBannerStatus($id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        $promotionBanner->update(['status' => !$promotionBanner->status]);

        $status = $promotionBanner->status ? 'activated' : 'deactivated';
        return redirect()->route('admin.banners')->with('success', "Promotion banner {$status} successfully!");
    }

    /**
     * Export orders to Excel or PDF
     */
    public function exportOrders(Request $request)
    {
        $format = $request->input('format', 'excel'); // Default to excel
        
        // Build the query with the same filters as the orders page
        $query = Order::query();

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply date range filters
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Order by creation date
        $query->orderBy('created_at', 'desc');

        if ($format === 'pdf') {
            return $this->exportToPDF($query);
        }

        return $this->exportToExcel($query);
    }

    /**
     * Export orders to Excel
     */
    private function exportToExcel($query)
    {
        $filename = 'orders_' . date('Y-m-d_His') . '.xlsx';
        return Excel::download(new OrdersExport($query), $filename);
    }

    /**
     * Export orders to PDF
     */
    private function exportToPDF($query)
    {
        $orders = $query->get();
        $filename = 'orders_' . date('Y-m-d_His') . '.pdf';
        
        $pdf = Pdf::loadView('admin.exports.orders-pdf', compact('orders'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }
}
