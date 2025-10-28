<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AwaMarket</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    
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
    </style>
</head>
<body class="admin-body flex h-screen">
    <!-- Unified Sidebar Component -->
    <x-admin-sidebar currentPage="dashboard" />
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto scrollable-content" style="height: calc(100vh - 120px); padding-bottom: 2rem;">
        <div class="content-section">
            <!-- Modern Header -->
            <header style="background-color: #fefdf8;" class="border-b border-amber-200/30 backdrop-blur-sm">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">Dashboard</h2>
                            <p class="text-gray-600 flex items-center text-lg font-medium">
                                <i class="fas fa-chart-line mr-3 text-blue-500 text-xl"></i>
                                Welcome back! Here's what's happening with your store.
                            </p>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-full px-5 py-3 border border-green-200 shadow-sm">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg"></div>
                                <span class="text-sm font-bold text-green-700 tracking-wide">LIVE</span>
                            </div>
                            <button style="background-color: #f8f6f0;" class="text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-gray-300 font-semibold text-sm border border-gray-200">
                                <i class="fas fa-plus mr-2 text-sm"></i>
                                Add Product
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-8 h-screen scrollable-content">
                <!-- Modern Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stats-card rounded-2xl shadow-xl p-6 text-white card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-card-light text-sm font-medium mb-1">Total Products</p>
                                <p class="text-4xl font-bold text-card-white">{{ $totalProducts }}</p>
                                <p class="text-card-muted text-xs mt-2">
                                    @if($productChange >= 0)
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        +{{ $productChange }}% from last month
                                    @else
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        {{ $productChange }}% from last month
                                    @endif
                                </p>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-box text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card-2 rounded-2xl shadow-xl p-6 text-white card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-card-light text-sm font-medium mb-1">Total Orders</p>
                                <p class="text-4xl font-bold text-card-white">{{ $totalOrders }}</p>
                                <p class="text-card-muted text-xs mt-2">
                                    @if($orderChange >= 0)
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        +{{ $orderChange }}% from last month
                                    @else
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        {{ $orderChange }}% from last month
                                    @endif
                                </p>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card-3 rounded-2xl shadow-xl p-6 text-white card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-card-light text-sm font-medium mb-1">Categories</p>
                                <p class="text-4xl font-bold text-card-white">{{ $totalCategories }}</p>
                                <p class="text-card-muted text-xs mt-2">
                                    <i class="fas fa-tags mr-1"></i>
                                    Active categories
                                </p>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-tags text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-card-4 rounded-2xl shadow-xl p-6 text-white card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-card-light text-sm font-medium mb-1">Revenue</p>
                                <p class="text-4xl font-bold text-card-white">₦{{ number_format($monthlyRevenue, 2) }}</p>
                                <p class="text-card-muted text-xs mt-2">
                                    @if($revenueChange >= 0)
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        +{{ $revenueChange }}% from last month
                                    @else
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        {{ $revenueChange }}% from last month
                                    @endif
                                </p>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modern Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Recent Orders -->
                    <div class="lg:col-span-2">
                        <div style="background: linear-gradient(135deg, rgba(255, 251, 235, 0.95) 0%, rgba(254, 243, 199, 0.9) 100%); border: 1px solid rgba(217, 119, 6, 0.2);" class="rounded-2xl shadow-xl p-6 animate-fade-in-up">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                                    <i class="fas fa-clock mr-3 text-amber-700"></i>
                                    Recent Orders
                                </h3>
                                <a href="{{ route('admin.orders') }}" class="text-amber-700 hover:text-amber-800 font-semibold text-base flex items-center group">
                                    View All
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                            
                            <div class="space-y-4">
                                @php
                                    $gradients = [
                                        'style="background: linear-gradient(to right, #cb6906, #cb6906);"',
                                        'style="background: linear-gradient(to right, #cb6906, #cb6906);"',
                                        'style="background: linear-gradient(to right, #cb6906, #cb6906);"',
                                        'style="background: linear-gradient(to right, #cb6906, #cb6906);"',
                                        'style="background: linear-gradient(to right, #cb6906, #cb6906);"',
                                    ];
                                    $statusColors = [
                                        'pending' => ['bg' => 'bg-amber-600', 'icon' => 'animate-pulse'],
                                        'confirmed' => ['bg' => 'bg-blue-700', 'icon' => ''],
                                        'processing' => ['bg' => 'bg-orange-700', 'icon' => 'animate-pulse'],
                                        'shipped' => ['bg' => 'bg-indigo-700', 'icon' => ''],
                                        'delivered' => ['bg' => 'bg-green-700', 'icon' => ''],
                                        'completed' => ['bg' => 'bg-emerald-700', 'icon' => ''],
                                        'cancelled' => ['bg' => 'bg-gray-700', 'icon' => ''],
                                    ];
                                @endphp
                                
                                @forelse($recentOrders as $index => $order)
                                    <div class="flex items-center justify-between p-4 rounded-xl border border-amber-300/50 hover:shadow-lg hover:border-amber-400 transition-all duration-300" style="background-color: #FDF8F0;">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-sm" {!! $gradients[$index % count($gradients)] !!}>
                                                #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-amber-900">{{ $order->customer_name }}</p>
                                                <p class="text-sm text-amber-700">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} • ₦{{ number_format($order->total, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $statusConfig = $statusColors[$order->status] ?? ['bg' => 'bg-gray-500', 'icon' => ''];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} text-white">
                                                <div class="w-2 h-2 bg-white/50 rounded-full mr-2 {{ $statusConfig['icon'] }}"></div>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            <p class="text-xs text-amber-600 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <i class="fas fa-inbox text-4xl text-amber-300 mb-2"></i>
                                        <p class="text-amber-700">No recent orders</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions & Analytics -->
                    <div class="space-y-6">
                        <!-- Quick Actions -->
                        <div style="background: linear-gradient(135deg, rgba(255, 251, 235, 0.95) 0%, rgba(254, 243, 199, 0.9) 100%); border: 1px solid rgba(217, 119, 6, 0.2);" class="rounded-2xl shadow-xl p-6 animate-fade-in-up">
                            <h3 class="text-xl font-bold text-amber-900 mb-6 flex items-center">
                                <i class="fas fa-bolt mr-3 text-amber-700"></i>
                                Quick Actions
                            </h3>
                            
                            <div class="space-y-3">
                                <a href="{{ route('admin.products') }}" class="flex items-center p-4 text-white rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-xl focus-ring" style="background: linear-gradient(to right, #cb6906, #cb6906);" onmouseover="this.style.background='linear-gradient(to right, #b45d05, #b45d05)'" onmouseout="this.style.background='linear-gradient(to right, #cb6906, #cb6906)'">
                                    <i class="fas fa-plus-circle mr-3 text-lg"></i>
                                    <span class="font-semibold text-base">Add Product</span>
                                </a>
                                
                                <a href="{{ route('admin.categories') }}" class="flex items-center p-4 text-white rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-xl focus-ring" style="background: linear-gradient(to right, #cb6906, #cb6906);" onmouseover="this.style.background='linear-gradient(to right, #b45d05, #b45d05)'" onmouseout="this.style.background='linear-gradient(to right, #cb6906, #cb6906)'">
                                    <i class="fas fa-tags mr-3 text-lg"></i>
                                    <span class="font-semibold text-base">Manage Categories</span>
                                </a>
                                
                                <a href="{{ route('admin.orders') }}" class="flex items-center p-4 text-white rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-xl focus-ring" style="background: linear-gradient(to right, #cb6906, #cb6906);" onmouseover="this.style.background='linear-gradient(to right, #b45d05, #b45d05)'" onmouseout="this.style.background='linear-gradient(to right, #cb6906, #cb6906)'">
                                    <i class="fas fa-eye mr-3 text-lg"></i>
                                    <span class="font-semibold text-base">View Orders</span>
                                </a>
                                
                                <a href="{{ route('admin.banners') }}" class="flex items-center p-4 text-white rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-xl focus-ring" style="background: linear-gradient(to right, #cb6906, #cb6906);" onmouseover="this.style.background='linear-gradient(to right, #b45d05, #b45d05)'" onmouseout="this.style.background='linear-gradient(to right, #cb6906, #cb6906)'">
                                    <i class="fas fa-image mr-3 text-lg"></i>
                                    <span class="font-semibold text-base">Update Banners</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>

    <script src="{{ asset('js/admin-responsive.js') }}"></script>
    <script>
        // Additional dashboard-specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to buttons
            const buttons = document.querySelectorAll('button, .btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.disabled) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                        this.disabled = true;
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 1500);
                    }
                });
            });
            
            // Add hover effects to stats cards
            const statsCards = document.querySelectorAll('.stats-card, .stats-card-2, .stats-card-3, .stats-card-4');
            statsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Simulate real-time updates
            setInterval(() => {
                const liveIndicator = document.querySelector('.animate-pulse');
                if (liveIndicator) {
                    liveIndicator.style.opacity = '0.5';
                    setTimeout(() => {
                        liveIndicator.style.opacity = '1';
                    }, 200);
                }
            }, 3000);
        });
    </script>
</body>
</html>