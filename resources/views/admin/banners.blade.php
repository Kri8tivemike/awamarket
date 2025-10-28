<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banners - AwaMarket Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
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
            box-sizing: border-box;
            min-height: fit-content;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        @media (max-width: 768px) {
            .scrollable-content {
                max-height: calc(100vh - 140px);
            }
        }
    </style>
</head>
<body class="admin-body">
    <div class="flex h-screen">
        <!-- Unified Sidebar Component -->
        <x-admin-sidebar currentPage="banners" />
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto scrollable-content" style="height: calc(100vh - 120px); padding-bottom: 2rem;">
            <!-- Modern Header -->
            <header style="background-color: #fefdf8; flex-shrink: 0; height: 120px;" class="border-b border-amber-200/30 backdrop-blur-sm">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">Banners</h2>
                            <p class="text-gray-600 flex items-center text-lg font-medium">
                                <i class="fas fa-image mr-3 text-orange-500 text-xl"></i>
                                Manage promotional banners and advertisements
                            </p>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-orange-50 to-amber-50 rounded-full px-5 py-3 border border-orange-200 shadow-sm">
                                <div class="w-3 h-3 bg-orange-500 rounded-full animate-pulse shadow-lg"></div>
                                <span class="text-sm font-bold text-orange-700 tracking-wide">{{ $banner ? 'Active' : 'No banner' }}</span>
                            </div>
                            @if(!$banner)
                            <button onclick="openModal('addBannerModal')" class="bg-gradient-to-r from-orange-500 to-amber-600 text-white px-5 py-2 rounded-lg hover:from-orange-600 hover:to-amber-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-orange-300 font-semibold text-sm">
                                <i class="fas fa-plus mr-2 text-sm"></i>
                                Add Banner
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Content Area -->
            <div class="content-section">
                <div class="p-4 overflow-y-auto">
                    <!-- Top Banner -->
                    <div class="mb-3">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Banner</h2>
                        
                        @if($banner)
                            <div class="grid grid-cols-1 max-w-2xl">
                                <div class="modern-card rounded-xl shadow-lg overflow-hidden card-hover">
                                    <div class="banner-preview h-48 flex items-center justify-center bg-gray-100">
                                        @if($banner->image)
                                            <img src="{{ asset($banner->image) }}" alt="Banner Image" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-center">
                                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                                <p class="text-gray-600">No Image</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="font-semibold text-gray-800">Banner Image</h3>
                                            <div class="flex items-center space-x-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $banner->status ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $banner->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                            <span>Updated: {{ $banner->updated_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editBanner({{ $banner->id }}, {{ $banner->status ? 'true' : 'false' }})" class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-colors">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.banners.delete', $banner->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <form method="POST" action="{{ route('admin.banners.toggle', $banner->id) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-colors">
                                                        <i class="fas fa-{{ $banner->status ? 'eye-slash' : 'eye' }} text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-image text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">No banner yet</h3>
                                <p class="text-gray-600 mb-6">Create your first banner to get started</p>
                                <button onclick="openModal('addBannerModal')" class="bg-gradient-to-r from-orange-600 to-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:from-orange-700 hover:to-amber-700 hover:shadow-lg transition-all duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Your First Banner
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Promotion Banners Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Promotion Banners</h2>
                            <p class="text-gray-600 mt-1">Manage promotional banners displayed on the home page</p>
                        </div>
                        <button onclick="openModal('addPromotionBannerModal')" class="bg-gradient-to-r from-orange-600 to-amber-600 text-white px-4 py-2 rounded-lg font-medium hover:from-orange-700 hover:to-amber-700 hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Add Promotion Banner
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($promotionBanners as $promotionBanner)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                    @if($promotionBanner->image)
                                        <img src="{{ asset($promotionBanner->image) }}" alt="{{ $promotionBanner->alt_text }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-gray-600">No Image</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-semibold text-gray-800">{{ $promotionBanner->title }}</h3>
                                        <div class="flex items-center space-x-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $promotionBanner->status ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $promotionBanner->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                        <span>Order: {{ $promotionBanner->sort_order }}</span>
                                        <span>Updated: {{ $promotionBanner->updated_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="editPromotionBanner({{ $promotionBanner->id }}, '{{ $promotionBanner->title }}', '{{ $promotionBanner->alt_text }}', '{{ $promotionBanner->link }}', {{ $promotionBanner->status ? 'true' : 'false' }}, {{ $promotionBanner->sort_order }})" class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-colors">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.promotion-banners.delete', $promotionBanner->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this promotion banner?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <form method="POST" action="{{ route('admin.promotion-banners.toggle', $promotionBanner->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-colors">
                                                    <i class="fas fa-{{ $promotionBanner->status ? 'eye-slash' : 'eye' }} text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-images text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">No promotion banners yet</h3>
                                <p class="text-gray-600 mb-6">Create your first promotion banner to get started</p>
                                <button onclick="openModal('addPromotionBannerModal')" class="bg-gradient-to-r from-orange-600 to-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:from-orange-700 hover:to-amber-700 hover:shadow-lg transition-all duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Your First Promotion Banner
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Banner Modal -->
    <div id="addBannerModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Add New Banner</h3>
                <button onclick="closeModal('addBannerModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image *</label>
                        <input type="file" name="image" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Recommended: 1920x600px, Max size: 5MB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addBannerModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Banner Modal -->
    <div id="editBannerModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Edit Banner</h3>
                <button onclick="closeModal('editBannerModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="editStatus" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('editBannerModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Promotion Banner Modal -->
    <div id="addPromotionBannerModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Add New Promotion Banner</h3>
                <button onclick="closeModal('addPromotionBannerModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.promotion-banners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image *</label>
                        <input type="file" name="image" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Recommended: 750x400px, Max size: 5MB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                        <input type="text" name="alt_text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link (Optional)</label>
                        <input type="url" name="link" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="1" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addPromotionBannerModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Create Promotion Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Promotion Banner Modal -->
    <div id="editPromotionBannerModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Edit Promotion Banner</h3>
                <button onclick="closeModal('editPromotionBannerModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editPromotionBannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" id="editPromotionTitle" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                        <input type="text" id="editPromotionAltText" name="alt_text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link (Optional)</label>
                        <input type="url" id="editPromotionLink" name="link" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number" id="editPromotionSortOrder" name="sort_order" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="editPromotionStatus" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('editPromotionBannerModal')" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Update Promotion Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }
        
        function editBanner(id, status) {
            document.getElementById('editBannerForm').action = `/admin/banners/${id}`;
            document.getElementById('editStatus').value = status ? '1' : '0';
            openModal('editBannerModal');
        }
        
        function editPromotionBanner(id, title, altText, link, status, sortOrder) {
            document.getElementById('editPromotionBannerForm').action = `/admin/promotion-banners/${id}`;
            document.getElementById('editPromotionTitle').value = title;
            document.getElementById('editPromotionAltText').value = altText;
            document.getElementById('editPromotionLink').value = link;
            document.getElementById('editPromotionStatus').value = status ? '1' : '0';
            document.getElementById('editPromotionSortOrder').value = sortOrder;
            openModal('editPromotionBannerModal');
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }
    </script>
</body>
</html>