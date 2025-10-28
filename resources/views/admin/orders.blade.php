<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - AwaMarket Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Scrollable Content Styles */
        .scrollable-content {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f9fafb;
            max-height: calc(100vh - 120px);
            overflow-x: hidden;
            overflow-y: auto;
            padding-right: 4px;
        }

        .scrollable-content::-webkit-scrollbar {
            width: 8px;
        }

        .scrollable-content::-webkit-scrollbar-track {
            background: #f9fafb;
            border-radius: 4px;
        }

        .scrollable-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }

        .scrollable-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
        }

        .main-content-wrapper {
            height: calc(100vh - 0px);
            overflow: hidden;
            margin-left: 0;
        }

        @media (min-width: 1024px) {
            .main-content-wrapper {
                margin-left: 256px;
            }
        }

        .content-section {
            flex: 1;
            overflow-y: auto;
            height: 100%;
            box-sizing: border-box;
            min-height: fit-content;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .scrollable-content {
                max-height: calc(100vh - 100px);
            }
            
            .header {
                height: 100px;
                flex-shrink: 0;
            }
        }

        @media (max-width: 640px) {
            .scrollable-content {
                max-height: calc(100vh - 80px);
            }
            
            .header {
                height: 80px;
                flex-shrink: 0;
            }
        }

        /* Export dropdown styles */
        .export-dropdown {
            position: relative;
            display: inline-block;
        }

        .export-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 1000;
            margin-top: 8px;
            border: 1px solid #e5e7eb;
        }

        .export-dropdown:hover .export-dropdown-content {
            display: block;
        }

        .export-dropdown-content a {
            color: #374151;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
        }

        .export-dropdown-content a:first-child {
            border-radius: 8px 8px 0 0;
        }

        .export-dropdown-content a:last-child {
            border-radius: 0 0 8px 8px;
        }

        .export-dropdown-content a:hover {
            background-color: #f3f4f6;
        }

        .export-dropdown-content a i {
            margin-right: 8px;
            width: 16px;
        }
    </style>
</head>
<body class="admin-body flex h-screen">
    <!-- Unified Sidebar Component -->
    <x-admin-sidebar currentPage="orders" />
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto scrollable-content" style="height: calc(100vh - 120px); padding-bottom: 2rem;">
        <div class="content-section">
            <!-- Modern Header -->
            <header style="background-color: #fefdf8; height: 120px; flex-shrink: 0;" class="header border-b border-amber-200/30 backdrop-blur-sm">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">Orders</h2>
                            <p class="text-gray-600 flex items-center text-lg font-medium">
                                <i class="fas fa-shopping-cart mr-3 text-blue-500 text-xl"></i>
                                Manage customer orders and fulfillment
                            </p>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-full px-5 py-3 border border-green-200 shadow-sm">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg"></div>
                                <span class="text-sm font-bold text-green-700 tracking-wide">{{ $orders->count() }} orders</span>
                            </div>
                            <div class="export-dropdown">
                                <button type="button" style="background-color: #f8f6f0;" class="text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-gray-300 font-semibold text-sm border border-gray-200">
                                    <i class="fas fa-download mr-2 text-sm"></i>
                                    Export Orders
                                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                </button>
                                <div class="export-dropdown-content">
                                    <a href="{{ route('admin.orders.export', array_merge(request()->query(), ['format' => 'excel'])) }}">
                                        <i class="fas fa-file-excel text-green-600"></i>
                                        Export as Excel
                                    </a>
                                    <a href="{{ route('admin.orders.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                        Export as PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <div class="p-6">
                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-400 hover:text-green-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were some errors with your request:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Filters and Search -->
                <div class="mb-10 bg-gradient-to-r from-gray-50 to-white p-8 rounded-2xl border border-gray-200/60 shadow-sm">
                    <form method="GET" action="{{ route('admin.orders') }}" class="filter-form">
                        <div class="flex flex-row items-end justify-between gap-4">
                            <!-- Status Filter -->
                            <div class="flex-1 min-w-0 min-w-[180px]">
                                <label class="block text-sm font-bold text-gray-800 mb-3 tracking-wide uppercase">
                                    <i class="fas fa-filter mr-2 text-blue-600"></i>Status
                                </label>
                                <select name="status" class="w-full bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl px-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-3 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:border-blue-300 hover:bg-white cursor-pointer">
                                    <option value="" {{ request('status', '') == '' ? 'selected' : '' }}>All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>🔵 Processing</option>
                                    <option value="collected_by_dispatch" {{ request('status') == 'collected_by_dispatch' ? 'selected' : '' }}>🟣 Collected By Dispatch</option>
                                    <option value="delivered_successfully" {{ request('status') == 'delivered_successfully' ? 'selected' : '' }}>🟢 Delivered Successfully</option>
                                    <option value="failed_delivery" {{ request('status') == 'failed_delivery' ? 'selected' : '' }}>🟠 Failed Delivery</option>
                                    <option value="order_cancelled" {{ request('status') == 'order_cancelled' ? 'selected' : '' }}>🔴 Order Cancelled</option>
                                </select>
                            </div>
                            
                            <!-- Date From Filter -->
                            <div class="flex-1 min-w-0 min-w-[180px]">
                                <label class="block text-sm font-bold text-gray-800 mb-3 tracking-wide uppercase">
                                    <i class="fas fa-calendar-alt mr-2 text-green-600"></i>From Date
                                </label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl px-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-3 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:border-green-300 hover:bg-white cursor-pointer">
                            </div>
                            
                            <!-- Date To Filter -->
                            <div class="flex-1 min-w-0 min-w-[180px]">
                                <label class="block text-sm font-bold text-gray-800 mb-3 tracking-wide uppercase">
                                    <i class="fas fa-calendar-alt mr-2 text-green-600"></i>To Date
                                </label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl px-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-3 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:border-green-300 hover:bg-white cursor-pointer">
                            </div>
                            
                            <!-- Search Input -->
                            <div class="relative flex-1 min-w-0 min-w-[280px]">
                                <label class="block text-sm font-bold text-gray-800 mb-3 tracking-wide uppercase">
                                    <i class="fas fa-search mr-2 text-purple-600"></i>Search Orders
                                </label>
                                <div class="relative group">
                                    <input 
                                        type="text" 
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search by order ID, customer name, email..." 
                                        class="w-full bg-white/90 backdrop-blur-sm border-2 border-gray-200 rounded-xl pl-12 pr-5 py-3.5 text-sm font-medium text-gray-700 placeholder-gray-400 focus:ring-3 focus:ring-purple-500/30 focus:border-purple-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:border-purple-300 hover:bg-white"
                                    >
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-hover:text-purple-500 transition-colors duration-200">
                                        <i class="fas fa-search text-base"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Filter Actions -->
                            <div class="flex items-center justify-center gap-2">
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-filter text-sm"></i>
                                        <span class="text-sm font-bold">Filter</span>
                                    </div>
                                </button>
                                <a href="{{ route('admin.orders') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-black px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-times text-sm"></i>
                                        <span class="text-sm font-bold">Clear</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Orders Table -->
                <div class="modern-table rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="w-1/6 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th class="w-1/4 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="w-1/8 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Items</th>
                                    <th class="w-1/8 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Total</th>
                                    <th class="w-1/8 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Date</th>
                                    <th class="w-1/8 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="w-1/12 px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/90 divide-y divide-gray-200/50">
                                @forelse($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-3">
                                        <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3">
                                        <div class="flex items-center min-w-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                <span class="text-white text-xs font-medium">{{ strtoupper(substr($order->customer_name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $order->customer_name)[1] ?? '', 0, 1)) }}</span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $order->customer_name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $order->customer_email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-900 hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $order->items_count }} {{ $order->items_count == 1 ? 'item' : 'items' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-sm font-medium text-gray-900 hidden md:table-cell">${{ number_format($order->total, 2) }}</td>
                                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-500 hidden lg:table-cell">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 sm:px-6 py-3">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'collected_by_dispatch' => 'bg-purple-100 text-purple-800',
                                                'delivered_successfully' => 'bg-green-100 text-green-800',
                                                'failed_delivery' => 'bg-orange-100 text-orange-800',
                                                'order_cancelled' => 'bg-red-100 text-red-800'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Pending',
                                                'processing' => 'Processing',
                                                'collected_by_dispatch' => 'Collected By Dispatch',
                                                'delivered_successfully' => 'Delivered Successfully',
                                                'failed_delivery' => 'Failed Delivery',
                                                'order_cancelled' => 'Order Cancelled'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-1">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200" title="View Order">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200" title="Edit Order">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            
                                            <!-- Delete Button (only for pending orders) -->
                                            @if($order->status === 'pending')
                                            <form method="POST" action="{{ route('admin.orders.delete', $order->id) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="Delete Order">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 sm:px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                                            <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $orders->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $orders->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $orders->total() }}</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($orders->onFirstPage())
                            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left text-xs mr-1"></i>
                                Previous
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white/90 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-chevron-left text-xs mr-1"></i>
                                Previous
                            </a>
                        @endif
                        
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="px-3 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white/90 border border-gray-300 rounded-lg hover:text-blue-600">{{ $page }}</a>
                            @endif
                        @endforeach
                        
                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white/90 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Next
                                <i class="fas fa-chevron-right text-xs ml-1"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                Next
                                <i class="fas fa-chevron-right text-xs ml-1"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>