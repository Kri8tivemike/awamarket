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

class CategoryController extends Controller
{
    public function index(Request $request)
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

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
                'image' => ImageHandler::getValidationRules(2048, false),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['name', 'description']);
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = ImageHandler::uploadImage(
                    $request->file('image'),
                    'uploads/categories'
                );
            }

            $category = Category::create($data);

            Log::info('Category created', ['category_id' => $category->id, 'name' => $category->name]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating category', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'nullable|string',
                'image' => ImageHandler::getValidationRules(2048, false),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['name', 'description']);
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = ImageHandler::uploadImage(
                    $request->file('image'),
                    'uploads/categories',
                    $category->image
                );
            }

            $category->update($data);

            Log::info('Category updated', ['category_id' => $category->id, 'name' => $category->name]);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating category', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            // Check if category has products
            if ($category->products()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with products. Please delete all products first.'
                ], 400);
            }
            
            // Delete image file if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            Log::info('Category deleted', ['category_id' => $category->id, 'name' => $category->name]);

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting category', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get categories for API (used in dropdowns)
     */
    public function api()
    {
        $categories = Category::where('is_active', true)->get();
        return response()->json($categories);
    }

    /**
     * Bulk delete categories
     */
    public function bulkDelete(Request $request)
    {
        try {
            $categoryIds = $request->input('category_ids', []);

            if (empty($categoryIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No categories selected'
                ], 400);
            }

            // Check if any category has products
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
                
                Log::info('Category deleted (bulk)', ['category_id' => $category->id, 'name' => $category->name]);
            }

            // Delete categories from database
            $deletedCount = Category::whereIn('id', $categoryIds)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} " . ($deletedCount === 1 ? 'category' : 'categories') . "!"
            ]);

        } catch (\Exception $e) {
            Log::error('Error bulk deleting categories', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting categories: ' . $e->getMessage()
            ], 500);
        }
    }
}
