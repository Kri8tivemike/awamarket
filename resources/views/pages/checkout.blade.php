<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
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
                            <a href="{{ route('cart') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2 transition-colors duration-200">Cart</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-12">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 sm:mb-4">Checkout</h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-2">Complete your order securely</p>
            </div>

            <!-- Important Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg mb-8">
                <!-- Header (clickable on mobile) -->
                <button type="button" onclick="toggleNotice()" class="w-full p-4 sm:p-6 flex items-start md:pointer-events-none">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base sm:text-lg font-semibold text-blue-900">Important Notice</h3>
                            <!-- Toggle arrow (visible only on mobile) -->
                            <svg id="notice-arrow" class="w-5 h-5 text-blue-600 transition-transform duration-200 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </button>
                
                <!-- Collapsible content -->
                <div id="notice-content" class="px-4 sm:px-6 pb-4 sm:pb-6 md:block">
                    <div class="ml-9 text-blue-800 space-y-2 text-sm sm:text-base">
                        <p class="flex items-start">
                            <span class="font-semibold mr-2">1.</span>
                            <span>Please be informed that after goods purchase, shipping to your location are handled by third party logistic company e.g Bolt dispatch riders.</span>
                        </p>
                        <p class="flex items-start">
                            <span class="font-semibold mr-2">2.</span>
                            <span>Payment are made via whatsapp after product prices are reviewed.</span>
                        </p>
                        <p class="flex items-start">
                            <span class="font-semibold mr-2">3.</span>
                            <span>Please use your current address to aviod shipping your goods to wrong address.</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <script>
            function toggleNotice() {
                // Only toggle on mobile
                if (window.innerWidth >= 768) return;
                
                const content = document.getElementById('notice-content');
                const arrow = document.getElementById('notice-arrow');
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    content.classList.add('hidden');
                    arrow.style.transform = 'rotate(-90deg)';
                }
            }
            
            // Initialize - collapsed on mobile by default
            document.addEventListener('DOMContentLoaded', function() {
                if (window.innerWidth < 768) {
                    const content = document.getElementById('notice-content');
                    const arrow = document.getElementById('notice-arrow');
                    content.classList.add('hidden');
                    arrow.style.transform = 'rotate(-90deg)';
                }
            });
            </script>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                <!-- Left Column - Checkout Form -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                    <form id="checkout-form" class="space-y-4 sm:space-y-6">
                        @csrf
                        
                        <!-- Billing Information -->
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Billing Information</h2>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="first_name" name="first_name" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="mt-3 sm:mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div class="mt-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <select id="country_code" name="country_code" 
                                            class="w-full sm:w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                                        <option value="+234" data-flag="🇳🇬">🇳🇬 +234</option>
                                        <option value="+1" data-flag="🇺🇸">🇺🇸 +1</option>
                                        <option value="+44" data-flag="🇬🇧">🇬🇧 +44</option>
                                        <option value="+91" data-flag="🇮🇳">🇮🇳 +91</option>
                                        <option value="+86" data-flag="🇨🇳">🇨🇳 +86</option>
                                        <option value="+81" data-flag="🇯🇵">🇯🇵 +81</option>
                                        <option value="+49" data-flag="🇩🇪">🇩🇪 +49</option>
                                        <option value="+33" data-flag="🇫🇷">🇫🇷 +33</option>
                                        <option value="+39" data-flag="🇮🇹">🇮🇹 +39</option>
                                        <option value="+34" data-flag="🇪🇸">🇪🇸 +34</option>
                                        <option value="+27" data-flag="🇿🇦">🇿🇦 +27</option>
                                        <option value="+254" data-flag="🇰🇪">🇰🇪 +254</option>
                                        <option value="+233" data-flag="🇬🇭">🇬🇭 +233</option>
                                        <option value="+256" data-flag="🇺🇬">🇺🇬 +256</option>
                                        <option value="+255" data-flag="🇹🇿">🇹🇿 +255</option>
                                        <option value="+971" data-flag="🇦🇪">🇦🇪 +971</option>
                                        <option value="+966" data-flag="🇸🇦">🇸🇦 +966</option>
                                        <option value="+61" data-flag="🇦🇺">🇦🇺 +61</option>
                                        <option value="+55" data-flag="🇧🇷">🇧🇷 +55</option>
                                        <option value="+52" data-flag="🇲🇽">🇲🇽 +52</option>
                                    </select>
                                    <input type="tel" id="phone" name="phone" required 
                                           placeholder="8012345678"
                                           pattern="[0-9]{7,15}" 
                                           title="Please enter a valid phone number (7-15 digits)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Enter your phone number without the country code</p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Shipping Address</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" id="address" name="address" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City/LGA</label>
                                        <input type="text" id="city" name="city" required
                                               placeholder="e.g., Ikeja, Enugu North"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                        <select id="state" name="state" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select State</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">FCT - Abuja</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Zamfara">Zamfara</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Postal Code (Optional)</label>
                                    <input type="text" id="zip" name="zip"
                                           placeholder="e.g., 100001"
                                           pattern="[0-9]{6}"
                                           title="Please enter a valid 6-digit postal code"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p class="mt-1 text-xs text-gray-500">Nigerian postal codes are 6 digits</p>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:sticky lg:top-20">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6 max-h-96 overflow-y-auto">
                        @forelse($cart as $item)
                        <div class="flex items-start sm:items-center space-x-3 sm:space-x-4 p-3 sm:p-4 border border-gray-200 rounded-lg">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" 
                                     alt="{{ $item['product_name'] }}" 
                                     class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-md flex-shrink-0">
                            @else
                                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-200 rounded-md flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm sm:text-base font-medium text-gray-900 truncate">{{ $item['product_name'] }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600">{{ $item['option_name'] }}</p>
                                <p class="text-xs sm:text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm sm:text-base font-medium text-gray-900">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                <p class="text-xs text-gray-500">₦{{ number_format($item['price'], 2) }} ea</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No items in cart</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Order Totals -->
                    <div class="border-t border-gray-200 pt-3 sm:pt-4 space-y-2">
                        <div class="flex justify-between text-base sm:text-lg font-semibold">
                            <span class="text-gray-900">Total ({{ $count }} items)</span>
                            <span class="text-gray-900">₦{{ $subtotal }}</span>
                        </div>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="button" id="place-order-btn"
                            class="w-full mt-4 sm:mt-6 text-white py-3 sm:py-4 px-4 rounded-lg text-sm sm:text-base font-semibold focus:ring-4 transition-all duration-200 place-order-btn shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            Place Order via WhatsApp
                        </span>
                    </button>
                    
                    <!-- Security Notice -->
                    <div class="mt-4 flex items-center justify-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V6a4 4 0 00-8 0v3h8z"></path>
                        </svg>
                        Secure SSL Encrypted Payment
                    </div>
                </div>
            </div>
            
            <!-- Back to Cart Link -->
            <div class="text-center mt-6 sm:mt-8 mb-4">
                <a href="{{ route('cart') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 rounded-lg text-sm sm:text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Cart
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const placeOrderBtn = document.getElementById('place-order-btn');
            const form = document.getElementById('checkout-form');
            
            placeOrderBtn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                // Validate form
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                // Disable button to prevent double submission
                placeOrderBtn.disabled = true;
                placeOrderBtn.textContent = 'Processing Order...';
                
                // Get form data
                const firstName = document.getElementById('first_name').value;
                const lastName = document.getElementById('last_name').value;
                const countryCode = document.getElementById('country_code').value;
                const phone = document.getElementById('phone').value;
                const fullPhone = countryCode + phone;
                const email = document.getElementById('email').value;
                const address = document.getElementById('address').value;
                const city = document.getElementById('city').value;
                const state = document.getElementById('state').value;
                const zip = document.getElementById('zip').value;
                
                try {
                    // Save order to database
                    const response = await fetch('{{ route('orders.create') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            first_name: firstName,
                            last_name: lastName,
                            email: email,
                            phone: fullPhone,
                            address: address,
                            city: city,
                            state: state,
                            zip: zip
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (!result.success) {
                        throw new Error(result.message || 'Failed to create order');
                    }
                    
                    // Build order summary from cart
                    const cartItems = @json($cart);
                    let orderSummary = '';
                    cartItems.forEach((item, index) => {
                        orderSummary += `\n${index + 1}. ${item.product_name} (${item.option_name}) - Qty: ${item.quantity} - ₦${(item.price * item.quantity).toLocaleString()}`;
                    });
                    
                    // Build address string
                    let fullAddress = `${address}, ${city}, ${state}`;
                    if (zip) {
                        fullAddress += `, ${zip}`;
                    }
                    
                    // Build WhatsApp message with order ID
                    const message = `Hello, I am ${firstName} ${lastName}, I would love to place an order for these items:

*Order #${result.order_id}*
${orderSummary}

*Order Total:* ₦{{ $total }}

*Delivery Information:*
Name: ${firstName} ${lastName}
Phone: ${fullPhone}
Email: ${email}
Address: ${fullAddress}

Thank you!`;
                    
                    // WhatsApp URL
                    const whatsappPhone = result.whatsapp_phone;
                    const whatsappUrl = `https://wa.me/${whatsappPhone.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(message)}`;
                    
                    // Open WhatsApp in new tab
                    window.open(whatsappUrl, '_blank');
                    
                    // Redirect to success page or home after a short delay
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                    
                } catch (error) {
                    console.error('Error creating order:', error);
                    alert('There was an error creating your order. Please try again.');
                    
                    // Re-enable button
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.textContent = 'Place Order via WhatsApp';
                }
            });
        });
    </script>

    <style>
        .place-order-btn {
            background-color: #f54a00;
        }
        .place-order-btn:hover {
            background-color: #d63e00;
        }
        .place-order-btn:focus {
            ring-color: #f54a0033;
        }
    </style>
</x-layouts.app>
