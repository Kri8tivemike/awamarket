@props([
    'show' => true,
    'title' => 'Product Options',
    'subtitle' => 'Pick an option',
    'description' => 'Please choose your preferred quantity from the option provided',
    'options' => [],
    'modalId' => 'product-options'
])

<!-- Product Options Modal -->
<div id="{{ $modalId }}" class="modal-backdrop {{ $show ? 'modal-visible' : 'modal-hidden' }}" onclick="closeModal(event)">
    <div class="modal-content bg-white shadow-2xl transform transition-all duration-300 flex flex-col" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
            <button class="close-modal-btn p-1.5 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="flex-1 overflow-y-auto px-6 py-5">
            <div class="mb-5">
                <h4 class="text-base font-semibold text-gray-900 mb-1">{{ $subtitle }}</h4>
                <p class="text-sm text-gray-500">{{ $description }}</p>
            </div>

            <!-- Product Options -->
            <div class="space-y-3">
                @if(empty($options))
                    <!-- Default options if none provided -->
                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">1kg Combo</p>
                                <p class="product-price text-base font-bold text-gray-900">₦4,159.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>

                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">2kg Combo</p>
                                <p class="product-price text-base font-bold text-gray-900">₦6,309.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>

                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">Small Bundle</p>
                                <p class="product-price text-base font-bold text-gray-900">₦7,579.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>

                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">3kg Combo</p>
                                <p class="product-price text-base font-bold text-gray-900">₦8,549.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>

                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">6kg Combo</p>
                                <p class="product-price text-base font-bold text-gray-900">₦12,489.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>

                    <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 bg-amber-100 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="product-name text-sm font-semibold text-gray-900">Big Bundle</p>
                                <p class="product-price text-base font-bold text-gray-900">₦35,339.00</p>
                            </div>
                        </div>
                        <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                            Pick
                        </button>
                    </div>
                @else
                    <!-- Dynamic options from props -->
                    @foreach($options as $option)
                        <div class="product-option flex items-center justify-between p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-all duration-200 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 bg-orange-50 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if(!empty($option['image']))
                                        <img src="{{ $option['image'] }}" alt="{{ $option['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="product-name text-sm font-semibold text-gray-900">{{ $option['name'] }}</p>
                                    <p class="product-price text-base font-bold text-gray-900">{{ $option['price'] }}</p>
                                </div>
                            </div>
                            <button class="pick-btn bg-white hover:bg-orange-500 hover:text-white text-gray-700 border border-gray-300 px-5 py-1.5 rounded-md text-sm font-medium transition-all duration-200">
                                Pick
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- Add to Cart Button - Fixed at bottom -->
        <div class="bg-white border-t border-gray-200 px-6 py-4">
            <button id="add-to-cart-btn" class="w-full py-3 px-6 bg-gray-200 text-gray-500 rounded-lg font-semibold text-base transition-all duration-200 cursor-not-allowed disabled:opacity-60" disabled>
                <span class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <span>Add to cart</span>
                </span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('{{ $modalId }}');
    if (!modal) return;
    
    const closeBtn = modal.querySelector('.close-modal-btn');
    const addToCartBtn = modal.querySelector('#add-to-cart-btn');
    const pickButtons = modal.querySelectorAll('.pick-btn');
    let selectedOption = null;

    // Close modal functionality
    closeBtn.addEventListener('click', function() {
        modal.classList.remove('modal-visible');
        modal.classList.add('modal-hidden');
    });

    // Pick button functionality
    pickButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove previous selection
            pickButtons.forEach(btn => {
                btn.classList.remove('bg-orange-500', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
                btn.textContent = 'Pick';
            });

            // Mark current selection
            this.classList.remove('bg-white', 'text-gray-700');
            this.classList.add('bg-orange-500', 'text-white');
            this.textContent = 'Pick';

            // Store selected option
            selectedOption = this.closest('.product-option');

            // Enable add to cart button
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            addToCartBtn.classList.add('bg-orange-500', 'text-white', 'hover:bg-orange-600', 'cursor-pointer');
        });
    });

    // Add to cart functionality
    addToCartBtn.addEventListener('click', function() {
        if (selectedOption) {
            const productName = selectedOption.querySelector('.product-name').textContent;
            const productPrice = selectedOption.querySelector('.product-price').textContent;
            
            // Show success message
            alert(`${productName} (${productPrice}) has been added to your cart!`);
            
            // Reset modal state
            pickButtons.forEach(btn => {
                btn.classList.remove('bg-orange-500', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
                btn.textContent = 'Pick';
            });
            selectedOption = null;
            addToCartBtn.disabled = true;
            addToCartBtn.classList.remove('bg-orange-500', 'text-white', 'hover:bg-orange-600', 'cursor-pointer');
            addToCartBtn.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            
            // Close modal
            modal.classList.remove('modal-visible');
            modal.classList.add('modal-hidden');
        }
    });
});

// Global function to handle backdrop clicks
function closeModal(event) {
    // Only close if clicking on the backdrop (not the modal content)
    if (event.target === event.currentTarget) {
        const modal = event.currentTarget;
        modal.style.display = 'none';
        
        // Reset modal state
        const pickButtons = modal.querySelectorAll('.pick-btn');
        const addToCartBtn = modal.querySelector('.add-to-cart-btn');
        
        pickButtons.forEach(btn => {
            btn.classList.remove('bg-orange-500', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700');
            btn.textContent = 'Pick';
        });
        
        if (addToCartBtn) {
            addToCartBtn.disabled = true;
            addToCartBtn.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            addToCartBtn.classList.remove('bg-orange-500', 'text-white', 'hover:bg-orange-600');
        }
    }
}
</script>