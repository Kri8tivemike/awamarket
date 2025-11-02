<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All Products - AwaMarket Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Modern Alert Styles */
        .modern-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            min-width: 400px;
            max-width: 500px;
            padding: 24px 32px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
        }
        
        .modern-alert.show {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }
        
        .modern-alert.success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #bbf7d0;
            color: #166534;
        }
        
        .modern-alert.error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-color: #fecaca;
            color: #dc2626;
        }
        
        .modern-alert-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .modern-alert-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .modern-alert.success .modern-alert-icon {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        
        .modern-alert.error .modern-alert-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .modern-alert-text {
            flex: 1;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.5;
        }
        
        .modern-alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modern-alert-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Enhanced Scrollbar Styles for Main Content */
        .scrollable-content {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f9fafb;
            max-height: calc(100vh - 120px);
            overflow-x: hidden;
            overflow-y: auto;
            padding-right: 4px;
        }

        .scrollable-content::-webkit-scrollbar {
            width: 8px;
        }

        .scrollable-content::-webkit-scrollbar-track {
            background: #f9fafb;
            border-radius: 4px;
        }

        .scrollable-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }

        .scrollable-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
        }

        .main-content-wrapper {
            height: calc(100vh - 0px);
            overflow: hidden;
            margin-left: 0;
        }

        @media (min-width: 1024px) {
            .main-content-wrapper {
                margin-left: 256px;
            }
        }

        .content-section {
            flex: 1;
            overflow-y: auto;
            height: 100%;
            box-sizing: border-box;
            min-height: fit-content;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .scrollable-content {
                max-height: calc(100vh - 100px);
            }
            
            .header {
                height: 100px;
                flex-shrink: 0;
            }
        }

        @media (max-width: 640px) {
            .scrollable-content {
                max-height: calc(100vh - 80px);
            }
            
            .header {
                height: 80px;
                flex-shrink: 0;
             }
         }
        }
        
        /* Modern Scrollbar Styles for Table */
        .scrollable-table {
            max-height: 600px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(139, 69, 19, 0.3) rgba(248, 246, 240, 0.5);
        }
        
        .scrollable-table::-webkit-scrollbar {
            width: 8px;
        }
        
        .scrollable-table::-webkit-scrollbar-track {
            background: rgba(248, 246, 240, 0.5);
            border-radius: 10px;
            margin: 8px 0;
        }
        
        .scrollable-table::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.4), rgba(139, 69, 19, 0.6));
            border-radius: 10px;
            border: 2px solid rgba(248, 246, 240, 0.5);
            transition: all 0.3s ease;
        }
        
        .scrollable-table::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.6), rgba(139, 69, 19, 0.8));
            border: 2px solid rgba(248, 246, 240, 0.3);
        }
        
        .scrollable-table::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.8), rgba(139, 69, 19, 1));
        }
        
        /* Smooth scrolling behavior */
        .scrollable-table {
            scroll-behavior: smooth;
        }
        
        /* Table header sticky positioning */
        .scrollable-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: inherit;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="admin-body">
    <div class="flex h-screen">
        <!-- Unified Sidebar Component -->
        <x-admin-sidebar currentPage="products" />
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto scrollable-content" style="margin-left: 0; height: calc(100vh - 0px);">
            <style>
                main {
                    margin-left: 0;
                }
                @media (min-width: 1024px) {
                    main {
                        margin-left: 256px;
                    }
                }
            </style>
            <!-- Modern Header -->
            <header style="background-color: #fefdf8; height: 120px;" class="border-b border-amber-200/30 backdrop-blur-sm flex-shrink-0">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">All Products</h2>
                            <p class="text-gray-600 flex items-center text-lg font-medium">
                                <i class="fas fa-box mr-3 text-blue-500 text-xl"></i>
                                Manage your product inventory and catalog
                            </p>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-full px-5 py-3 border border-green-200 shadow-sm">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg"></div>
                                <span class="text-sm font-bold text-green-700 tracking-wide">{{ $totalProducts }} {{ $totalProducts == 1 ? 'product' : 'products' }}</span>
                            </div>
                            <button onclick="openAddProductModal()" style="background-color: #f8f6f0;" class="text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-gray-300 font-semibold text-sm border border-gray-200">
                                <i class="fas fa-plus mr-2 text-sm"></i>
                                Add Product
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="content-section" style="height: calc(100vh - 120px); padding-bottom: 2rem; padding-left: 2rem; padding-right: 2rem; overflow-y: auto;">
                <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Filter Bar -->
                    <form method="GET" action="{{ route('admin.products') }}" id="filterForm">
                        <div class="rounded-2xl p-6 mb-8 shadow-lg" style="background-color: #f8f6f0; border: 1px solid rgba(139, 69, 19, 0.15);">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-2">
                                        <label class="text-sm font-bold" style="color: #8b4513;">Category:</label>
                                        <select name="category_id" id="categoryFilter" class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 shadow-sm" style="focus:ring-color: rgba(139, 69, 19, 0.5);" onchange="submitFilter()">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label class="text-sm font-bold" style="color: #8b4513;">Status:</label>
                                        <select name="status" id="statusFilter" class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 shadow-sm" style="focus:ring-color: rgba(139, 69, 19, 0.5);" onchange="submitFilter()">
                                            <option value="">All Status</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="admin-search-input bg-white border border-gray-300 rounded-lg px-4 py-2 pl-10 text-sm font-semibold text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 w-64 shadow-sm" style="focus:ring-color: rgba(139, 69, 19, 0.5);" onkeyup="debounceSearch(this.value)">
                                    <i class="fas fa-search admin-search-icon"></i>
                                </div>
                                <span class="text-sm font-bold" style="color: #8b4513;">{{ $totalProducts }} products</span>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Products Table -->
                <div class="modern-table overflow-hidden rounded-xl">
                    <div class="scrollable-table">
                        <table class="w-full">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider min-w-0">
                                        <div class="truncate">Product</div>
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider hidden sm:table-cell">
                                        <div class="truncate">Category</div>
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider">
                                        <div class="truncate">Price</div>
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider hidden md:table-cell">
                                        <div class="truncate">Stock</div>
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider hidden lg:table-cell">
                                        <div class="truncate">Options</div>
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider hidden lg:table-cell">
                                        <div class="truncate">Status</div>
                                    </th>
                                    <th class="px-3 py-3 text-left text-xs font-semibold glass-text-dark uppercase tracking-wider">
                                        <div class="truncate">Actions</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($products as $product)
                                <tr class="table-row">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center min-w-0">
                                            <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12">
                                                @if($product->featured_image && file_exists(public_path($product->featured_image)))
                                                    <img src="{{ asset($product->featured_image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl object-cover shadow-md">
                                                @else
                                                    <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 shadow-md flex items-center justify-center">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-2 sm:ml-4 min-w-0 flex-1">
                                                <div class="text-sm font-semibold glass-text-dark truncate">{{ $product->name }}</div>
                                                <div class="text-xs sm:text-sm glass-text-light truncate">SKU: {{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-blue-500">
                                            {{ $product->category->name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-3">
                                        <div class="text-sm font-semibold glass-text-dark">
                                            @if($product->sale_price && $product->sale_price != $product->price)
                                                <div class="flex flex-col">
                                                    <span class="text-gray-700">₦{{ number_format($product->price, 2) }}</span>
                                                    <span class="text-xs text-gray-500">- ₦{{ number_format($product->sale_price, 2) }}</span>
                                                </div>
                                            @else
                                                ₦{{ number_format($product->price, 2) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 hidden md:table-cell">
                                        <div class="text-sm glass-text-medium">{{ $product->stock_quantity }}</div>
                                    </td>
                                    <td class="px-2 py-3 hidden lg:table-cell">
                                        <div class="flex items-center space-x-2">
                                            @php
                                                $optionsCount = 0;
                                                if ($product->options) {
                                                    $optionsArray = is_array($product->options) ? $product->options : json_decode($product->options, true);
                                                    $optionsCount = is_array($optionsArray) ? count($optionsArray) : 0;
                                                }
                                                $hasOptionImages = $product->option_images && is_array($product->option_images) && count($product->option_images) > 0;
                                            @endphp
                                            
                                            @if($optionsCount > 0)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                                    {{ $optionsCount }} {{ $optionsCount === 1 ? 'option' : 'options' }}
                                                </span>
                                            @endif
                                            
                                            @if($hasOptionImages)
                                                <div class="flex items-center space-x-1">
                                                    @foreach(array_slice($product->option_images, 0, 2) as $index => $imagePath)
                                                        @if($imagePath && file_exists(public_path('storage/' . $imagePath)))
                                                            <img src="{{ asset('storage/' . $imagePath) }}" 
                                                                 alt="Option {{ $index + 1 }}" 
                                                                 class="w-6 h-6 rounded object-cover border border-gray-200 shadow-sm"
                                                                 title="Option {{ $index + 1 }} Image">
                                                        @endif
                                                    @endforeach
                                                    @if(count($product->option_images) > 2)
                                                        <span class="text-xs text-gray-500 bg-gray-100 px-1 py-0.5 rounded">
                                                            +{{ count($product->option_images) - 2 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            @if($optionsCount === 0 && !$hasOptionImages)
                                                <span class="text-xs text-gray-400">No options</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 hidden lg:table-cell">
                                        @if($product->status === 'active' && $product->stock_quantity > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-green-500">
                                                Active
                                            </span>
                                        @elseif($product->stock_quantity <= 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-red-500">
                                                Out of Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-gray-500">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 text-sm font-medium">
                                        <div class="flex items-center space-x-1">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors text-xs font-medium">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="text-green-600 hover:text-green-800 p-1.5 rounded-lg hover:bg-green-50 transition-colors hidden sm:inline-flex">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                            <p class="text-gray-500 mb-4">Get started by adding your first product.</p>
                                            <button onclick="openAddProductModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Add Product
                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                <div class="rounded-2xl p-6 mt-8 shadow-lg" style="background-color: #f8f6f0; border: 1px solid rgba(139, 69, 19, 0.15);">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm" style="color: #8b4513;">Showing</span>
                            <span class="text-sm font-semibold" style="color: #8b4513;">{{ $products->firstItem() ?? 0 }}</span>
                            <span class="text-sm" style="color: #8b4513;">to</span>
                            <span class="text-sm font-semibold" style="color: #8b4513;">{{ $products->lastItem() ?? 0 }}</span>
                            <span class="text-sm" style="color: #8b4513;">of</span>
                            <span class="text-sm font-semibold" style="color: #8b4513;">{{ $products->total() }}</span>
                            <span class="text-sm" style="color: #8b4513;">results</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <!-- Previous Page Button -->
                            @if($products->onFirstPage())
                                <button class="px-3 py-2 rounded-lg border cursor-not-allowed" style="background-color: rgba(139, 69, 19, 0.1); border-color: rgba(139, 69, 19, 0.2); color: #a0522d;" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 rounded-lg border transition-colors hover:bg-opacity-80" style="background-color: #f8f6f0; border-color: rgba(139, 69, 19, 0.2); color: #8b4513;">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            <!-- Page Numbers -->
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if($page == $products->currentPage())
                                    <button class="px-4 py-2 rounded-lg font-semibold shadow-md" style="background-color: #8b4513; color: white;">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 rounded-lg border font-semibold transition-colors hover:bg-opacity-80" style="background-color: #f8f6f0; border-color: rgba(139, 69, 19, 0.2); color: #8b4513;">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            <!-- Next Page Button -->
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 rounded-lg border transition-colors hover:bg-opacity-80" style="background-color: #f8f6f0; border-color: rgba(139, 69, 19, 0.2); color: #8b4513;">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button class="px-3 py-2 rounded-lg border cursor-not-allowed" style="background-color: rgba(139, 69, 19, 0.1); border-color: rgba(139, 69, 19, 0.2); color: #a0522d;" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                </div>
        </main>
    </div>
    
    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center py-4">
        <div class="relative mx-auto border w-11/12 md:w-2/3 lg:w-1/2 xl:w-2/5 max-w-2xl shadow-lg rounded-lg bg-white max-h-[95vh] flex flex-col">
            <!-- Fixed Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-white rounded-t-lg">
                <h3 class="text-lg font-medium text-gray-900">Add New Product</h3>
                <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto modal-scrollbar smooth-scroll p-6">
            <div class="mt-3">
                <form id="addProductForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                            <input type="text" name="sku" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Auto-generated from product name">
                        <p class="text-xs text-gray-500 mt-1">URL-friendly version of the product name (auto-generated if left empty)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <textarea name="short_description" id="edit_short_description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        <input type="file" name="featured_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Upload a featured image for this product (JPG, PNG, GIF)</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min price *</label>
                            <input type="number" name="price" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max price</label>
                            <input type="number" name="sale_price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select name="category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                <!-- Categories will be loaded dynamically -->
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                            <input type="number" name="weight" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                            <input type="text" name="dimensions" placeholder="L x W x H" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="manage_stock" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Manage Stock</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="featured" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                        </label>
                    </div>
                    
                    <!-- Add Options Collapsible Section -->
                    <div class="border border-gray-200 rounded-lg">
                        <button type="button" onclick="toggleAddOptions()" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors rounded-t-lg">
                            <span class="text-sm font-medium text-gray-700">Add Options (e.g., Size, Weight, Quantity)</span>
                            <i id="addOptionsIcon" class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="addOptionsContent" class="hidden p-4 border-t border-gray-200">
                            <div id="optionsContainer" class="space-y-4">
                                <!-- Options will be added dynamically -->
                            </div>
                            <button type="button" onclick="addNewOption()" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Option
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Fixed Footer -->
            <div class="border-t border-gray-200 p-6 bg-white rounded-b-lg">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAddProductModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="addProductForm" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Add Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal - Moved outside main container -->
    <div id="editProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden items-center justify-center py-4" style="z-index: 9999;">
        <div class="relative mx-auto border w-11/12 md:w-2/3 lg:w-1/2 xl:w-2/5 max-w-2xl shadow-lg rounded-lg bg-white max-h-[95vh] flex flex-col">
            <!-- Fixed Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-white rounded-t-lg">
                <h3 class="text-lg font-medium text-gray-900">Edit Product</h3>
                <button onclick="closeEditProductModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto modal-scrollbar smooth-scroll p-6">
            <div class="mt-3">
                <form id="editProductForm" class="space-y-4">
                    <input type="hidden" name="product_id" id="edit_product_id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                            <input type="text" name="sku" id="edit_sku" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="edit_description" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <textarea name="short_description" id="edit_short_description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        <input type="file" name="featured_image" id="edit_featured_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Upload a new featured image (JPG, PNG, GIF) or leave empty to keep current image</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min price *</label>
                            <input type="number" name="price" id="edit_price" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max price</label>
                            <input type="number" name="sale_price" id="edit_sale_price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" id="edit_stock_quantity" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select name="category_id" id="edit_category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                <!-- Categories will be loaded dynamically -->
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="edit_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                            <input type="number" name="weight" id="edit_weight" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                            <input type="text" name="dimensions" id="edit_dimensions" placeholder="L x W x H" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="manage_stock" id="edit_manage_stock" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Manage Stock</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="featured" id="edit_featured" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                        </label>
                    </div>
                    
                    <!-- Add Options Collapsible Section -->
                    <div class="border border-gray-200 rounded-lg">
                        <button type="button" onclick="toggleEditAddOptions()" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors rounded-t-lg">
                            <span class="text-sm font-medium text-gray-700">Add Options (e.g., Size, Weight, Quantity)</span>
                            <i id="editAddOptionsIcon" class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="editAddOptionsContent" class="hidden p-4 border-t border-gray-200">
                            <div id="editOptionsContainer" class="space-y-4">
                                <!-- Options will be added dynamically -->
                            </div>
                            <button type="button" onclick="addNewEditOption()" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Option
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Fixed Footer -->
            <div class="border-t border-gray-200 p-6 bg-white rounded-b-lg">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="editProductForm" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Update Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Product Modal -->
    <div id="viewProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative mx-auto p-6 border w-11/12 md:w-2/3 lg:w-1/3 xl:w-1/4 max-w-md shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Product Details</h3>
                    <button onclick="closeViewProductModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="viewProductContent" class="space-y-4">
                    <!-- Product details will be loaded here -->
                </div>
                <div class="flex justify-end pt-4">
                    <button onclick="closeViewProductModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // CSRF Token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // Load categories for dropdowns
        async function loadCategories() {
            try {
                const response = await fetch('/admin/categories/api');
                const categories = await response.json();
                
                const addCategorySelect = document.querySelector('#addProductModal select[name="category_id"]');
                const editCategorySelect = document.querySelector('#editProductModal select[name="category_id"]');
                
                [addCategorySelect, editCategorySelect].forEach(select => {
                    if (select) {
                        select.innerHTML = '<option value="">Select Category</option>';
                        categories.forEach(category => {
                            select.innerHTML += `<option value="${category.id}">${category.name}</option>`;
                        });
                    }
                });
            } catch (error) {
                console.error('Error loading categories:', error);
                // Show user-friendly error message
                showModernAlert('Error loading categories. Please refresh the page and try again.', 'error');
            }
        }
        
        // Add Product Modal Functions
        async function openAddProductModal() {
            // Ensure edit modal is closed first
            closeEditProductModal();
            
            await loadCategories();
            document.getElementById('addProductModal').classList.remove('hidden');
        }
        
        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
            document.getElementById('addProductForm').reset();
        }
        
        // Edit Product Modal Functions
        async function openEditProductModal(id) {
            console.log('openEditProductModal function called with id:', id);
            
            // Ensure add modal is closed first
            closeAddProductModal();
            
            // Show modal using CSS classes
            const modal = document.getElementById('editProductModal');
            console.log('Modal element found:', modal);
            
            if (!modal) {
                console.error('Edit product modal not found');
                return;
            }
            
            // Show modal by removing hidden class and adding flex
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            console.log('Modal classes after showing:', modal.className);
            console.log('Modal computed styles after:', window.getComputedStyle(modal).display);
            
            // Clear form first to show loading state
            document.getElementById('edit_product_id').value = id;
            document.getElementById('edit_name').value = '';
            document.getElementById('edit_sku').value = '';
            document.getElementById('edit_description').value = '';
            document.getElementById('edit_short_description').value = '';
            document.getElementById('edit_price').value = '';
            document.getElementById('edit_sale_price').value = '';
            document.getElementById('edit_stock_quantity').value = '';
            document.getElementById('edit_status').value = 'active';
            document.getElementById('edit_weight').value = '';
            document.getElementById('edit_dimensions').value = '';
            document.getElementById('edit_manage_stock').checked = false;
            document.getElementById('edit_featured').checked = false;
            
            // Show loading indicator in form fields
            const loadingText = 'Loading...';
            document.getElementById('edit_name').placeholder = loadingText;
            document.getElementById('edit_sku').placeholder = loadingText;
            document.getElementById('edit_description').placeholder = loadingText;
            
            try {
                // Load categories first and wait for completion
                console.log('Loading categories...');
                await loadCategories();
                console.log('Categories loaded successfully');
                
                // Then fetch product data
                console.log('Fetching product data...');
                const response = await fetch(`/admin/products/${id}/edit`);
                const data = await response.json();
                
                if (data.success) {
                    console.log('Data success is true, populating form...');
                    // Populate form fields
                    document.getElementById('edit_product_id').value = data.product.id;
                    document.getElementById('edit_name').value = data.product.name;
                    document.getElementById('edit_sku').value = data.product.sku;
                    document.getElementById('edit_description').value = data.product.description;
                    document.getElementById('edit_short_description').value = data.product.short_description || '';
                    document.getElementById('edit_price').value = data.product.price;
                    document.getElementById('edit_sale_price').value = data.product.sale_price || '';
                    document.getElementById('edit_stock_quantity').value = data.product.stock_quantity;
                    document.getElementById('edit_category_id').value = data.product.category_id;
                    document.getElementById('edit_status').value = data.product.status;
                    document.getElementById('edit_weight').value = data.product.weight || '';
                    document.getElementById('edit_dimensions').value = data.product.dimensions || '';
                    document.getElementById('edit_manage_stock').checked = data.product.manage_stock;
                    document.getElementById('edit_featured').checked = data.product.featured;
                    
                    // Clear loading placeholders
                    document.getElementById('edit_name').placeholder = '';
                    document.getElementById('edit_sku').placeholder = '';
                    document.getElementById('edit_description').placeholder = '';
                    
                    console.log('Form populated successfully');
                } else {
                    console.log('Data success is false:', data);
                    showModernAlert('Error loading product details', 'error');
                }
            } catch (error) {
                console.error('Error loading product:', error);
                showModernAlert('Error loading product details', 'error');
                // Clear loading placeholders on error
                document.getElementById('edit_name').placeholder = '';
                document.getElementById('edit_sku').placeholder = '';
                document.getElementById('edit_description').placeholder = '';
            }
        }
        
        function closeEditProductModal() {
            const modal = document.getElementById('editProductModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.getElementById('editProductForm').reset();
        }
        
        // View Product Modal Functions
        function closeViewProductModal() {
            document.getElementById('viewProductModal').classList.add('hidden');
        }
        
        // CRUD Functions
        async function viewProduct(id) {
            try {
                const response = await fetch(`/admin/products/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    const product = data.product;
                    const content = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><strong>Name:</strong> ${product.name}</div>
                            <div><strong>SKU:</strong> ${product.sku}</div>
                            <div><strong>Price:</strong> ₦${parseFloat(product.price).toFixed(2)}</div>
                            <div><strong>Sale Price:</strong> ${product.sale_price ? '₦' + parseFloat(product.sale_price).toFixed(2) : 'N/A'}</div>
                            <div><strong>Stock:</strong> ${product.stock_quantity}</div>
                            <div><strong>Category:</strong> ${product.category?.name || 'No Category'}</div>
                            <div><strong>Status:</strong> ${product.status}</div>
                            <div><strong>Weight:</strong> ${product.weight || 'N/A'} kg</div>
                        </div>
                        <div class="mt-4">
                            <strong>Description:</strong>
                            <p class="mt-2 text-gray-700">${product.description}</p>
                        </div>
                        ${product.short_description ? `
                        <div class="mt-4">
                            <strong>Short Description:</strong>
                            <p class="mt-2 text-gray-700">${product.short_description}</p>
                        </div>
                        ` : ''}
                    `;
                    
                    document.getElementById('viewProductContent').innerHTML = content;
                    document.getElementById('viewProductModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading product:', error);
                showModernAlert('Error loading product details', 'error');
            }
        }
        
        async function deleteProduct(id) {
            try {
                const response = await fetch(`/admin/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showModernAlert(data.message, 'success');
                    setTimeout(() => {
                        location.reload(); // Refresh the page to update the product list
                    }, 1500);
                } else {
                    showModernAlert('Error deleting product', 'error');
                }
            } catch (error) {
                console.error('Error deleting product:', error);
                showModernAlert('Error deleting product', 'error');
            }
        }
        
        // Form submission handlers
        document.getElementById('addProductForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Add loading state to submit button (button is outside form, so find it by form attribute)
            const submitButton = document.querySelector('button[form="addProductForm"]');
            const originalButtonText = submitButton ? submitButton.innerHTML : '';
            
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
            }
            
            try {
                const response = await fetch('/admin/products', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                // Handle validation errors (422)
                if (response.status === 422) {
                    if (result.errors) {
                        // Format validation errors nicely
                        const errorMessages = Object.entries(result.errors)
                            .map(([field, messages]) => {
                                const fieldName = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                                return `${fieldName}: ${messages.join(', ')}`;
                            })
                            .join('\n');
                        showModernAlert(`Validation Errors:\n\n${errorMessages}`, 'error');
                    } else {
                        showModernAlert(result.message || 'Validation failed', 'error');
                    }
                } else if (result.success) {
                    showModernAlert(result.message || 'Product created successfully!', 'success');
                    closeAddProductModal();
                    setTimeout(() => {
                        location.reload(); // Refresh the page to show the new product
                    }, 1500);
                } else {
                    showModernAlert(result.message || 'Error creating product', 'error');
                }
            } catch (error) {
                console.error('Error creating product:', error);
                showModernAlert('Error creating product: ' + error.message, 'error');
            } finally {
                // Restore button state
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }
        });
        
        document.getElementById('editProductForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const productId = formData.get('product_id');
            formData.delete('product_id');
            
            // Add loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            
            try {
                // Validate required fields before submission
                const requiredFields = ['name', 'sku', 'description', 'price', 'stock_quantity', 'category_id'];
                const missingFields = [];
                
                for (const field of requiredFields) {
                    const value = formData.get(field);
                    if (!value || value.trim() === '') {
                        missingFields.push(field.replace('_', ' ').toUpperCase());
                    }
                }
                
                if (missingFields.length > 0) {
                    throw new Error(`Please fill in the following required fields: ${missingFields.join(', ')}`);
                }
                
                const response = await fetch(`/admin/products/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (result.success) {
                    showModernAlert(result.message || 'Product updated successfully!', 'success');
                    closeEditProductModal();
                    
                    // Update the product row in the table instead of full page reload
                    setTimeout(() => {
                        location.reload(); // Refresh the page to show updated product
                    }, 1500);
                } else {
                    if (result.errors) {
                        // Show validation errors in a more user-friendly way
                        const errorMessages = Object.entries(result.errors)
                            .map(([field, messages]) => `${field.toUpperCase()}: ${messages.join(', ')}`)
                            .join('\n');
                        showModernAlert(`Validation Errors:\n${errorMessages}`, 'error');
                    } else {
                        showModernAlert(result.message || 'Error updating product', 'error');
                    }
                }
            } catch (error) {
                console.error('Error updating product:', error);
                showModernAlert(error.message || 'Network error occurred while updating product', 'error');
            } finally {
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
        
        // Filter functionality
        function submitFilter() {
            document.getElementById('filterForm').submit();
        }

        // Debounced search function
        let searchTimeout;
        function debounceSearch(searchValue) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500); // Wait 500ms after user stops typing
        }

        // Add Options Functions for Add Product Form
        function toggleAddOptions() {
            const content = document.getElementById('addOptionsContent');
            const icon = document.getElementById('addOptionsIcon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        let addOptionCounter = 0;
        function addNewOption() {
            addOptionCounter++;
            const container = document.getElementById('optionsContainer');
            const optionDiv = document.createElement('div');
            optionDiv.className = 'border border-gray-200 rounded-lg p-4 bg-gray-50';
            optionDiv.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700">Option ${addOptionCounter}</h4>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Title</label>
                        <input type="text" name="options[${addOptionCounter}][title]" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g., 1kg, 500g, Small">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
                        <input type="number" name="options[${addOptionCounter}][price]" step="0.01" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g., 10.00">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Option Image</label>
                    <div class="flex items-center space-x-3">
                        <input type="file" name="option_images[${addOptionCounter}]" accept="image/*" class="hidden" id="optionImage${addOptionCounter}" onchange="previewOptionImage(this, ${addOptionCounter})">
                        <button type="button" onclick="document.getElementById('optionImage${addOptionCounter}').click()" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                            <i class="fas fa-camera mr-1"></i>
                            Choose Image
                        </button>
                        <div id="optionImagePreview${addOptionCounter}" class="hidden">
                            <div class="relative inline-block">
                                <img id="optionImageImg${addOptionCounter}" src="" alt="Option Image" class="w-12 h-12 object-cover rounded border">
                                <button type="button" onclick="removeOptionImage(${addOptionCounter})" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(optionDiv);
        }

        // Add Options Functions for Edit Product Form
        function toggleEditAddOptions() {
            const content = document.getElementById('editAddOptionsContent');
            const icon = document.getElementById('editAddOptionsIcon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        let editOptionCounter = 0;
        function addNewEditOption() {
            editOptionCounter++;
            const container = document.getElementById('editOptionsContainer');
            const optionDiv = document.createElement('div');
            optionDiv.className = 'border border-gray-200 rounded-lg p-4 bg-gray-50';
            optionDiv.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700">Option ${editOptionCounter}</h4>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Title</label>
                        <input type="text" name="options[${editOptionCounter}][title]" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g., 1kg, 500g, Small">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
                        <input type="number" name="options[${editOptionCounter}][price]" step="0.01" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g., 10.00">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Option Image</label>
                    <div class="flex items-center space-x-3">
                        <input type="file" name="option_images[${editOptionCounter}]" accept="image/*" class="hidden" id="editOptionImage${editOptionCounter}" onchange="previewEditOptionImage(this, ${editOptionCounter})">
                        <button type="button" onclick="document.getElementById('editOptionImage${editOptionCounter}').click()" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                            <i class="fas fa-camera mr-1"></i>
                            Choose Image
                        </button>
                        <div id="editOptionImagePreview${editOptionCounter}" class="hidden">
                            <div class="relative inline-block">
                                <img id="editOptionImageImg${editOptionCounter}" src="" alt="Option Image" class="w-12 h-12 object-cover rounded border">
                                <button type="button" onclick="removeEditOptionImage(${editOptionCounter})" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(optionDiv);
        }

        // Modern Alert System
        function showModernAlert(message, type = 'success') {
            // Remove existing alerts
            const existingAlert = document.querySelector('.modern-alert');
            const existingOverlay = document.querySelector('.modern-alert-overlay');
            if (existingAlert) existingAlert.remove();
            if (existingOverlay) existingOverlay.remove();
            
            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'modern-alert-overlay';
            document.body.appendChild(overlay);
            
            // Create alert
            const alert = document.createElement('div');
            alert.className = `modern-alert ${type}`;
            
            const icon = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation-triangle';
            
            alert.innerHTML = `
                <div class="modern-alert-content">
                    <div class="modern-alert-icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="modern-alert-text">${message}</div>
                </div>
            `;
            
            document.body.appendChild(alert);
            
            // Show with animation
            setTimeout(() => {
                overlay.classList.add('show');
            }, 10);
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                overlay.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(overlay);
                }, 300);
            }, 3000);
        }

        // Image handling functions for Add Product modal
        function previewOptionImage(input, optionId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`optionImagePreview${optionId}`);
                    const img = document.getElementById(`optionImageImg${optionId}`);
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeOptionImage(optionId) {
            const input = document.getElementById(`optionImage${optionId}`);
            const preview = document.getElementById(`optionImagePreview${optionId}`);
            const img = document.getElementById(`optionImageImg${optionId}`);
            
            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
        }

        // Image handling functions for Edit Product modal
        function previewEditOptionImage(input, optionId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`editOptionImagePreview${optionId}`);
                    const img = document.getElementById(`editOptionImageImg${optionId}`);
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeEditOptionImage(optionId) {
            const input = document.getElementById(`editOptionImage${optionId}`);
            const preview = document.getElementById(`editOptionImagePreview${optionId}`);
            const img = document.getElementById(`editOptionImageImg${optionId}`);
            
            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
        }

    </script>
</body>
</html>