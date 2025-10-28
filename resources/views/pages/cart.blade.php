<x-layouts.app>
    <!-- Shopping Cart Section -->
    <section class="py-8 md:py-16 bg-gray-50 min-h-screen">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Shopping Cart</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Shopping Cart</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Review your items and proceed to checkout</p>
            </div>

            <!-- Cart Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-content" style="{{ empty($cart) ? 'display: none;' : '' }}">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-6" id="cart-items-container">
                    @forelse($cart as $item)
                    <!-- Cart Item {{ $loop->index + 1 }} -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 cart-item" data-item-id="{{ $item['id'] }}">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" 
                                         alt="{{ $item['product_name'] }}" 
                                         class="w-24 h-24 object-cover rounded-lg">
                                @else
                                    <div class="w-24 h-24 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['product_name'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $item['option_name'] }}</p>
                                    </div>
                                    <button class="text-red-500 hover:text-red-700 transition-colors duration-200 ml-4" onclick="removeItem('{{ $item['id'] }}')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Quantity and Price -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-3">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-medium text-gray-700">Qty:</span>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200" 
                                                    onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] - 1 }})">-</button>
                                            <span class="px-4 py-1 text-center min-w-[3rem] quantity-display" id="qty-{{ $item['id'] }}">{{ $item['quantity'] }}</span>
                                            <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200" 
                                                    onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] + 1 }})">+</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-green-600" id="price-{{ $item['id'] }}">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        <p class="text-sm text-gray-500">₦{{ number_format($item['price'], 2) }} each</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse

                    <!-- Continue Shopping Button -->
                    <div class="text-center pt-6">
                        <a href="/shop-now" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                        
                        <!-- Summary Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-base">
                                <span class="text-gray-600">Subtotal (<span id="item-count">{{ $count }}</span> items)</span>
                                <span class="font-medium" id="subtotal">₦{{ $subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium" id="tax">₦{{ $tax }}</span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-lg font-semibold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900" id="total">₦{{ $total }}</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="block w-full text-white py-3 px-4 rounded-lg font-semibold focus:ring-4 transition-all duration-200 mb-4 text-center checkout-btn">
                            Proceed to Checkout
                        </a>

                        <!-- Payment Methods -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-3">We accept</p>
                            <div class="flex justify-center space-x-3">
                                <div class="w-10 h-6 bg-blue-600 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">VISA</span>
                                </div>
                                <div class="w-10 h-6 bg-red-600 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">MC</span>
                                </div>
                                <div class="w-10 h-6 bg-blue-500 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">PP</span>
                                </div>
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-6 text-center">
                            <div class="inline-flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Secure Checkout
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Cart State (Hidden by default) -->
            <div id="empty-cart" class="text-center py-16" style="{{ !empty($cart) ? 'display: none;' : '' }}">
                <div class="max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="/shop-now" class="inline-flex items-center px-6 py-3 text-white rounded-lg font-semibold transition-colors duration-200 shop-btn">
                        Start Shopping
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Cart Functionality -->
    <script>
        const baseUrl = '{{ url('') }}';

        // Update quantity function
        function updateQuantity(itemId, newQuantity) {
            if (newQuantity < 1) {
                removeItem(itemId);
                return;
            }

            fetch(`${baseUrl}/api/cart/update`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update display
                    document.getElementById(`qty-${itemId}`).textContent = newQuantity;
                    
                    // Update order summary
                    document.getElementById('item-count').textContent = data.cart_count;
                    document.getElementById('subtotal').textContent = `₦${data.subtotal}`;
                    document.getElementById('tax').textContent = `₦${data.tax}`;
                    document.getElementById('total').textContent = `₦${data.total}`;
                    
                    // Recalculate item price
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
                alert('Failed to update quantity');
            });
        }

        // Remove item function
        function removeItem(itemId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }

            fetch(`${baseUrl}/api/cart/remove`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    item_id: itemId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item from DOM
                    const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                    if (itemElement) {
                        itemElement.remove();
                    }
                    
                    // Update order summary
                    document.getElementById('item-count').textContent = data.cart_count;
                    document.getElementById('subtotal').textContent = `₦${data.subtotal}`;
                    document.getElementById('tax').textContent = `₦${data.tax}`;
                    document.getElementById('total').textContent = `₦${data.total}`;
                    
                    // Check if cart is empty
                    if (data.cart_count === 0) {
                        showEmptyCart();
                    }
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                alert('Failed to remove item');
            });
        }

        // Show empty cart state
        function showEmptyCart() {
            document.getElementById('cart-content').style.display = 'none';
            document.getElementById('empty-cart').style.display = 'block';
        }
    </script>

    <style>
        .checkout-btn {
            background-color: #f54a00;
        }
        .checkout-btn:hover {
            background-color: #d63e00;
        }
        .checkout-btn:focus {
            ring-color: #f54a0033;
        }
        
        .shop-btn {
            background-color: #f54a00;
        }
        .shop-btn:hover {
            background-color: #d63e00;
        }
    </style>
</x-layouts.app>