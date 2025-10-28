<x-layouts.app>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-orange-600 text-white overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('https://images.unsplash.com/photo-1488459716781-31db52582fe9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
        </div>
        <div class="absolute inset-0" style="background-color: rgba(0, 0, 0, 0.70);"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/30 via-black/20 to-orange-900/30"></div>
        
        <!-- Content -->
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-6">
                    Get in Touch
                </h1>
                <p class="text-xl sm:text-2xl text-white max-w-3xl mx-auto leading-relaxed mb-8">
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#contact-form" class="text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hero-send-btn">
                        Send Message
                    </a>
                    <a href="#contact-info" class="bg-white/10 backdrop-blur-sm border border-white/60 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white transition-all duration-300 transform hover:scale-105 shadow-lg hero-contact-btn">
                        Contact Info
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Info Section -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div id="contact-form" class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Send us a Message</h2>
                        <p class="text-gray-600">Fill out the form below and we'll get back to you within 24 hours.</p>
                    </div>
                    
                    <form class="space-y-6" action="#" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Customer Support</option>
                                <option value="partnership">Partnership</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      placeholder="Tell us how we can help you..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none"></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg contact-submit-btn">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div id="contact-info" class="space-y-8">
                    <!-- Contact Details -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Contact Information</h2>
                        
                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Address</h3>
                                    <p class="text-gray-600">Lagos, Ikeja, Nigeria</p>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Phone</h3>
                                    <p class="text-gray-600">08147953648</p>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                                    <p class="text-gray-600">support@awamarket.com.ng<br>info@awamarket.com.ng</p>
                                </div>
                            </div>
                            
                            <!-- Business Hours -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Business Hours</h3>
                                    <p class="text-gray-600">Monday - Friday: 8:00 AM - 8:00 PM<br>Saturday: 9:00 AM - 6:00 PM<br>Sunday: 10:00 AM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gradient-to-br from-green-50 to-orange-50 rounded-2xl p-8 border border-green-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Quick Links</h3>
                        <div class="space-y-3">
                            <a href="/about" class="flex items-center text-green-600 hover:text-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                About Us
                            </a>
                            <a href="/shop-now" class="flex items-center text-green-600 hover:text-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Shop Now
                            </a>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                FAQ
                            </a>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Support Center
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-gray-600">Find answers to common questions about AwaMarket</p>
            </div>
            
            <div class="space-y-4" id="faq-accordion">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200 flex justify-between items-center" 
                            onclick="toggleAccordion('faq-1')">
                        <h3 class="text-lg font-semibold text-gray-900">How do I place an order?</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" id="faq-1-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 bg-gray-50 hidden" id="faq-1">
                        <p class="text-gray-600">Simply browse our products, add items to your cart, and proceed to checkout. We'll deliver fresh groceries right to your doorstep.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200 flex justify-between items-center" 
                            onclick="toggleAccordion('faq-2')">
                        <h3 class="text-lg font-semibold text-gray-900">What are your delivery areas?</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" id="faq-2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 bg-gray-50 hidden" id="faq-2">
                        <p class="text-gray-600">We currently deliver to Lagos, Abuja, and surrounding areas. We're expanding to more cities soon!</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200 flex justify-between items-center" 
                            onclick="toggleAccordion('faq-3')">
                        <h3 class="text-lg font-semibold text-gray-900">How fresh are your products?</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" id="faq-3-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 bg-gray-50 hidden" id="faq-3">
                        <p class="text-gray-600">We source directly from local farmers and suppliers daily to ensure maximum freshness. All products are quality-checked before delivery.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200 flex justify-between items-center" 
                            onclick="toggleAccordion('faq-4')">
                        <h3 class="text-lg font-semibold text-gray-900">What payment methods do you accept?</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" id="faq-4-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 bg-gray-50 hidden" id="faq-4">
                        <p class="text-gray-600">We accept all major credit cards, debit cards, bank transfers, and mobile money payments for your convenience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Accordion Functionality -->
    <script>
        function toggleAccordion(faqId) {
            const content = document.getElementById(faqId);
            const icon = document.getElementById(faqId + '-icon');
            
            // Close all other accordion items
            const allContents = document.querySelectorAll('#faq-accordion [id^="faq-"]:not([id$="-icon"])');
            const allIcons = document.querySelectorAll('#faq-accordion [id$="-icon"]');
            
            allContents.forEach(item => {
                if (item.id !== faqId) {
                    item.classList.add('hidden');
                }
            });
            
            allIcons.forEach(item => {
                if (item.id !== faqId + '-icon') {
                    item.classList.remove('rotate-180');
                }
            });
            
            // Toggle current item
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>

    <style>
        .hero-send-btn {
            background-color: #f54a00;
        }
        .hero-send-btn:hover {
            background-color: #d63e00;
        }
        .hero-contact-btn:hover {
            color: #f54a00;
        }
        .contact-submit-btn {
            background-color: #f54a00;
        }
        .contact-submit-btn:hover {
            background-color: #d63e00;
        }
        .cta-shop-btn {
            color: #f54a00;
        }
        .cta-about-btn:hover {
            color: #f54a00;
        }
    </style>

    <!-- Call to Action Section -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-orange-600">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Ready to Start Shopping?
            </h2>
            <p class="text-lg text-green-100 mb-8 max-w-2xl mx-auto">
                Join thousands of satisfied customers who trust AwaMarket for their daily grocery needs. 
                Fresh, quality products delivered to your doorstep.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/shop-now" class="bg-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg cta-shop-btn">
                    Start Shopping Now
                </a>
                <a href="/about" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white transition-colors cta-about-btn">
                    Learn More About Us
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>