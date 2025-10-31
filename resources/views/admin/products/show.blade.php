<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/admin.css') }}">
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-amber-800 to-orange-700 shadow-xl border-b-4 border-amber-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span class="font-semibold">Back to Dashboard</span>
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

        <!-- Product Header -->
        <div class="bg-white rounded-xl shadow-lg border border-amber-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-amber-900">{{ $product->name }}</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            SKU: {{ $product->sku }} | Created {{ $product->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                        @if($product->status === 'active' && $product->stock_quantity > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-green-500">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                Active
                            </span>
                        @elseif($product->stock_quantity <= 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-red-500">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                Out of Stock
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-gray-500">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ ucfirst($product->status) }}
                            </span>
                        @endif
                        @if($product->featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-yellow-500">
                                <i class="fas fa-star mr-2 text-xs"></i>
                                Featured
                            </span>
                        @endif
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors shadow-md">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Images -->
                @if($product->featured_image || $product->images)
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-images mr-2"></i>
                            Product Images
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @if($product->featured_image)
                                <div class="relative">
                                    <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover rounded-lg shadow-md">
                                    <span class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">
                                        Featured
                                    </span>
                                </div>
                            @endif
                            @if($product->images)
                                @php
                                    $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                                @endphp
                                @if(is_array($images))
                                    @foreach($images as $image)
                                        @if(is_string($image) && !empty($image))
                                            <div class="relative">
                                                <img src="{{ asset($image) }}" alt="{{ $product->name }}" 
                                                     class="w-full h-48 object-cover rounded-lg shadow-md">
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        @if(!$product->featured_image && !$product->images)
                            <div class="text-center py-8">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">No images available</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Product Information -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Product Information
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <p class="text-gray-900">{{ $product->category->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                                <p class="text-gray-900 font-mono">{{ $product->sku }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                                <p class="text-gray-900 font-mono">{{ $product->slug }}</p>
                            </div>
                        </div>
                        
                        @if($product->short_description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                            <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $product->short_description }}</p>
                        </div>
                        @endif
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Description</label>
                            <div class="text-gray-900 bg-gray-50 p-4 rounded-lg prose max-w-none">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Specifications -->
                @if($product->weight || $product->dimensions)
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-ruler mr-2"></i>
                            Specifications
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($product->weight)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Weight</label>
                                <p class="text-gray-900">{{ $product->weight }} kg</p>
                            </div>
                            @endif
                            @if($product->dimensions)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                                <p class="text-gray-900">{{ $product->dimensions }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Product Options -->
                @if($product->options && $product->options !== '[]')
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-amber-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-cog mr-2"></i>
                            Product Options
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        @php
                            $options = is_array($product->options) ? $product->options : json_decode($product->options, true);
                            $optionImages = is_array($product->option_images) ? $product->option_images : (json_decode($product->option_images, true) ?? []);
                        @endphp
                        
                        @if(is_array($options))
                            @foreach($options as $index => $option)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-medium text-gray-900">Option {{ $index + 1 }}</h4>
                                        @if(isset($optionImages[$index]) && $optionImages[$index])
                                            <img src="{{ asset('storage/' . $optionImages[$index]) }}" alt="Option Image" class="w-16 h-16 object-cover rounded-md border shadow-sm">
                                        @endif
                                    </div>
                                    
                                    @if(is_array($option) && (isset($option['title']) || isset($option['type'])))
                                        <!-- Structured option format -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                                <p class="text-gray-900 bg-white px-3 py-2 rounded border">{{ $option['title'] ?? ucfirst($option['type'] ?? 'N/A') }}</p>
                                            </div>
                                            @if(isset($option['price']))
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                                <p class="text-green-600 font-bold bg-white px-3 py-2 rounded border">₦{{ number_format($option['price'], 2) }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    @elseif(is_array($option))
                                        <!-- Array format -->
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($option as $item)
                                                <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ $item }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Simple value -->
                                        <p class="text-gray-900">{{ $option }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No options available</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Pricing Information -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-dollar-sign mr-2"></i>
                            Estimated price
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min price</label>
                            <p class="text-2xl font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                        @if($product->sale_price)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max price</label>
                            <p class="text-2xl font-bold text-red-600">₦{{ number_format($product->sale_price, 2) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Inventory Information -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-boxes mr-2"></i>
                            Inventory
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                            <p class="text-2xl font-bold {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock_quantity }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Management</label>
                            <p class="text-gray-900">
                                {{ $product->manage_stock ? 'Enabled' : 'Disabled' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">In Stock</label>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->in_stock ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                {{ $product->in_stock ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Product Meta -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-calendar mr-2"></i>
                            Meta Information
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                            <p class="text-gray-900">{{ $product->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $product->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ Vite::asset('resources/js/admin.js') }}"></script>
</body>
</html>