@props(['currentPage' => ''])

<!-- Modern Sidebar -->
<div class="w-64 sidebar-gradient shadow-xl flex-shrink-0 relative fixed left-0 top-0 h-screen z-40 hidden lg:block">
    <!-- Logo Section -->
    <div class="p-6 sidebar-logo-section">
        <a href="http://localhost:8000/admin/" class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
            <img src="/images/logo.png" alt="AwaMarket Logo" class="h-12 w-auto">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="mt-8 px-4 space-y-8">
        <!-- Products Management -->
        <div>
            <h3 class="px-3 text-xs sidebar-section-header text-amber-700 uppercase tracking-wider mb-4">Products Management</h3>
            <div class="space-y-2">
                <a href="/admin/products" class="sidebar-nav-item flex items-center px-4 py-3 {{ $currentPage === 'products' ? 'active text-gray-800 bg-amber-100' : 'text-gray-700 hover:text-amber-800 hover:bg-amber-50' }} rounded-xl transition-all duration-300">
                    <i class="fas fa-box mr-3 text-sm"></i>
                    <span class="text-sm font-medium">All Products</span>
                </a>
                <a href="/admin/categories" class="sidebar-nav-item flex items-center px-4 py-3 {{ $currentPage === 'categories' ? 'active text-gray-800 bg-amber-100' : 'text-gray-700 hover:text-amber-800 hover:bg-amber-50' }} rounded-xl transition-all duration-300">
                    <i class="fas fa-tags mr-3 text-sm"></i>
                    <span class="text-sm font-medium">Categories</span>
                </a>
                <a href="/admin/orders" class="sidebar-nav-item flex items-center px-4 py-3 {{ $currentPage === 'orders' ? 'active text-gray-800 bg-amber-100' : 'text-gray-700 hover:text-amber-800 hover:bg-amber-50' }} rounded-xl transition-all duration-300">
                    <i class="fas fa-shopping-cart mr-3 text-sm"></i>
                    <span class="text-sm font-medium">Orders</span>
                </a>
            </div>
        </div>

        <!-- Settings -->
        <div>
            <h3 class="px-3 text-xs sidebar-section-header text-amber-700 uppercase tracking-wider mb-4">Settings</h3>
            <div class="space-y-2">
                <a href="/admin/banners" class="sidebar-nav-item flex items-center px-4 py-3 {{ $currentPage === 'banners' ? 'active text-gray-800 bg-amber-100' : 'text-gray-700 hover:text-amber-800 hover:bg-amber-50' }} rounded-xl transition-all duration-300">
                    <i class="fas fa-images mr-3 text-sm"></i>
                    <span class="text-sm font-medium">Banners</span>
                </a>
                <a href="/admin/whatsapp" class="sidebar-nav-item flex items-center px-4 py-3 {{ $currentPage === 'whatsapp' ? 'active text-white' : 'text-gray-700 hover:text-amber-800 hover:bg-amber-50' }} rounded-xl transition-all duration-300">
                    <i class="fab fa-whatsapp mr-3 text-sm"></i>
                    <span class="text-sm font-medium">WhatsApp</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 p-4 sidebar-user-profile">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 sidebar-user-avatar rounded-full flex items-center justify-center">
                <i class="fas fa-user text-amber-700 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Admin User</p>
                <p class="text-xs text-amber-700 truncate font-medium">Administrator</p>
            </div>
            <div class="w-2 h-2 bg-green-400 rounded-full shadow-lg animate-pulse"></div>
        </div>
    </div>
</div>