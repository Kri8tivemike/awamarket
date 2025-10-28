<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Settings - AwaMarket Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ Vite::asset('resources/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/whatsapp-modern.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Custom scrollbar styling */
        .scrollable-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .scrollable-content::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .scrollable-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .scrollable-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .scrollable-content {
            max-height: calc(100vh - 120px);
            overflow-x: hidden;
            overflow-y: auto;
            padding-right: 4px;
        }
        
        .main-content-wrapper {
            height: calc(100vh - 0px);
            overflow: hidden;
        }
        
        .content-section {
            height: 100%;
            box-sizing: border-box;
            min-height: fit-content;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .scrollable-content {
                max-height: calc(100vh - 140px);
            }
            
            header {
                height: 140px;
            }
        }
        
        @media (max-width: 640px) {
            .scrollable-content {
                max-height: calc(100vh - 160px);
            }
            
            header {
                height: 160px;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-amber-50/30 min-h-screen page-transition">
    <div class="flex h-screen">
        <x-admin-sidebar />
        
        <main class="flex-1 overflow-y-auto scrollable-content" style="height: calc(100vh - 120px); padding-bottom: 2rem;">
            <div class="content-section">
                <div class="p-8 custom-scrollbar">
                    <div class="max-w-6xl mx-auto">
                        <!-- Header -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fab fa-whatsapp text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold gradient-text">WhatsApp Configuration</h1>
                                        <p class="text-gray-600 mt-1">Configure your WhatsApp business integration settings</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-8">
                                    <div class="flex items-center space-x-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-full px-5 py-3 border border-green-200 shadow-sm">
                                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg"></div>
                                        <span class="text-sm font-bold text-green-700 tracking-wide">Connected</span>
                                    </div>
                                    <button style="background-color: #f8f6f0;" class="text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-gray-300 font-semibold text-sm border border-gray-200">
                                        <i class="fas fa-cog mr-2 text-sm"></i>
                                        Settings
                                    </button>
                                </div>
                            </div>
                        </div>

                <!-- WhatsApp Configuration Form - In its own row -->
                <div class="w-full">
                    <div class="bg-gradient-to-br from-white to-amber-50/30 backdrop-blur-sm rounded-2xl shadow-lg border border-amber-200/30 overflow-hidden modern-card">
                    <div class="px-8 py-6 border-b border-amber-200/30 bg-gradient-to-r from-amber-50 to-orange-50">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-cog text-amber-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">WhatsApp Configuration</h3>
                                <p class="text-sm text-gray-600 mt-1">Set up your business WhatsApp integration</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <form id="whatsapp-form" action="{{ route('admin.whatsapp.save') }}" method="POST" class="space-y-8 modern-form">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">Business Phone Number</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-amber-500 text-sm"></i>
                                        </div>
                                        <input type="tel" name="phone_number" class="block w-full pl-12 pr-4 py-4 bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg text-gray-800 placeholder-gray-400 @error('phone_number') border-red-500 @enderror" placeholder="+1234567890" value="{{ old('phone_number', $settings->phone_number ?? '') }}" required>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 mb-3">Business Name</label>
                                    <input type="text" name="business_name" class="block w-full px-4 py-4 bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg text-gray-800 placeholder-gray-400 @error('business_name') border-red-500 @enderror" placeholder="AwaMarket Store" value="{{ old('business_name', $settings->business_name ?? '') }}" required>
                                    @error('business_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Welcome Message</label>
                                <textarea name="welcome_message" rows="4" class="block w-full px-4 py-4 bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg text-gray-800 placeholder-gray-400 resize-none @error('welcome_message') border-red-500 @enderror" placeholder="Welcome to AwaMarket! How can we help you today?" required>{{ old('welcome_message', $settings->welcome_message ?? '') }}</textarea>
                                @error('welcome_message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Enable WhatsApp Chat Widget</label>
                                <div class="flex items-center justify-between p-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200/50 modern-card">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center icon-bounce">
                                                <i class="fab fa-whatsapp text-amber-600 text-xl"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">Chat Widget</h4>
                                            <p class="text-sm text-gray-600">Allow customers to contact you directly via WhatsApp</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer group">
                                        <input type="checkbox" id="enable_whatsapp" name="enable_whatsapp" value="1" 
                                               {{ old('enable_whatsapp', $settings->enable_chat_widget ?? false) ? 'checked' : '' }}
                                               class="sr-only peer modern-toggle">
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all duration-300 peer-checked:bg-gradient-to-r peer-checked:from-amber-500 peer-checked:to-amber-600 shadow-inner group-hover:shadow-md transition-all duration-300"></div>
                                        <div class="absolute inset-0 rounded-full bg-gradient-to-r from-transparent to-white/20 opacity-0 peer-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>

                        </form>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-center pt-8">
                        <button type="submit" form="whatsapp-form" class="group relative overflow-hidden bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white px-12 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-amber-500/30 ripple-button">
                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative z-10 flex items-center space-x-3">
                                <i class="fas fa-save text-xl"></i>
                                <span>Save Configuration</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>