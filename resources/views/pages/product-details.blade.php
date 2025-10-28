<x-layouts.app>
    <!-- Product Details Section -->
    <section class="py-8 md:py-16 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="/shop-now" class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2 transition-colors duration-200">Shop</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Product Details</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Product Image -->
                    <div class="aspect-square w-full bg-gray-100 rounded-lg overflow-hidden">
                        <img id="main-image" src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    <div class="grid grid-cols-4 gap-2" id="thumbnail-container">
                        <!-- Main Product Image Thumbnail -->
                        <button class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-green-500 thumbnail-btn" 
                                onclick="changeMainImage('{{ $product->image_url }}')">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }} thumbnail" 
                                 class="w-full h-full object-cover">
                        </button>
                        
                        <!-- Product Option Images Thumbnails -->
                        @if($product->option_images_urls && is_array($product->option_images_urls))
                            @foreach($product->option_images_urls as $index => $optionImage)
                                <button class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-300 thumbnail-btn" 
                                        onclick="selectOptionByImage('{{ $optionImage }}', {{ $index }})">
                                    <img src="{{ $optionImage }}" 
                                         alt="Option {{ $index + 1 }} thumbnail" 
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Product Title and Category -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="text-sm text-gray-600">Category:</span>
                            <span class="text-sm font-medium text-green-600">{{ $product->category->name }}</span>
                            <span class="text-sm text-gray-400">•</span>
                            <span class="text-sm text-gray-600">SKU: {{ $product->sku }}</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold text-green-600">₦{{ number_format($product->price, 2) }}</span>
                        @if($product->stock > 0)
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">In Stock ({{ $product->stock }})</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Out of Stock</span>
                        @endif
                    </div>

                    <!-- Product Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description ?? 'No description available for this product.' }}
                        </p>
                    </div>

                    <!-- Product Options -->
                    @if($product->options && is_array($product->options) && count($product->options) > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Pick buy option ({{ count($product->options) }} options available)</h3>
                        <div class="relative">
                            <select id="product-option" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 appearance-none cursor-pointer">
                                <option value="" data-price="{{ $product->price }}">Select an option</option>
                                @foreach($product->options as $index => $option)
                                    <option value="{{ $index }}" data-price="{{ $option['price'] }}" data-title="{{ $option['title'] }}">
                                        {{ $option['title'] }} - ₦{{ number_format($option['price'], 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Product Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Product Details</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Category: {{ $product->category->name }}
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Stock Available: {{ $product->stock }} units
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                SKU: {{ $product->sku }}
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Status: <span class="capitalize">{{ $product->status }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quantity Selector -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quantity</h3>
                        <div class="flex items-center space-x-3">
                            <button onclick="decreaseQuantity()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 h-10 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button onclick="increaseQuantity()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-4">
                        <button id="add-to-cart-btn" onclick="addToCart()" {{ $product->stock <= 0 ? 'disabled' : '' }} class="w-full {{ $product->stock > 0 ? '' : 'bg-gray-400 cursor-not-allowed' }} text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2" {{ $product->stock > 0 ? 'style="background-color: #f54a00;"' : '' }} onmouseover="if(!this.disabled) this.style.backgroundColor='#d63e00'" onmouseout="if(!this.disabled) this.style.backgroundColor='#f54a00'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <span id="cart-btn-text">{{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}</span>
                        </button>
                        
                        <a href="{{ route('cart') }}" class="w-full text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2" style="background-color: #f54a00;" onmouseover="this.style.backgroundColor='#d63e00'" onmouseout="this.style.backgroundColor='#f54a00'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 -960 960 960">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z"></path>
                            </svg>
                            <span>View Cart</span>
                        </a>
                    </div>

                    <!-- Share Product Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Share this product</h3>
                        <div class="flex items-center gap-3">
                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($product->name . ' - ₦' . number_format($product->price, 2) . ' ' . url()->current()) }}" 
                               target="_blank" 
                               class="flex items-center justify-center w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-full transition-colors duration-200"
                               title="Share on WhatsApp">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                            
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-colors duration-200"
                               title="Share on Facebook">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <!-- TikTok -->
                            <a href="https://www.tiktok.com/share?url={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="flex items-center justify-center w-12 h-12 bg-black hover:bg-gray-800 text-white rounded-full transition-colors duration-200"
                               title="Share on TikTok">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                            
                            <!-- Instagram (Copy Link) -->
                            <button onclick="copyProductLink()" 
                                    class="flex items-center justify-center w-12 h-12 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 hover:from-yellow-500 hover:via-pink-600 hover:to-purple-700 text-white rounded-full transition-all duration-200"
                                    title="Copy link for Instagram">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Share this product with your friends and family</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                    <a href="{{ route('product.show', $relatedProduct->id) }}">
                        <div class="aspect-square bg-gray-100">
                            <img src="{{ $relatedProduct->image_url }}" 
                                 alt="{{ $relatedProduct->name }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('product.show', $relatedProduct->id) }}">
                            <h3 class="font-semibold text-gray-900 mb-2 hover:text-green-600 transition-colors duration-200">{{ $relatedProduct->name }}</h3>
                        </a>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">₦{{ number_format($relatedProduct->price, 2) }}</span>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- JavaScript for Product Interactions -->
    <script>
        // Product options and images data
        const productOptions = @json($product->options ?? []);
        const optionImages = @json($product->option_images_urls ?? []);
        const basePrice = {{ $product->price }};
        const baseImage = "{{ $product->image_url }}";

        // Change main product image
        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
            
            // Update thumbnail borders
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-green-500');
                btn.classList.add('border-transparent');
            });
            
            // Add border to clicked thumbnail
            event.target.closest('.thumbnail-btn').classList.remove('border-transparent');
            event.target.closest('.thumbnail-btn').classList.add('border-green-500');
        }

        // Select option by clicking on thumbnail
        function selectOptionByImage(imageSrc, optionIndex) {
            // Update main image
            document.getElementById('main-image').src = imageSrc;
            
            // Update thumbnail borders
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-green-500');
                btn.classList.add('border-transparent');
            });
            
            // Add border to clicked thumbnail
            event.target.closest('.thumbnail-btn').classList.remove('border-transparent');
            event.target.closest('.thumbnail-btn').classList.add('border-green-500');
            
            // Update the option dropdown
            const optionSelector = document.getElementById('product-option');
            if (optionSelector) {
                optionSelector.value = optionIndex;
                
                // Get the selected option's price
                const selectedOption = optionSelector.options[optionSelector.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price);
                
                // Update price display
                const priceElement = document.querySelector('.text-3xl.font-bold.text-green-600');
                if (priceElement) {
                    priceElement.textContent = '₦' + price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            }
        }

        // Handle product option change from dropdown
        const optionSelector = document.getElementById('product-option');
        if (optionSelector) {
            optionSelector.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price);
                const optionIndex = this.value;
                
                // Update price display
                const priceElement = document.querySelector('.text-3xl.font-bold.text-green-600');
                if (priceElement) {
                    priceElement.textContent = '₦' + price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }

                // Update thumbnail borders and main image
                document.querySelectorAll('.thumbnail-btn').forEach((btn, index) => {
                    btn.classList.remove('border-green-500');
                    btn.classList.add('border-transparent');
                });

                // Update image if option has a specific image
                if (optionIndex !== '' && optionImages && optionImages[optionIndex]) {
                    const optionImage = optionImages[optionIndex];
                    document.getElementById('main-image').src = optionImage;
                    
                    // Highlight the corresponding thumbnail (index + 1 to account for base image)
                    const thumbnails = document.querySelectorAll('.thumbnail-btn');
                    const thumbnailIndex = parseInt(optionIndex) + 1;
                    if (thumbnails[thumbnailIndex]) {
                        thumbnails[thumbnailIndex].classList.remove('border-transparent');
                        thumbnails[thumbnailIndex].classList.add('border-green-500');
                    }
                } else {
                    // Reset to base image and highlight first thumbnail
                    document.getElementById('main-image').src = baseImage;
                    const firstThumbnail = document.querySelector('.thumbnail-btn');
                    if (firstThumbnail) {
                        firstThumbnail.classList.remove('border-transparent');
                        firstThumbnail.classList.add('border-green-500');
                    }
                }
            });
        }

        // Quantity controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max);
            
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const minValue = parseInt(quantityInput.min);
            
            if (currentValue > minValue) {
                quantityInput.value = currentValue - 1;
            }
        }

        // Add to Cart functionality
        async function addToCart() {
            const quantityInput = document.getElementById('quantity');
            const quantity = parseInt(quantityInput.value);
            const optionSelector = document.getElementById('product-option');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const btnText = document.getElementById('cart-btn-text');
            
            // Check if product has options and if one is selected
            if (optionSelector && optionSelector.value === '') {
                alert('Please select a product option before adding to cart.');
                return;
            }
            
            // Get selected option details
            let optionName = 'Default';
            let optionPrice = {{ $product->price }};
            
            if (optionSelector && optionSelector.value !== '') {
                const selectedOption = optionSelector.options[optionSelector.selectedIndex];
                optionName = selectedOption.dataset.title;
                optionPrice = parseFloat(selectedOption.dataset.price);
            }
            
            // Prepare cart data
            const cartData = {
                product_id: {{ $product->id }},
                product_name: '{{ $product->name }}',
                options: [{
                    name: optionName,
                    price: optionPrice,
                    quantity: quantity,
                    image: document.getElementById('main-image').src
                }]
            };
            
            // Disable button and show loading
            addToCartBtn.disabled = true;
            btnText.textContent = 'Adding...';
            
            try {
                const response = await fetch('/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(cartData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    btnText.textContent = 'Added to Cart!';
                    addToCartBtn.style.backgroundColor = '#22c55e';
                    
                    // Update cart count if cart icon exists
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                        cartCount.classList.remove('hidden');
                    }
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        btnText.textContent = 'Add to Cart';
                        addToCartBtn.style.backgroundColor = '#cc6a06';
                        addToCartBtn.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert('Failed to add item to cart. Please try again.');
                btnText.textContent = 'Add to Cart';
                addToCartBtn.disabled = false;
            }
        }

        // Copy product link function for Instagram sharing
        function copyProductLink() {
            const productUrl = window.location.href;
            
            // Try to use the modern clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(productUrl).then(() => {
                    showCopySuccess();
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                    fallbackCopyTextToClipboard(productUrl);
                });
            } else {
                // Fallback for older browsers or non-HTTPS
                fallbackCopyTextToClipboard(productUrl);
            }
        }

        // Fallback copy method for older browsers
        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";
            
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess();
                } else {
                    showCopyError();
                }
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
                showCopyError();
            }
            
            document.body.removeChild(textArea);
        }

        // Show success message when link is copied
        function showCopySuccess() {
            // Create or update notification
            let notification = document.getElementById('copy-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'copy-notification';
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                document.body.appendChild(notification);
            }
            
            notification.textContent = 'Product link copied to clipboard!';
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
            }, 3000);
        }

        // Show error message when copy fails
        function showCopyError() {
            // Create or update notification
            let notification = document.getElementById('copy-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'copy-notification';
                notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                document.body.appendChild(notification);
            }
            
            notification.textContent = 'Failed to copy link. Please copy manually.';
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
            }, 3000);
        }
    </script>
</x-layouts.app>
