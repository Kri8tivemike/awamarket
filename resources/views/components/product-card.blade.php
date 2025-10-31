@props(['product' => null, 'name' => '', 'image' => '', 'priceRange' => null, 'priceMin' => null, 'priceMax' => null, 'optionsCount' => 0])

@php
    $productOptions = [];
    $optionImages = [];
    if ($product && $product->options) {
        $productOptions = is_array($product->options) ? $product->options : (json_decode($product->options, true) ?? []);
    }
    if ($product && $product->option_images) {
        $optionImages = is_array($product->option_images) ? $product->option_images : (json_decode($product->option_images, true) ?? []);
    }
@endphp

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 group h-full flex flex-col">
    <a href="{{ $product ? route('product.show', $product->id) : '#' }}" class="block aspect-square bg-gray-50 overflow-hidden relative">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-5 transition-all duration-300"></div>
    </a>
    <div class="p-4 sm:p-5 lg:p-6 flex-1 flex flex-col">
        <a href="{{ $product ? route('product.show', $product->id) : '#' }}" class="block hover:text-orange-600 transition-colors duration-150 flex-1">
            <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 leading-tight line-clamp-2 min-h-[2.5rem] sm:min-h-[3rem] lg:min-h-[3.5rem]">{{ $name }}</h3>
        </a>
        
        <div class="mt-3 sm:mt-4">
            @if($priceRange)
                <p class="text-base sm:text-lg lg:text-xl font-bold text-gray-900">{{ $priceRange }}</p>
            @elseif($priceMin > 0 && $priceMax > 0)
                <p class="text-base sm:text-lg lg:text-xl font-bold text-gray-900">₦{{ number_format($priceMin, 0) }} - ₦{{ number_format($priceMax, 0) }}</p>
            @else
                <p class="text-sm text-gray-500">See options</p>
            @endif
        </div>
        
        @if($optionsCount > 0)
        <div class="mt-3 sm:mt-4">
            <button type="button" onclick="showProductModal({{ $product ? $product->id : 'null' }}, '{{ $name }}')" class="text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2 w-full bg-white hover:bg-gray-50 active:bg-gray-100 transition-colors duration-150 flex items-center justify-between">
                <span>Options: {{ $optionsCount }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
        @endif
        
        <div class="mt-4 sm:mt-5">
            <button onclick="showProductModal({{ $product ? $product->id : 'null' }}, '{{ $name }}')" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white text-sm sm:text-base font-medium rounded-lg w-full transition-colors duration-150 shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4 sm:w-5 sm:h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25h9.75m-12-9h12.622a.75.75 0 01.737.91l-1.5 7.5a.75.75 0 01-.737.59H7.5m0 0L6 6.75m1.5 7.5L5.25 18.75a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5L18 15.75"></path>
                </svg>
                Add to cart
            </button>
        </div>
    </div>
</div>

<script>
// Show product options modal
function showProductModal(productId, productName) {
    const modal = document.getElementById('product-options-modal');
    if (!modal) return;
    
    if (!productId) {
        alert('Product ID is required');
        return;
    }
    
    // Show loading state
    const modalTitle = modal.querySelector('h3');
    const originalTitle = modalTitle.textContent;
    modalTitle.textContent = 'Loading...';
    
    // Show modal
    modal.classList.remove('modal-hidden');
    modal.classList.add('modal-visible');
    
    // Store current product info
    currentProductId = productId;
    currentProductName = productName;
    
    // Clear selected options when opening modal
    selectedOptions.clear();
    
    // Fetch product options from API
    const baseUrl = '{{ url('') }}';
    fetch(`${baseUrl}/api/products/${productId}/options`)
        .then(response => response.json())
        .then(data => {
            // Update modal title
            modalTitle.textContent = data.name;
            currentProductName = data.name;
            
            // Update modal options
            updateModalOptions(data.options);
        })
        .catch(error => {
            console.error('Error loading product options:', error);
            modalTitle.textContent = productName || 'Product Options';
            alert('Failed to load product options. Please try again.');
        });
}

// Update modal options dynamically
function updateModalOptions(options) {
    const modal = document.getElementById('product-options-modal');
    const optionsContainer = modal.querySelector('.space-y-2');
    
    if (!optionsContainer) return;
    
    // Clear existing options
    optionsContainer.innerHTML = '';
    
    if (!options || options.length === 0) {
        optionsContainer.innerHTML = '<p class="text-sm text-gray-500 p-4">No options available for this product.</p>';
        return;
    }
    
    // Create option elements with quantity controls
    options.forEach((option, index) => {
        const optionEl = document.createElement('div');
        optionEl.className = 'product-option-wrapper mb-3';
        optionEl.setAttribute('data-option-index', index);
        
        // Use inline SVG placeholder if no image
        const placeholderSVG = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="56" height="56"%3E%3Crect width="56" height="56" fill="%23ff6b35"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="24" fill="white"%3EP%3C/text%3E%3C/svg%3E';
        const imageUrl = option.image || placeholderSVG;
        
        optionEl.innerHTML = `
            <div class="product-option p-2 sm:p-3 bg-white border border-gray-200 rounded-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 sm:space-x-3 flex-1">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-orange-50 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img src="${imageUrl}" alt="${option.name}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='${placeholderSVG}';">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="product-name text-sm font-semibold text-gray-900 truncate">${option.name}</p>
                            <p class="product-price text-sm sm:text-base font-bold text-gray-900" data-price="${option.raw_price}">${option.price}</p>
                        </div>
                    </div>
                    <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-3 sm:px-5 py-1 sm:py-1.5 rounded-md text-xs sm:text-sm font-medium transition-all duration-200" data-index="${index}">
                        Pick
                    </button>
                </div>
                <div class="quantity-controls hidden mt-2 sm:mt-3 flex items-center justify-center space-x-4 py-2 bg-gray-50 rounded-lg">
                    <button class="quantity-minus w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-full hover:border-orange-500 transition-colors duration-200" data-index="${index}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <span class="quantity-display text-2xl font-semibold text-gray-900 min-w-[3rem] text-center">1</span>
                    <button class="quantity-plus w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-full hover:border-orange-500 transition-colors duration-200" data-index="${index}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        optionsContainer.appendChild(optionEl);
    });
    
    // Initialize pick button and quantity control handlers
    initializePickButtons();
}

// Store selected options with quantities
const selectedOptions = new Map();
// Store current product info
let currentProductId = null;
let currentProductName = null;

// Initialize pick button handlers
function initializePickButtons() {
    const modal = document.getElementById('product-options-modal');
    const addToCartBtn = modal.querySelector('#add-to-cart-btn');
    const pickButtons = modal.querySelectorAll('.pick-btn');
    const quantityMinusButtons = modal.querySelectorAll('.quantity-minus');
    const quantityPlusButtons = modal.querySelectorAll('.quantity-plus');
    
    // Pick button handlers
    pickButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const index = this.getAttribute('data-index');
            const optionWrapper = this.closest('.product-option-wrapper');
            const quantityControls = optionWrapper.querySelector('.quantity-controls');
            const isPicked = this.classList.contains('bg-orange-500');
            
            if (isPicked) {
                // Unpick - remove selection
                this.classList.remove('bg-orange-500', 'text-white');
                this.classList.add('bg-white', 'text-gray-700');
                this.textContent = 'Pick';
                quantityControls.classList.add('hidden');
                selectedOptions.delete(index);
            } else {
                // Pick - add selection
                this.classList.remove('bg-white', 'text-gray-700');
                this.classList.add('bg-orange-500', 'text-white');
                this.textContent = 'Picked';
                quantityControls.classList.remove('hidden');
                
                // Store option with quantity 1
                const productName = optionWrapper.querySelector('.product-name').textContent;
                const priceEl = optionWrapper.querySelector('.product-price');
                const price = parseFloat(priceEl.getAttribute('data-price'));
                const priceFormatted = priceEl.textContent;
                const imageEl = optionWrapper.querySelector('img');
                const imageSrc = imageEl ? imageEl.src : null;
                
                selectedOptions.set(index, {
                    name: productName,
                    price: price,
                    priceFormatted: priceFormatted,
                    quantity: 1,
                    image: imageSrc
                });
            }
            
            updateAddToCartButton();
        });
    });
    
    // Quantity minus button handlers
    quantityMinusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const index = this.getAttribute('data-index');
            const optionWrapper = this.closest('.product-option-wrapper');
            const quantityDisplay = optionWrapper.querySelector('.quantity-display');
            const option = selectedOptions.get(index);
            
            if (option && option.quantity > 1) {
                option.quantity--;
                quantityDisplay.textContent = option.quantity;
                updateAddToCartButton();
            }
        });
    });
    
    // Quantity plus button handlers
    quantityPlusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const index = this.getAttribute('data-index');
            const optionWrapper = this.closest('.product-option-wrapper');
            const quantityDisplay = optionWrapper.querySelector('.quantity-display');
            const option = selectedOptions.get(index);
            
            if (option) {
                option.quantity++;
                quantityDisplay.textContent = option.quantity;
                updateAddToCartButton();
            }
        });
    });
}

// Update Add to Cart button state
function updateAddToCartButton() {
    const modal = document.getElementById('product-options-modal');
    const addToCartBtn = modal.querySelector('#add-to-cart-btn');
    
    if (selectedOptions.size > 0) {
        addToCartBtn.disabled = false;
        addToCartBtn.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
        addToCartBtn.classList.add('bg-orange-500', 'text-white', 'hover:bg-orange-600', 'cursor-pointer');
        
        // Remove old click listener and add new one
        const newBtn = addToCartBtn.cloneNode(true);
        addToCartBtn.parentNode.replaceChild(newBtn, addToCartBtn);
        newBtn.addEventListener('click', handleAddToCart);
    } else {
        addToCartBtn.disabled = true;
        addToCartBtn.classList.remove('bg-orange-500', 'text-white', 'hover:bg-orange-600', 'cursor-pointer');
        addToCartBtn.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
    }
}

// Handle add to cart
function handleAddToCart() {
    if (!currentProductId || selectedOptions.size === 0) {
        return;
    }
    
    // Prepare cart data
    const options = [];
    selectedOptions.forEach((option) => {
        options.push({
            name: option.name,
            price: option.price,
            quantity: option.quantity,
            image: option.image || null
        });
    });
    
    const cartData = {
        product_id: currentProductId,
        product_name: currentProductName,
        options: options
    };
    
    // Show loading state
    const modal = document.getElementById('product-options-modal');
    const addToCartBtn = modal.querySelector('#add-to-cart-btn');
    const originalText = addToCartBtn.innerHTML;
    addToCartBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Adding...</span>';
    addToCartBtn.disabled = true;
    
    // Send to cart API
    const baseUrl = '{{ url('') }}';
    fetch(`${baseUrl}/api/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(cartData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            updateCartCount(data.cart_count);
            
            // Show success message
            showToast('Items added to cart successfully!', 'success');
            
            // Reset modal
            selectedOptions.clear();
            modal.classList.remove('modal-visible');
            modal.classList.add('modal-hidden');
            
            // Reset all pick buttons
            modal.querySelectorAll('.pick-btn').forEach(btn => {
                btn.classList.remove('bg-orange-500', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
                btn.textContent = 'Pick';
            });
            
            // Hide all quantity controls
            modal.querySelectorAll('.quantity-controls').forEach(ctrl => {
                ctrl.classList.add('hidden');
                ctrl.querySelector('.quantity-display').textContent = '1';
            });
        } else {
            showToast(data.message || 'Failed to add items to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showToast('Failed to add items to cart', 'error');
    })
    .finally(() => {
        addToCartBtn.innerHTML = originalText;
        addToCartBtn.disabled = false;
    });
}

// Update cart count badge
function updateCartCount(count) {
    // Use global updateCartBadges if available (updates both desktop and mobile)
    if (window.updateCartBadges) {
        window.updateCartBadges(count);
    }
    
    // Legacy support - update any .cart-count elements
    const cartBadges = document.querySelectorAll('.cart-count');
    cartBadges.forEach(badge => {
        badge.textContent = count;
        badge.classList.remove('hidden');
    });
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white font-medium transition-all duration-300 transform translate-x-0`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

</script>
