<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js', 'resources/js/admin.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-amber-800 to-orange-700 shadow-xl border-b-4 border-amber-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.products.show', $product->id) }}" class="flex items-center space-x-3 text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span class="font-semibold">Back to Product</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.products') }}" class="text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-list mr-2"></i>All Products
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-lg border border-amber-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-amber-900">Edit Product</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ $product->name }} (SKU: {{ $product->sku }})</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('admin.products.show', $product->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md">
                            <i class="fas fa-eye mr-2"></i>
                            View Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Basic Information
                            </h2>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('name') border-red-500 @enderror" 
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('sku') border-red-500 @enderror" 
                                           required>
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('slug') border-red-500 @enderror">
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                                <textarea id="short_description" name="short_description" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('short_description') border-red-500 @enderror">{{ old('short_description', $product->short_description) }}</textarea>
                                @error('short_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Full Description *</label>
                                <textarea id="description" name="description" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('description') border-red-500 @enderror" 
                                          required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-dollar-sign mr-2"></i>
                                Pricing
                            </h2>
                        </div>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Min price *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">₦</span>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" 
                                               step="0.01" min="0" 
                                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('price') border-red-500 @enderror" 
                                               required>
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">Max price</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">₦</span>
                <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" 
                                               step="0.01" min="0" 
                                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('sale_price') border-red-500 @enderror">
                                    </div>
                                    @error('sale_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-boxes mr-2"></i>
                                Inventory
                            </h2>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                           min="0" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('stock_quantity') border-red-500 @enderror" 
                                           required>
                                    @error('stock_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center space-x-4 pt-8">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="manage_stock" value="1" 
                                               {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">Manage Stock</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="in_stock" value="1" 
                                               {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">In Stock</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-ruler mr-2"></i>
                                Specifications
                            </h2>
                        </div>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                                    <input type="number" id="weight" name="weight" value="{{ old('weight', $product->weight) }}" 
                                           step="0.01" min="0" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('weight') border-red-500 @enderror">
                                    @error('weight')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Dimensions</label>
                                    <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" 
                                           placeholder="L x W x H" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('dimensions') border-red-500 @enderror">
                                    @error('dimensions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Options -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-list mr-2"></i>
                                Product Options
                            </h2>
                        </div>
                        <div class="px-6 py-4">
                            <div id="optionsContainer" class="space-y-4">
                                @php
                                    $existingOptions = [];
                                    $existingOptionImages = [];
                                    if ($product->options) {
                                        // Options are already decoded by the accessor
                                        $existingOptions = is_array($product->options) ? $product->options : (json_decode($product->options, true) ?? []);
                                    }
                                    if ($product->option_images) {
                                        // Option images are already decoded by the accessor
                                        $existingOptionImages = is_array($product->option_images) ? $product->option_images : (json_decode($product->option_images, true) ?? []);
                                    }
                                @endphp
                                
                                @if(!empty($existingOptions))
                                    @foreach($existingOptions as $index => $option)
                                        <div class="option-item border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <div class="flex justify-between items-center mb-3">
                                                <h4 class="font-medium text-gray-700">Option {{ $index + 1 }}</h4>
                                                <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="fas fa-trash mr-1"></i>Remove
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                                    <input type="text" name="options[{{ $index }}][title]" value="{{ $option['title'] ?? $option['type'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm" placeholder="e.g., 1kg, 500g, Small">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (₦)</label>
                                                    <input type="number" name="options[{{ $index }}][price]" value="{{ $option['price'] ?? '' }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm" placeholder="0.00">
                                                </div>
                                            </div>
                                            <!-- Option Image Upload -->
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Option Image</label>
                                                <div class="flex items-center space-x-3">
                                                    <input type="file" name="option_images[{{ $index }}]" accept="image/*" class="hidden" id="option_image_{{ $index }}" onchange="previewOptionImage(this, {{ $index }})">
                                                    <button type="button" onclick="document.getElementById('option_image_{{ $index }}').click()" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors text-sm">
                                                        <i class="fas fa-upload mr-2"></i>Choose Image
                                                    </button>
                                                    @if(isset($existingOptionImages[$index]) && $existingOptionImages[$index])
                                                        <div class="flex items-center space-x-2">
                                                            <img src="{{ asset('storage/' . $existingOptionImages[$index]) }}" alt="Option Image" class="w-12 h-12 object-cover rounded-md border">
                                                            <button type="button" onclick="removeOptionImage({{ $index }})" class="text-red-600 hover:text-red-800 text-sm">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div id="option_image_preview_{{ $index }}" class="mt-2 hidden">
                                                    <img src="" alt="Preview" class="w-20 h-20 object-cover rounded-md border">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" onclick="addNewOption()" class="mt-4 px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors text-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Option
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Product Status -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-toggle-on mr-2"></i>
                                Status & Visibility
                            </h2>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select id="status" name="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select id="category_id" name="category_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('category_id') border-red-500 @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="featured" name="featured" value="1" 
                                       {{ old('featured', $product->featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                <label for="featured" class="ml-2 text-sm text-gray-700">Featured Product</label>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                                <i class="fas fa-images mr-2"></i>
                                Product Images
                            </h2>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                                <input type="file" id="featured_image" name="featured_image" accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('featured_image') border-red-500 @enderror">
                                @error('featured_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($product->featured_image)
                                    <div class="mt-2">
                                        <img src="{{ asset($product->featured_image) }}" alt="Current featured image" 
                                             class="w-20 h-20 object-cover rounded-lg">
                                        <p class="text-xs text-gray-500 mt-1">Current featured image</p>
                                    </div>
                                @endif
                            </div>


                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                        <div class="px-6 py-4">
                            <div class="flex flex-col space-y-3">
                                <button type="submit" 
                                        class="w-full bg-amber-600 text-white py-3 px-4 rounded-lg hover:bg-amber-700 transition-colors shadow-md font-semibold">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Product
                                </button>
                                <a href="{{ route('admin.products.show', $product->id) }}" 
                                   class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition-colors shadow-md text-center font-semibold">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Admin JS is loaded via @vite directive in the head --}}
    <script>
        // Auto-generate slug from product name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });

        // Options management functions
        let optionIndex = {{ count($existingOptions ?? []) }};

        function addNewOption() {
            const container = document.getElementById('optionsContainer');
            const optionHtml = `
                <div class="option-item border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-700">Option ${optionIndex + 1}</h4>
                        <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fas fa-trash mr-1"></i>Remove
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="options[${optionIndex}][title]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm" placeholder="e.g., 1kg, 500g, Small">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (₦)</label>
                            <input type="number" name="options[${optionIndex}][price]" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm" placeholder="0.00">
                        </div>
                    </div>
                    <!-- Option Image Upload -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Option Image</label>
                        <div class="flex items-center space-x-3">
                            <input type="file" name="option_images[${optionIndex}]" accept="image/*" class="hidden" id="option_image_${optionIndex}" onchange="previewOptionImage(this, ${optionIndex})">
                            <button type="button" onclick="document.getElementById('option_image_${optionIndex}').click()" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors text-sm">
                                <i class="fas fa-upload mr-2"></i>Choose Image
                            </button>
                        </div>
                        <div id="option_image_preview_${optionIndex}" class="mt-2 hidden">
                            <img src="" alt="Preview" class="w-20 h-20 object-cover rounded-md border">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', optionHtml);
            optionIndex++;
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            optionItem.remove();
            updateOptionNumbers();
        }

        function updateOptionNumbers() {
            const optionItems = document.querySelectorAll('.option-item');
            optionItems.forEach((item, index) => {
                const title = item.querySelector('h4');
                title.textContent = `Option ${index + 1}`;
            });
        }

        // Image preview functions
        function previewOptionImage(input, index) {
            const file = input.files[0];
            const previewContainer = document.getElementById(`option_image_preview_${index}`);
            const previewImg = previewContainer.querySelector('img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        function removeOptionImage(index) {
            // Clear the file input
            const fileInput = document.getElementById(`option_image_${index}`);
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Hide the existing image display
            const existingImageContainer = document.querySelector(`#option_image_${index}`).closest('.flex').querySelector('div:last-child');
            if (existingImageContainer) {
                existingImageContainer.style.display = 'none';
            }
            
            // Add a hidden input to mark this image for deletion
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `remove_option_images[${index}]`;
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }
    </script>
</body>
</html>