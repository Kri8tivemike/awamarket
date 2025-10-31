<x-layouts.app>
    <!-- Main content -->
    <section class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <h1 class="text-2xl font-bold text-gray-900">All Products</h1>
                    
                    <div class="flex items-center gap-2 flex-wrap">
                        @if(request('search'))
                        <div class="flex items-center gap-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-lg text-sm">
                            <span class="text-blue-700">Search: <strong>"{{ request('search') }}"</strong></span>
                            <a href="{{ route('shop.index', request()->except('search')) }}" class="text-blue-700 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                        @endif
                        
                        @if(request('category'))
                        <div class="flex items-center gap-2 px-3 py-1 bg-orange-50 border border-orange-200 rounded-lg text-sm">
                            <span class="text-orange-700">Category: <strong>{{ $categories->find(request('category'))->name ?? 'Category' }}</strong></span>
                            <a href="{{ route('shop.index', request()->except('category')) }}" class="text-orange-700 hover:text-orange-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Filter Button with Dropdown -->
                <div class="relative inline-block mt-4">
                    <button 
                        id="filter-toggle" 
                        onclick="toggleFilterDropdown()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                        </svg>
                        <span class="font-medium text-gray-700">Filter</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    
                    <!-- Filter Dropdown -->
                    <div 
                        id="filter-dropdown" 
                        class="hidden absolute top-full left-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <form method="GET" action="{{ route('shop.index') }}" class="p-6">
                            <!-- Category Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Category</label>
                                <div class="relative">
                                    <select 
                                        name="category" 
                                        id="category-filter"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Choose A Category</option>
                                        @if($categories->count() > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                    Apply filter
                                </button>
                                @if(request('category'))
                                <a href="{{ route('shop.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                    Clear
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6 lg:gap-8">
                    @foreach($products as $product)
                        <x-product-card 
                            :product="$product"
                            name="{{ $product->name }}"
                            image="{{ $product->featured_image ?? ($product->images ? (is_array($product->images) ? ($product->images[0] ?? '') : (json_decode($product->images)[0] ?? '')) : '') }}"
                            :priceMin="$product->price"
                            :priceMax="$product->sale_price ?? $product->price"
                            :optionsCount="$product->options ? (is_array($product->options) ? count($product->options) : count(json_decode($product->options, true))) : 0" />
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16 px-4">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        @if(request('search'))
                            No results found for "{{ request('search') }}"
                        @elseif(request('category'))
                            No products in this category
                        @else
                            No products available
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-6 text-center max-w-md">
                        @if(request('search'))
                            Try adjusting your search terms or browse all products.
                        @elseif(request('category'))
                            Try selecting a different category or clear the filter to view all products.
                        @else
                            Products will appear here once they are added to the store.
                        @endif
                    </p>
                    @if(request('search') || request('category'))
                        <a href="{{ route('shop.index') }}" class="view-all-btn inline-flex items-center px-6 py-3 text-white rounded-lg font-semibold transition-colors">
                            View All Products
                        </a>
                    @endif
                </div>
            @endif
            </div>
        </div>
    </section>

    <script>
        function toggleFilterDropdown() {
            const dropdown = document.getElementById('filter-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const filterToggle = document.getElementById('filter-toggle');
            const dropdown = document.getElementById('filter-dropdown');
            
            if (dropdown && !dropdown.classList.contains('hidden')) {
                if (!filterToggle.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>

    <style>
        .view-all-btn {
            background-color: #f54a00;
        }
        .view-all-btn:hover {
            background-color: #d63e00;
        }
    </style>
</x-layouts.app>
