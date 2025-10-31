<x-layouts.app>
    <!-- Shopping Cart Section -->
    <section class="py-4 sm:py-8 bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-4 sm:mb-8 overflow-x-auto" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 whitespace-nowrap">
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
            <div class="text-center mb-6 sm:mb-12">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 sm:mb-4">Shopping Cart</h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-2">Review your items and proceed to checkout</p>
            </div>

            <!-- Cart Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-8" id="cart-content" style="{{ empty($cart) ? 'display: none;' : '' }}">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4 sm:space-y-6" id="cart-items-container">
                    @forelse($cart as $item)
                    <!-- Cart Item {{ $loop->index + 1 }} -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 cart-item" data-item-id="{{ $item['id'] }}">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" 
                                         alt="{{ $item['product_name'] }}" 
                                         class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-orange-100 rounded-lg flex items-center justify-center">
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
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $item['product_name'] }}</h3>
                                        <p class="text-xs sm:text-sm text-gray-600">{{ $item['option_name'] }}</p>
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
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <span class="text-sm font-medium text-gray-700">Qty:</span>
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                            <button class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200" 
                                                    onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] - 1 }})">-</button>
                                            <span class="px-3 py-2 text-center min-w-[2.5rem] quantity-display" id="qty-{{ $item['id'] }}">{{ $item['quantity'] }}</span>
                                            <button class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200" 
                                                    onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] + 1 }})">+</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-base sm:text-lg font-bold text-green-600" id="price-{{ $item['id'] }}">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        <p class="text-xs sm:text-sm text-gray-500">₦{{ number_format($item['price'], 2) }} each</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse

                    <!-- Continue Shopping Button -->
                    <div class="text-center pt-4 sm:pt-6">
                        <a href="/shop-now" class="inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-sm sm:text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 sticky top-20">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Order Summary</h2>
                        
                        <!-- Summary Items -->
                        <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Subtotal (<span id="item-count">{{ $count }}</span> items)</span>
                                <span class="font-medium" id="subtotal">₦{{ $subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium" id="tax">₦{{ $tax }}</span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-base sm:text-lg font-semibold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900" id="total">₦{{ $total }}</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="block w-full text-white py-3 sm:py-3.5 px-4 rounded-lg text-sm sm:text-base font-semibold focus:ring-4 transition-all duration-200 mb-4 text-center checkout-btn shadow-md">
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
            <div id="empty-cart" class="text-center py-12 sm:py-16" style="{{ !empty($cart) ? 'display: none;' : '' }}">
                <div class="max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-3 sm:mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6 sm:mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="/shop-now" class="inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 text-white rounded-lg text-sm sm:text-base font-semibold transition-colors duration-200 shop-btn">
                        Start Shopping
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-out" aria-hidden="true" onclick="closeDeleteModal()"></div>

        <!-- Modal panel -->
        <div class="relative bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out max-w-md w-full modal-content" style="transform: translateY(0px) scale(1); opacity: 1;">
            <!-- Close button -->
            <button type="button" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200" 
                    onclick="closeDeleteModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal content -->
            <div class="flex items-start space-x-4">
                <!-- Icon -->
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1 pt-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2" id="modal-title">
                        Remove Item from Cart
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Are you sure you want to remove this item from your cart? This action cannot be undone.
                    </p>
                </div>
            </div>
            
            <!-- Action buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <!-- Cancel button -->
                <button type="button" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300" 
                        onclick="closeDeleteModal()">
                    Cancel
                </button>
                
                <!-- Delete button -->
                <button type="button" 
                        id="confirmDeleteBtn"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Remove Item
                </button>
            </div>
        </div>
        </div>
    </div>

    <!-- JavaScript for Cart Functionality -->
    <script>
        const baseUrl = '{{ url('') }}';
        let itemToDelete = null;

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
                    
                    // Update mobile cart badge
                    if (window.updateCartBadges) {
                        window.updateCartBadges(data.cart_count);
                    }
                    
                    // Recalculate item price
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
                showErrorAlert('Failed to update quantity');
            });
        }

        // Remove item function - now shows modern modal
        function removeItem(itemId) {
            itemToDelete = itemId;
            showDeleteModal();
        }

        // Show delete confirmation modal
        function showDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('.modal-content');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Add entrance animation
            setTimeout(() => {
                modalContent.style.transform = 'translateY(0) scale(1)';
                modalContent.style.opacity = '1';
            }, 10);
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        // Close delete confirmation modal
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('.modal-content');
            
            // Add exit animation
            modalContent.style.transform = 'translateY(-10px) scale(0.95)';
            modalContent.style.opacity = '0';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                itemToDelete = null;
                
                // Restore body scroll
                document.body.style.overflow = '';
            }, 200);
        }

        // Confirm delete action
        function confirmDelete() {
            if (!itemToDelete) return;

            const deleteBtn = document.getElementById('confirmDeleteBtn');
            const originalText = deleteBtn.innerHTML;
            
            // Show loading state
            deleteBtn.innerHTML = `
                <span class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Removing...
                </span>
            `;
            deleteBtn.disabled = true;

            fetch(`${baseUrl}/api/cart/remove`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    item_id: itemToDelete
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal first
                    closeDeleteModal();
                    
                    // Remove item from DOM with animation
                    const itemElement = document.querySelector(`[data-item-id="${itemToDelete}"]`);
                    if (itemElement) {
                        itemElement.style.transform = 'translateX(-100%)';
                        itemElement.style.opacity = '0';
                        setTimeout(() => {
                            itemElement.remove();
                        }, 300);
                    }
                    
                    // Update order summary
                    document.getElementById('item-count').textContent = data.cart_count;
                    document.getElementById('subtotal').textContent = `₦${data.subtotal}`;
                    document.getElementById('tax').textContent = `₦${data.tax}`;
                    document.getElementById('total').textContent = `₦${data.total}`;
                    
                    // Update mobile cart badge
                    if (window.updateCartBadges) {
                        window.updateCartBadges(data.cart_count);
                    }
                    
                    // Check if cart is empty
                    if (data.cart_count === 0) {
                        setTimeout(() => {
                            showEmptyCart();
                        }, 300);
                    }
                    
                    // Show success message
                    showSuccessAlert('Item removed from cart successfully!');
                } else {
                    showErrorAlert('Failed to remove item from cart');
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                showErrorAlert('Failed to remove item from cart');
            })
            .finally(() => {
                // Restore button state
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            });
        }

        // Show empty cart state
        function showEmptyCart() {
            document.getElementById('cart-content').style.display = 'none';
            document.getElementById('empty-cart').style.display = 'block';
        }

        // Success alert function
        function showSuccessAlert(message) {
            const alert = document.createElement('div');
            alert.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ease-out';
            alert.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    ${message}
                </div>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(alert);
                }, 300);
            }, 3000);
        }

        // Error alert function
        function showErrorAlert(message) {
            const alert = document.createElement('div');
            alert.className = 'fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ease-out';
            alert.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    ${message}
                </div>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(alert);
                }, 300);
            }, 3000);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm delete button
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
            
            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                    closeDeleteModal();
                }
            });
        });

        // Initialize modal animations
        document.addEventListener('DOMContentLoaded', function() {
            const modalContent = document.querySelector('.modal-content');
            modalContent.style.transform = 'translateY(-10px) scale(0.95)';
            modalContent.style.opacity = '0';
            modalContent.style.transition = 'all 0.3s ease-out';
        });
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