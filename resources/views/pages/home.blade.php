<x-layouts.app>

    <!-- Hero Banner Section -->
    <section class="relative overflow-hidden w-full bg-gray-900 mt-0">
        @if($banner)
            <div class="banner-container">
                @if($banner->image)
                    @if(filter_var($banner->image, FILTER_VALIDATE_URL))
                        <img src="{{ $banner->image }}" alt="Banner" class="banner-image">
                    @else
                        <img src="{{ asset($banner->image) }}" alt="Banner" class="banner-image">
                    @endif
                @else
                    <div class="banner-fallback"></div>
                @endif
            </div>
        @else
            <!-- Default fallback when no banner exists -->
            <div class="banner-fallback">
                <div class="px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3">
                        Welcome to AwaMarket
                    </h1>
                    <p class="text-base sm:text-lg lg:text-xl mb-6">
                        Discover amazing products at unbeatable prices
                    </p>
                    <a href="/shop-now" class="inline-block bg-white text-blue-600 px-6 py-2 rounded-full font-semibold text-base hover:bg-gray-100 transition-all duration-300">
                        Shop Now
                    </a>
                </div>
            </div>
        @endif
    </section>

    <!-- Shop by Category Section -->
    <section class="py-8 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="h4-desktop-extra">
                    Shop by Category
                </h2>
                <a href="/shop-now" class="text-orange-600 hover:text-orange-700 font-medium flex items-center">
                    See all
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Categories Horizontal Scroll -->
            <div class="relative overflow-hidden">
                <div id="category-slider" class="flex gap-6 pb-4 scrollbar-hide transition-transform duration-500 ease-in-out"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .scrollbar-hide::-webkit-scrollbar {
                            display: none;
                        }
                        
                        /* Auto-slide animation */
                        @keyframes slide {
                            0% { transform: translateX(0); }
                            100% { transform: translateX(-100%); }
                        }
                        
                        .auto-slide {
                            animation: slide 20s linear infinite;
                        }
                        
                        .auto-slide:hover {
                            animation-play-state: paused;
                        }
                    </style>
                    
                    @php
                        $bgColors = [
                            'from-rose-50 to-rose-100',
                            'from-amber-50 to-amber-100',
                            'from-emerald-50 to-emerald-100',
                            'from-sky-50 to-sky-100',
                            'from-violet-50 to-violet-100',
                            'from-teal-50 to-teal-100',
                            'from-indigo-50 to-indigo-100',
                            'from-pink-50 to-pink-100',
                            'from-cyan-50 to-cyan-100',
                            'from-lime-50 to-lime-100',
                            'from-orange-50 to-orange-100',
                            'from-purple-50 to-purple-100',
                            'from-slate-50 to-slate-100',
                            'from-stone-50 to-stone-100',
                            'from-neutral-50 to-neutral-100',
                        ];
                    @endphp
                    
                    @forelse($categories as $index => $category)
                        <x-category-card 
                            :category="$category->name" 
                            :description="$category->description"
                            :image="$category->image"
                            :bgColor="$bgColors[$index % count($bgColors)]" />
                    @empty
                        <!-- Fallback message if no categories exist -->
                        <div class="flex items-center justify-center w-full h-40 text-gray-500">
                            <p>No categories available at the moment.</p>
                        </div>
                    @endforelse
                    
                    <!-- Duplicate categories for seamless loop -->
                    @if($categories->count() > 0)
                        @foreach($categories as $index => $category)
                            <x-category-card 
                                :category="$category->name" 
                                :description="$category->description"
                                :image="$category->image"
                                :bgColor="$bgColors[$index % count($bgColors)]" />
                        @endforeach
                    @endif
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const slider = document.getElementById('category-slider');
                    const categories = @json($categories);
                    
                    if (categories && categories.length > 0) {
                        let scrollAmount = 0;
                        const cardWidth = 320; // Approximate width of each card including gap
                        const totalWidth = cardWidth * categories.length;
                        let isScrolling = true;
                        
                        function autoSlide() {
                            if (!isScrolling) return;
                            
                            scrollAmount += 1;
                            
                            // Reset when we've scrolled through all original cards
                            if (scrollAmount >= totalWidth) {
                                scrollAmount = 0;
                            }
                            
                            slider.style.transform = `translateX(-${scrollAmount}px)`;
                            
                            requestAnimationFrame(autoSlide);
                        }
                        
                        // Start auto-sliding
                        autoSlide();
                        
                        // Pause on hover
                        slider.addEventListener('mouseenter', function() {
                            isScrolling = false;
                        });
                        
                        // Resume on mouse leave
                        slider.addEventListener('mouseleave', function() {
                            isScrolling = true;
                            autoSlide();
                        });
                    }
                });
            </script>
        </div>
    </section>

    <!-- New Stock Section -->
    <section class="py-8 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="h4-desktop-extra">
                    New Stock
                </h2>
                <a href="/shop-now" class="text-orange-600 hover:text-orange-700 font-medium flex items-center">
                    See all
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-6 overflow-visible">
                    @foreach($products as $product)
                        <x-product-card 
                            :product="$product"
                            name="{{ $product->name }}"
                            image="{{ $product->featured_image ?? ($product->images ? (is_array($product->images) ? ($product->images[0] ?? '') : (json_decode($product->images)[0] ?? '')) : '') }}"
                            :priceMin="$product->price"
                            :priceMax="$product->price"
                            :optionsCount="$product->options ? (is_array($product->options) ? count($product->options) : count(json_decode($product->options, true))) : 0" />
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-12 px-4">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 text-center">No featured products available at the moment.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Promotional Banners Section -->
    @if($promotionBanners && $promotionBanners->count() > 0)
    <section class="py-6 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Desktop: Side by side banners -->
            <div class="hidden md:flex flex-row gap-6">
                @foreach($promotionBanners as $index => $promotionBanner)
                    @if($index < 2) {{-- Limit to 2 banners for desktop side-by-side layout --}}
                    <div class="flex-1">
                        @if($promotionBanner->link)
                            <a href="{{ $promotionBanner->link }}" target="_blank" class="block">
                                <img src="{{ asset($promotionBanner->image) }}" 
                                     alt="{{ $promotionBanner->alt_text ?: $promotionBanner->title }}" 
                                     class="w-full h-64 object-cover rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                            </a>
                        @else
                            <img src="{{ asset($promotionBanner->image) }}" 
                                 alt="{{ $promotionBanner->alt_text ?: $promotionBanner->title }}" 
                                 class="w-full h-64 object-cover rounded-2xl shadow-lg">
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Mobile: Carousel -->
            <div class="md:hidden relative overflow-hidden rounded-2xl shadow-lg" style="width: 370px; height: 155.06px; margin: 0 auto;">
                <div id="banner-carousel" class="flex transition-transform duration-500 ease-in-out h-full" style="transform: translateX(0%);">
                    @foreach($promotionBanners as $promotionBanner)
                    <div class="w-full flex-shrink-0">
                        @if($promotionBanner->link)
                            <a href="{{ $promotionBanner->link }}" target="_blank" class="block h-full">
                                <img src="{{ asset($promotionBanner->image) }}" 
                                     alt="{{ $promotionBanner->alt_text ?: $promotionBanner->title }}" 
                                     class="w-full h-full object-cover">
                            </a>
                        @else
                            <img src="{{ asset($promotionBanner->image) }}" 
                                 alt="{{ $promotionBanner->alt_text ?: $promotionBanner->title }}" 
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Slide Indicators -->
                @if($promotionBanners->count() > 1)
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    @foreach($promotionBanners as $index => $promotionBanner)
                    <button class="banner-indicator w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }}" data-slide="{{ $index }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <script>
        // Banner carousel functionality
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('banner-carousel');
            const indicators = document.querySelectorAll('.banner-indicator');
            
            // Only initialize carousel if there are banners
            if (!carousel || indicators.length === 0) {
                return;
            }
            
            let currentSlide = 0;
            const totalSlides = indicators.length; // Dynamic total slides based on database banners
            let autoSlideInterval;

            function updateCarousel() {
                const translateX = -currentSlide * 100;
                carousel.style.transform = `translateX(${translateX}%)`;
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('bg-white');
                        indicator.classList.remove('bg-opacity-50');
                    } else {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-opacity-50');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }

            function goToSlide(slideIndex) {
                currentSlide = slideIndex;
                updateCarousel();
            }

            function startAutoSlide() {
                // Only start auto-slide if there are multiple banners
                if (totalSlides > 1) {
                    autoSlideInterval = setInterval(nextSlide, 5000); // Change every 5 seconds
                }
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            // Initialize carousel
            updateCarousel();
            startAutoSlide();

            // Event listeners for indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                    stopAutoSlide();
                    startAutoSlide(); // Restart auto-slide after manual interaction
                });
            });

            // Pause auto-slide on hover (only if multiple banners)
            if (totalSlides > 1) {
                carousel.addEventListener('mouseenter', stopAutoSlide);
                carousel.addEventListener('mouseleave', startAutoSlide);
            }
        });
    </script>



    <!-- Call to Action Section -->
    <section class="py-8 bg-orange-50">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="h4-desktop-extra mb-4">
                Ready to Start Shopping?
            </h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Join thousands of satisfied customers who trust awamarket for their daily grocery needs
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/shop-now" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
                    Start Shopping
                </a>
                <a href="/about" class="border border-orange-600 text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 hover:text-white transition-colors">
                    Learn More
                </a>
            </div>
        </div>
    </section>


</x-layouts.app>