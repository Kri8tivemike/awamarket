<x-layouts.app>
    <!-- Hero Section with Background Banner -->
    <section class="relative overflow-hidden py-24 sm:py-32">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80');"></div>
            <div class="absolute inset-0 bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/25 via-transparent to-orange-900/25"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="text-center">
                <h1 class="text-white text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-6">
                    About <span class="text-green-400">AwaMarket</span>
                </h1>
                <p class="text-gray-100 text-xl sm:text-2xl max-w-3xl mx-auto mb-8">
                    Your trusted marketplace for fresh produce, quality proteins, and daily essentials.
                    Bringing farm-fresh goodness directly to your doorstep.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/shop-now" class="hero-shop-btn text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Start Shopping
                    </a>
                    <a href="/contact" class="hero-contact-btn bg-white/10 backdrop-blur-sm border border-white/60 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Mission -->
                <div class="bg-gray-50 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To revolutionize the way people access fresh, quality food by creating a seamless 
                        connection between local farmers, suppliers, and consumers. We're committed to 
                        making healthy, affordable groceries accessible to everyone.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-orange-50 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To become the leading online marketplace for fresh food in Nigeria, empowering 
                        communities with convenient access to nutritious meals while supporting local 
                        farmers and sustainable agriculture practices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    These principles guide everything we do and shape our commitment to our customers and community.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Quality -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Quality First</h3>
                    <p class="text-gray-600">
                        We source only the freshest produce and highest quality products, ensuring every item meets our strict standards.
                    </p>
                </div>

                <!-- Reliability -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Reliability</h3>
                    <p class="text-gray-600">
                        Count on us for timely deliveries and consistent service. Your satisfaction is our priority.
                    </p>
                </div>

                <!-- Sustainability -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Sustainability</h3>
                    <p class="text-gray-600">
                        We're committed to environmentally responsible practices and supporting sustainable farming methods.
                    </p>
                </div>

                <!-- Community -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Community Focus</h3>
                    <p class="text-gray-600">
                        We believe in supporting local communities and building lasting relationships with our customers and partners.
                    </p>
                </div>

                <!-- Innovation -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
                    <p class="text-gray-600">
                        We continuously improve our platform and services to provide the best shopping experience possible.
                    </p>
                </div>

                <!-- Transparency -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Transparency</h3>
                    <p class="text-gray-600">
                        We maintain open communication about our sourcing, pricing, and business practices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <div class="space-y-4 text-gray-600 text-lg leading-relaxed">
                        <p>
                            AwaMarket was born from a simple observation: accessing fresh, quality food shouldn't be complicated or expensive. 
                            Founded with the vision of bridging the gap between local farmers and urban consumers, we started as a small 
                            initiative to make healthy eating more accessible.
                        </p>
                        <p>
                            Today, we've grown into a trusted platform that serves thousands of families across Nigeria, connecting them 
                            with the freshest produce, quality proteins, and daily essentials. Our journey is driven by the belief that 
                            everyone deserves access to nutritious, affordable food.
                        </p>
                        <p>
                            As we continue to expand, our commitment remains unchanged: to deliver exceptional quality, support local 
                            communities, and make grocery shopping a delightful experience for every customer.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-green-100 to-orange-100 rounded-2xl p-8 h-96 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 -960 960 960" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Fresh • Quality • Convenient</h3>
                            <p class="text-gray-600">Bringing the market to your doorstep</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-orange-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl sm:text-5xl font-bold text-white mb-2">1000+</div>
                    <div class="text-green-100 text-lg">Happy Customers</div>
                </div>
                <div>
                    <div class="text-4xl sm:text-5xl font-bold text-white mb-2">500+</div>
                    <div class="text-green-100 text-lg">Products Available</div>
                </div>
                <div>
                    <div class="text-4xl sm:text-5xl font-bold text-white mb-2">50+</div>
                    <div class="text-green-100 text-lg">Local Partners</div>
                </div>
                <div>
                    <div class="text-4xl sm:text-5xl font-bold text-white mb-2">24/7</div>
                    <div class="text-green-100 text-lg">Customer Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-orange-50">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Join the AwaMarket Family
            </h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Experience the convenience of fresh, quality groceries delivered to your doorstep. 
                Start your journey with us today and discover why thousands trust AwaMarket for their daily needs.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/shop-now" class="cta-shop-btn text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    Start Shopping Now
                </a>
                <a href="/contact" class="cta-contact-btn px-8 py-3 rounded-lg font-semibold transition-colors">
                    Get in Touch
                </a>
            </div>
        </div>
    </section>

    <style>
        .hero-shop-btn {
            background-color: #f54a00;
        }
        .hero-shop-btn:hover {
            background-color: #d63e00;
        }
        .hero-contact-btn:hover {
            color: #f54a00;
        }
        .cta-shop-btn {
            background-color: #f54a00;
        }
        .cta-shop-btn:hover {
            background-color: #d63e00;
        }
        .cta-contact-btn {
            border: 1px solid #f54a00;
            color: #f54a00;
        }
        .cta-contact-btn:hover {
            background-color: #f54a00;
            color: white;
        }
    </style>
</x-layouts.app>