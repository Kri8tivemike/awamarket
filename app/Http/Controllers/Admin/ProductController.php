<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Utils\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
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

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku',
                'featured_image' => ImageHandler::getValidationRules(2048, false),
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
                $validOptionIndices = [];
                
                foreach ($request->options as $index => $option) {
                    if (!empty($option['title']) && !empty($option['price'])) {
                        $options[$index] = [
                            'title' => $option['title'],
                            'price' => floatval($option['price'])
                        ];
                        $validOptionIndices[] = $index;
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

            Log::info('Product created', ['product_id' => $product->id, 'name' => $product->name]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating product', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // If it's an AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }
        
        // Otherwise, return the view
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        // If it's an AJAX request, return JSON
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

    public function update(Request $request, $id)
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
                'featured_image' => ImageHandler::getValidationRules(2048, false),
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
                $validOptionIndices = [];
                
                foreach ($request->options as $index => $option) {
                    if (!empty($option['title']) && !empty($option['price'])) {
                        $options[$index] = [
                            'title' => $option['title'],
                            'price' => floatval($option['price'])
                        ];
                        $validOptionIndices[] = $index;
                    }
                }
                
                // Clean up option images for deleted options
                if ($product->option_images && is_array($product->option_images)) {
                    $optionImages = $product->option_images;
                    $cleanedOptionImages = [];
                    
                    foreach ($optionImages as $imageIndex => $imagePath) {
                        // Only keep images for options that still exist
                        if (in_array($imageIndex, $validOptionIndices)) {
                            $cleanedOptionImages[$imageIndex] = $imagePath;
                        } else {
                            // Delete orphaned image file
                            $fullPath = public_path('storage/' . $imagePath);
                            if (file_exists($fullPath)) {
                                unlink($fullPath);
                            }
                            Log::info('Deleted orphaned option image', ['index' => $imageIndex, 'path' => $imagePath]);
                        }
                    }
                    
                    $product->option_images = !empty($cleanedOptionImages) ? $cleanedOptionImages : null;
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

            Log::info('Product updated', ['product_id' => $product->id, 'name' => $product->name]);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating product', ['product_id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated image files
        if ($product->featured_image && file_exists(public_path($product->featured_image))) {
            unlink(public_path($product->featured_image));
        }
        
        // Delete option images if they exist
        if ($product->option_images) {
            // option_images is already cast as array in the model
            $optionImages = $product->option_images;
            if (is_array($optionImages)) {
                foreach ($optionImages as $imagePath) {
                    $fullPath = public_path('storage/' . $imagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
        }

        Log::info('Product deleted', ['product_id' => $product->id, 'name' => $product->name]);
        
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully!');
    }
}
