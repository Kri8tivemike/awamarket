<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Admin Dashboard</title>
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
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="flex items-center space-x-3 text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span class="font-semibold">Back to Order</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.orders') }}" class="text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-list mr-2"></i>All Orders
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
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

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
                    <div>
                        <p class="font-semibold mb-2">Please correct the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-lg border border-amber-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-amber-900 flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Edit Order #{{ $order->id }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Created {{ $order->created_at->format('M d, Y \a\t g:i A') }}
                </p>
            </div>

            <form id="editOrderForm" method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="px-6 py-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Customer Information -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Customer Information
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Customer Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           value="{{ old('customer_name', $order->customer_name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('customer_name') border-red-500 @enderror"
                                           required>
                                    @error('customer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Customer Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="customer_email" 
                                           name="customer_email" 
                                           value="{{ old('customer_email', $order->customer_email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('customer_email') border-red-500 @enderror"
                                           required>
                                    @error('customer_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Customer Phone
                                    </label>
                                    <input type="text" 
                                           id="customer_phone" 
                                           name="customer_phone" 
                                           value="{{ old('customer_phone', $order->customer_phone) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('customer_phone') border-red-500 @enderror">
                                    @error('customer_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Order Details
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="items_count" class="block text-sm font-medium text-gray-700 mb-1">
                                        Items Count <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           id="items_count" 
                                           name="items_count" 
                                           value="{{ old('items_count', $order->items_count) }}"
                                           min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('items_count') border-red-500 @enderror"
                                           required>
                                    @error('items_count')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">
                                        Total Amount <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input type="number" 
                                               id="total" 
                                               name="total" 
                                               value="{{ old('total', $order->total) }}"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('total') border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('total')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Order Status -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-flag mr-2"></i>
                                Order Status
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" 
                                            name="status" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('status') border-red-500 @enderror"
                                            required
                                            onchange="handleStatusChange(this.value)">
                                        @php
                                            $currentStatus = old('status', $order->status);
                                        @endphp
                                        
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}" 
                                                    {{ $currentStatus == $key ? 'selected' : '' }}
                                                    data-current="{{ $currentStatus == $key ? 'true' : 'false' }}">
                                                {{ $label }}
                                                @if($currentStatus == $key)
                                                    (Current)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        Only valid status transitions are shown based on business rules.
                                    </p>
                                </div>

                                <!-- Status Change Warning -->
                                <div id="statusWarning" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i>
                                        <div class="text-sm text-yellow-800">
                                            <p class="font-semibold">Status Change Notice:</p>
                                            <p id="statusWarningText"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Information -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-blue-600 mr-2 mt-1"></i>
                                        <div class="text-sm text-blue-800">
                                            <p class="font-semibold">Status Rules:</p>
                                            <ul class="mt-1 text-xs space-y-1">
                                                <li>• Pending → Processing or Order Cancelled</li>
                                                <li>• Processing → Collected By Dispatch or Order Cancelled</li>
                                                <li>• Collected By Dispatch → Delivered Successfully or Failed Delivery</li>
                                                <li>• Failed Delivery → Collected By Dispatch (retry)</li>
                                                <li>• Delivered Successfully and Order Cancelled are final states</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Addresses -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Addresses
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">
                                        Shipping Address
                                    </label>
                                    <textarea id="shipping_address" 
                                              name="shipping_address" 
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('shipping_address') border-red-500 @enderror"
                                              placeholder="Enter shipping address...">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">
                                        Billing Address
                                    </label>
                                    <textarea id="billing_address" 
                                              name="billing_address" 
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('billing_address') border-red-500 @enderror"
                                              placeholder="Enter billing address...">{{ old('billing_address', $order->billing_address) }}</textarea>
                                    @error('billing_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-sticky-note mr-2"></i>
                                Order Notes
                            </h3>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                    Additional Notes
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('notes') border-red-500 @enderror"
                                          placeholder="Enter any additional notes about this order...">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" 
                                onclick="confirmSave()" 
                                class="inline-flex items-center px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors shadow-md">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Save Confirmation Modal -->
    <div id="saveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Changes</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-600">Are you sure you want to save these changes to the order?</p>
                <div id="statusChangeNotice" class="hidden mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <span class="font-semibold">Status will be changed:</span>
                        <span id="statusChangeText"></span>
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeSaveModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button onclick="submitForm()" 
                        class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <script>
        const originalStatus = '{{ $order->status }}';
        
        // Status change handling with business logic validation
        function handleStatusChange(newStatus) {
            const warningDiv = document.getElementById('statusWarning');
            const warningText = document.getElementById('statusWarningText');
            
            if (newStatus && newStatus !== originalStatus) {
                let message = '';
                
                // Define status transition rules and warnings
                switch (newStatus) {
                    case 'processing':
                        if (originalStatus === 'pending') {
                            message = 'Order will be marked as being processed. This indicates work has begun on the order.';
                        }
                        break;
                    case 'shipped':
                        if (originalStatus === 'processing') {
                            message = 'Order will be marked as shipped. Ensure tracking information is available.';
                        }
                        break;
                    case 'delivered':
                        if (originalStatus === 'shipped') {
                            message = 'Order will be marked as delivered. This is a final status and indicates successful completion.';
                        }
                        break;
                    case 'cancelled':
                        message = 'Order will be cancelled. This action should be taken carefully as it affects inventory and customer expectations.';
                        break;
                }
                
                if (message) {
                    warningText.textContent = message;
                    warningDiv.classList.remove('hidden');
                } else {
                    warningDiv.classList.add('hidden');
                }
            } else {
                warningDiv.classList.add('hidden');
            }
        }

        function confirmSave() {
            const newStatus = document.getElementById('status').value;
            const modal = document.getElementById('saveModal');
            const statusNotice = document.getElementById('statusChangeNotice');
            const statusChangeText = document.getElementById('statusChangeText');
            
            // Show status change notice if status is different
            if (newStatus && newStatus !== originalStatus) {
                const statusLabels = {
                    'pending': 'Pending',
                    'processing': 'Processing', 
                    'shipped': 'Shipped',
                    'delivered': 'Delivered',
                    'cancelled': 'Cancelled'
                };
                statusChangeText.textContent = `${statusLabels[originalStatus]} → ${statusLabels[newStatus]}`;
                statusNotice.classList.remove('hidden');
            } else {
                statusNotice.classList.add('hidden');
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeSaveModal() {
            const modal = document.getElementById('saveModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitForm() {
            document.getElementById('editOrderForm').submit();
        }

        // Close modal when clicking outside
        document.getElementById('saveModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSaveModal();
            }
        });

        // Enhanced form validation
        document.getElementById('editOrderForm').addEventListener('submit', function(e) {
            const requiredFields = ['customer_name', 'customer_email', 'items_count', 'total', 'status'];
            let isValid = true;
            let errorMessages = [];
            
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                    errorMessages.push(`${fieldName.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} is required`);
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            // Validate email format
            const emailField = document.getElementById('customer_email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailField.value && !emailRegex.test(emailField.value)) {
                emailField.classList.add('border-red-500');
                isValid = false;
                errorMessages.push('Please enter a valid email address');
            }
            
            // Validate numeric fields
            const itemsCount = document.getElementById('items_count');
            const total = document.getElementById('total');
            
            if (itemsCount.value && (isNaN(itemsCount.value) || parseInt(itemsCount.value) < 1)) {
                itemsCount.classList.add('border-red-500');
                isValid = false;
                errorMessages.push('Items count must be a positive number');
            }
            
            if (total.value && (isNaN(total.value) || parseFloat(total.value) < 0)) {
                total.classList.add('border-red-500');
                isValid = false;
                errorMessages.push('Total must be a valid positive amount');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fix the following errors:\n• ' + errorMessages.join('\n• '));
            }
        });

        // Real-time validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['customer_name', 'customer_email', 'items_count', 'total'];
            
            fields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    field.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            this.classList.remove('border-red-500');
                            this.classList.add('border-green-500');
                        } else {
                            this.classList.add('border-red-500');
                            this.classList.remove('border-green-500');
                        }
                    });
                    
                    field.addEventListener('input', function() {
                        if (this.classList.contains('border-red-500') && this.value.trim()) {
                            this.classList.remove('border-red-500');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>