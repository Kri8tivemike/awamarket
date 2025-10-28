<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin Dashboard</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-amber-200 transition-colors">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span class="font-semibold">Back to Dashboard</span>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
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

        <!-- Order Header -->
        <div class="bg-white rounded-xl shadow-lg border border-amber-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-amber-900">Order #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Created {{ $order->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge_class }}">
                            <i class="fas fa-circle mr-2 text-xs"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors shadow-md">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Order
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Customer Information
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <p class="text-gray-900 font-semibold">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900">{{ $order->customer_email }}</p>
                            </div>
                            @if($order->customer_phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <p class="text-gray-900">{{ $order->customer_phone }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Addresses
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($order->shipping_address)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $order->shipping_address }}</p>
                                </div>
                            </div>
                            @endif
                            @if($order->billing_address)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Billing Address</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $order->billing_address }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                @if($order->items->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Order Items ({{ $order->items->count() }})
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                @if($item->image)
                                <img src="{{ $item->image }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-16 h-16 object-cover rounded-md">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-xl"></i>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item->option_name }}</p>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-xs text-gray-500">Qty: {{ $item->quantity }}</span>
                                        <span class="text-xs text-gray-500">Price: ₦{{ number_format($item->price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">₦{{ number_format($item->subtotal, 2) }}</p>
                                    <p class="text-xs text-gray-500">Subtotal</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Order Notes -->
                @if($order->notes)
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-sticky-note mr-2"></i>
                            Order Notes
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                            <p class="text-gray-900 whitespace-pre-line">{{ $order->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-receipt mr-2"></i>
                            Order Summary
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Items Count:</span>
                            <span class="font-semibold text-gray-900">{{ $order->items_count }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-amber-600">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Order Timeline
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Order Created</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                            @if($order->updated_at != $order->created_at)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-amber-900 flex items-center">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Order
                        </a>
                        @if($order->status === 'pending')
                        <button onclick="confirmDelete({{ $order->id }})" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Order
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-600">Are you sure you want to delete this order? This action cannot be undone.</p>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete Order
                </button>
            </div>
        </div>
    </div>

    <script>
        let orderToDelete = null;

        function confirmDelete(orderId) {
            orderToDelete = orderId;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            orderToDelete = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (orderToDelete) {
                fetch(`/admin/orders/${orderToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("admin.orders") }}';
                    } else {
                        alert(data.message || 'An error occurred while deleting the order.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the order.');
                })
                .finally(() => {
                    closeDeleteModal();
                });
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>