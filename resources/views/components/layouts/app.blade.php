<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <!-- Product Options Modal Component - Positioned at top for proper overlay -->
    <x-product-options-modal 
        :show="false" 
        title="Basic Stew Pack"
        modalId="product-options-modal" 
    />

    <!-- Enhanced Navigation Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 group">
                        <!-- Logo Image -->
                        <img src="/images/logo.png" alt="AwaMarket Logo" class="h-10 w-auto transition-all duration-200 hover:scale-105">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->is('/') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Home
                    </a>
                    <a href="/shop-now" class="text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->is('shop-now') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Shop Now
                    </a>
                    <a href="/about" class="text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->is('about') ? 'text-orange-600 bg-orange-50' : '' }}">
                        About Us
                    </a>
                    <a href="/contact" class="text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->is('contact') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Contact
                    </a>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar (Desktop) -->
                    <form method="GET" action="{{ route('shop.index') }}" class="hidden md:block">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search products..." 
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Cart Icon with Dropdown (Hidden on Mobile) -->
                    <div class="relative hidden md:block">
                        <button id="cart-button" class="relative p-2 transition-colors duration-200" style="color: #bd6005;" onmouseover="this.style.color='#9d5004'" onmouseout="this.style.color='#bd6005'" onclick="toggleCartDropdown()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h7M9.5 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm10 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            </svg>
                            <!-- Cart Badge -->
                            <span id="cart-count-badge" class="cart-count absolute -top-1 -right-1 bg-green-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </button>

                        <!-- Mini Cart Dropdown -->
                        <div id="cart-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <!-- Cart Header -->
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900">Shopping Cart (<span id="mini-cart-count">0</span>)</h3>
                            </div>

                            <!-- Cart Items Container -->
                            <div id="mini-cart-items" class="max-h-96 overflow-y-auto">
                                <!-- Empty State -->
                                <div id="mini-cart-empty" class="p-8 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 -960 960 960" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Your cart is empty</p>
                                </div>

                                <!-- Cart Items will be dynamically inserted here -->
                                <div id="mini-cart-list" class="hidden divide-y divide-gray-200"></div>
                            </div>

                            <!-- Cart Footer -->
                            <div id="mini-cart-footer" class="hidden p-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-semibold text-gray-900">Total:</span>
                                    <span id="mini-cart-total" class="font-bold text-green-600 text-lg">₦0.00</span>
                                </div>
                                <a href="/cart" class="block w-full bg-green-600 text-white text-center py-2.5 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200">
                                    View Cart
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Search Button (Visible only on Mobile) -->
                    <div class="md:hidden">
                        <button id="mobile-search-button" class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200" onclick="toggleMobileSearch()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="md:hidden p-2 text-gray-400 hover:text-orange-600 transition-colors duration-200" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="md:hidden border-t border-gray-200 py-4" style="display: none;">
                <!-- Mobile Search -->
                <form method="GET" action="{{ route('shop.index') }}" class="px-3 mb-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search products..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                
                <div class="space-y-2">
                    <a href="/" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-md transition-colors duration-200 {{ request()->is('/') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Home
                    </a>
                    <a href="/shop-now" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-md transition-colors duration-200 {{ request()->is('shop-now') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Shop Now
                    </a>
                    <a href="/about" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-md transition-colors duration-200 {{ request()->is('about') ? 'text-orange-600 bg-orange-50' : '' }}">
                        About Us
                    </a>
                    <a href="/contact" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-md transition-colors duration-200 {{ request()->is('contact') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Mobile Search Overlay -->
            <div id="mobile-search-overlay" class="md:hidden border-t border-gray-200 py-4 bg-white" style="display: none;">
                <form method="GET" action="{{ route('shop.index') }}" class="px-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search products..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            autofocus>
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleMobileSearch()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Simplified Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <!-- Company Info -->
                <div class="mb-8">
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <img src="/images/logo.png" alt="AwaMarket Logo" class="h-12 w-auto">
                    </div>
                    <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                        Your trusted marketplace for fresh produce, quality proteins, and daily essentials. 
                        Bringing farm-fresh goodness directly to your doorstep.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <!-- Social Media Icons -->
                        <!-- Facebook -->
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-200" title="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <!-- TikTok -->
                        <a href="#" class="text-gray-400 hover:text-black transition-colors duration-200" title="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                        <!-- Instagram -->
                        <a href="#" class="text-gray-400 hover:text-pink-600 transition-colors duration-200" title="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'awamarket') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 md:hidden z-50 w-full">
        <div class="flex justify-around items-center py-3 w-full max-w-full">
            <!-- Home -->
            <a href="/" class="flex flex-col items-center justify-center py-1 px-2 transition-colors duration-200 rounded-lg hover:bg-orange-50 flex-1 {{ request()->is('/') ? 'text-orange-600 bg-orange-50' : 'text-orange-600' }}">
                <svg class="w-6 h-6 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs font-medium">Home</span>
            </a>

            <!-- Shop -->
            <a href="/shop-now" class="flex flex-col items-center justify-center py-1 px-2 transition-colors duration-200 rounded-lg hover:bg-orange-50 flex-1 {{ request()->is('shop-now') ? 'text-orange-600 bg-orange-50' : 'text-orange-600' }}">
                <svg class="w-6 h-6 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
                <span class="text-xs font-medium">Shop</span>
            </a>

            <!-- Cart -->
            <a href="/cart" class="flex flex-col items-center justify-center py-1 px-2 transition-colors duration-200 relative rounded-lg hover:bg-orange-50 flex-1 {{ request()->is('cart') ? 'text-orange-600 bg-orange-50' : 'text-orange-600' }}">
                <div class="relative">
                    <svg class="w-6 h-6 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <!-- Cart Badge -->
                    <span id="mobile-cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">0</span>
                </div>
                <span class="text-xs font-medium">Cart</span>
            </a>

            <!-- Chat (WhatsApp) -->
            <a id="mobile-whatsapp-link" href="https://wa.me/+2348000000000" target="_blank" class="flex flex-col items-center justify-center py-1 px-2 transition-colors duration-200 rounded-lg hover:bg-orange-50 text-orange-600 flex-1">
                <svg class="w-6 h-6 mb-1.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                <span class="text-xs font-medium">Chat</span>
            </a>
        </div>
    </nav>

    <!-- Add bottom padding to main content to prevent overlap with mobile nav -->
    <style>
        @media (max-width: 768px) {
            body {
                padding-bottom: 80px;
            }
        }
    </style>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }

        function toggleMobileSearch() {
            const searchOverlay = document.getElementById('mobile-search-overlay');
            const mobileMenu = document.getElementById('mobile-menu');
            
            // Close mobile menu if open
            if (mobileMenu.style.display === 'block') {
                mobileMenu.style.display = 'none';
            }
            
            if (searchOverlay.style.display === 'none' || searchOverlay.style.display === '') {
                searchOverlay.style.display = 'block';
                // Focus on the search input after a short delay to ensure it's visible
                setTimeout(() => {
                    const searchInput = searchOverlay.querySelector('input[name="search"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }, 100);
            } else {
                searchOverlay.style.display = 'none';
            }
        }

        // Cart Dropdown Functions
        function toggleCartDropdown() {
            const dropdown = document.getElementById('cart-dropdown');
            dropdown.classList.toggle('hidden');
            
            // Load cart data when opening
            if (!dropdown.classList.contains('hidden')) {
                loadMiniCart();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const cartButton = document.getElementById('cart-button');
            const dropdown = document.getElementById('cart-dropdown');
            
            if (dropdown && !dropdown.classList.contains('hidden')) {
                if (!cartButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });

        // Load mini cart data
        function loadMiniCart() {
            fetch('{{ url('') }}/api/cart')
                .then(response => response.json())
                .then(data => {
                    updateMiniCart(data);
                })
                .catch(error => {
                    console.error('Error loading cart:', error);
                });
        }

        // Update mini cart UI
        function updateMiniCart(data) {
            const miniCartCount = document.getElementById('mini-cart-count');
            const miniCartEmpty = document.getElementById('mini-cart-empty');
            const miniCartList = document.getElementById('mini-cart-list');
            const miniCartFooter = document.getElementById('mini-cart-footer');
            const miniCartTotal = document.getElementById('mini-cart-total');
            const mobileCartBadge = document.getElementById('mobile-cart-badge');
            
            // Update count
            const count = data.count || 0;
            miniCartCount.textContent = count;
            
            // Update mobile cart badge
            if (mobileCartBadge) {
                mobileCartBadge.textContent = count;
                if (count === 0) {
                    mobileCartBadge.style.display = 'none';
                } else {
                    mobileCartBadge.style.display = 'flex';
                }
            }
            
            if (!data.cart || data.cart.length === 0) {
                // Show empty state
                miniCartEmpty.classList.remove('hidden');
                miniCartList.classList.add('hidden');
                miniCartFooter.classList.add('hidden');
            } else {
                // Show cart items
                miniCartEmpty.classList.add('hidden');
                miniCartList.classList.remove('hidden');
                miniCartFooter.classList.remove('hidden');
                
                // Build cart items HTML
                let itemsHTML = '';
                data.cart.forEach(item => {
                    itemsHTML += `
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-start gap-3">
                                ${item.image ? 
                                    `<img src="${item.image}" alt="${item.product_name}" class="w-12 h-12 object-cover rounded-lg">` :
                                    `<div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>`
                                }
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">${item.product_name}</h4>
                                    <p class="text-xs text-gray-500 truncate">${item.option_name}</p>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs text-gray-600">Qty: ${item.quantity}</span>
                                        <span class="text-sm font-semibold text-green-600">₦${(item.price * item.quantity).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                miniCartList.innerHTML = itemsHTML;
                miniCartTotal.textContent = `₦${parseFloat(data.total).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }
        }

        // Load cart count and WhatsApp settings on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Load cart count
            fetch('{{ url('') }}/api/cart')
                .then(response => response.json())
                .then(data => {
                    const cartBadge = document.getElementById('cart-count-badge');
                    const mobileCartBadge = document.getElementById('mobile-cart-badge');
                    const count = data.count || 0;
                    
                    if (cartBadge) {
                        cartBadge.textContent = count;
                    }
                    if (mobileCartBadge) {
                        mobileCartBadge.textContent = count;
                        // Hide badge if count is 0
                        if (count === 0) {
                            mobileCartBadge.style.display = 'none';
                        } else {
                            mobileCartBadge.style.display = 'flex';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading cart count:', error);
                });

            // Load WhatsApp settings
            fetch('{{ url('') }}/api/whatsapp-settings')
                .then(response => response.json())
                .then(data => {
                    const whatsappLink = document.getElementById('mobile-whatsapp-link');
                    if (whatsappLink && data.phone_number) {
                        // Update the WhatsApp link with the dynamic phone number
                        whatsappLink.href = `https://wa.me/${data.phone_number}`;
                    }
                })
                .catch(error => {
                    console.error('Error loading WhatsApp settings:', error);
                });
        });
    </script>

    @livewireScripts
</body>
</html>