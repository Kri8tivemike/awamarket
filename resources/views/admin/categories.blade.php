<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Categories - AwaMarket Admin</title>
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
    <x-admin-sidebar currentPage="categories" />
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto scrollable-content" style="height: calc(100vh - 120px); padding-bottom: 2rem;">
        <div class="content-section">
            <!-- Modern Header -->
            <header style="background-color: #fefdf8; height: 120px; flex-shrink: 0;" class="header border-b border-amber-200/30 backdrop-blur-sm">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">Categories</h2>
                            <p class="text-gray-600 flex items-center text-lg font-medium">
                                <i class="fas fa-tags mr-3 text-blue-500 text-xl"></i>
                                Organize your products into categories
                            </p>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-full px-5 py-3 border border-green-200 shadow-sm">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg"></div>
                                <span class="text-sm font-bold text-green-700 tracking-wide">{{ $categories->count() }} categories</span>
                            </div>
                            <button id="addCategoryBtn" style="background-color: #f8f6f0;" class="text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-102 focus:outline-none focus:ring-2 focus:ring-gray-300 font-semibold text-sm border border-gray-200">
                                <i class="fas fa-plus mr-2 text-sm"></i>
                                Add Category
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <div class="p-6">
                <!-- Filters and Search -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <!-- Status Filter -->
                        <div class="flex-1">
                            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                            <select id="statusFilter" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Categories</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Search Filter -->
                        <div class="flex-1">
                            <label for="searchInput" class="block text-sm font-medium text-gray-700 mb-2">Search Categories</label>
                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search by name or description..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Filter Button -->
                        <div class="flex items-end">
                            <button type="button" id="applyFilters" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">{{ $categories->count() }} categories</div>
                </div>
                
                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="hidden mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span id="selectedCount" class="text-sm font-medium text-blue-700">0 categories selected</span>
                            <button id="selectAllBtn" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Select All</button>
                            <button id="deselectAllBtn" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Deselect All</button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="bulkDeleteBtn" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Categories Table -->
                <div class="modern-table rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-left">
                                        <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="w-1/3 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="w-1/6 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Products</th>
                                    <th class="w-1/6 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Created</th>
                                    <th class="w-1/8 px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Status</th>
                                    <th class="w-1/12 px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/90 divide-y divide-gray-200/50">
                                @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $category->id }}">
                                    </td>
                                    <td class="px-4 sm:px-6 py-3">
                                        <div class="flex items-center min-w-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                                <i class="fas fa-tag text-white text-sm"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $category->description ?? 'No description' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-900 hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $category->products->count() }} products
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-500 hidden md:table-cell">{{ $category->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 sm:px-6 py-3 hidden lg:table-cell">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-1">
                                            <button class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors edit-category-btn" data-id="{{ $category->id }}">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 p-1 rounded transition-colors delete-category-btn" data-id="{{ $category->id }}">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-folder-open text-4xl text-gray-300 mb-2"></i>
                                            <p class="text-sm">No categories found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        @if($categories->total() > 0)
                            @if($categories->firstItem() == $categories->lastItem())
                                Showing {{ $categories->firstItem() }} of {{ $categories->total() }} results
                            @else
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                            @endif
                        @else
                            No results found
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-6 w-80 max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4" id="modalTitle">Add New Category</h3>
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" id="categoryName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="categoryDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="categoryDescription" name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-none"></textarea>
                </div>
                <div class="mb-4">
                    <label for="categoryImage" class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
                    <input type="file" id="categoryImage" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <small class="text-xs text-gray-500 mt-1">Upload an image for this category (optional)</small>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="categoryActive" name="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelBtn" class="px-3 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Cancel</button>
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let editingCategoryId = null;

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Add Category Button
        document.getElementById('addCategoryBtn').addEventListener('click', function() {
            editingCategoryId = null;
            document.getElementById('modalTitle').textContent = 'Add New Category';
            document.getElementById('categoryForm').reset();
            document.getElementById('categoryActive').checked = true;
            document.getElementById('categoryModal').classList.remove('hidden');
        });

        // Cancel Button
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('categoryModal').classList.add('hidden');
        });

        // Edit Category Buttons
        document.querySelectorAll('.edit-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                editingCategoryId = categoryId;
                
                fetch(`/admin/categories/${categoryId}/edit`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(category => {
                        document.getElementById('modalTitle').textContent = 'Edit Category';
                        document.getElementById('categoryName').value = category.name;
                        document.getElementById('categoryDescription').value = category.description || '';
                        document.getElementById('categoryActive').checked = category.is_active;
                        document.getElementById('categoryModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error loading category data');
                    });
            });
        });

        // Delete Category Buttons
        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                
                showCustomAlert('Are you sure you want to delete this category?', 'Delete Category', () => {
                    fetch(`/admin/categories/${categoryId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showCustomAlert('Category deleted successfully!', 'Success', () => {
                                location.reload();
                            }, 'success');
                        } else {
                            showCustomAlert('Error deleting category', 'Error', null, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomAlert('Error deleting category', 'Error', null, 'error');
                    });
                });
            });
        });

        // Form Submit
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // For file uploads, we need to send FormData directly, not JSON
            const url = editingCategoryId ? `/admin/categories/${editingCategoryId}` : '/admin/categories';
            const method = editingCategoryId ? 'PUT' : 'POST';

            // Add method override for PUT requests when using FormData
            if (editingCategoryId) {
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                method: 'POST', // Always use POST when sending FormData
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
            .then(response => {
                // Parse JSON regardless of status
                return response.json().then(data => ({ status: response.status, data }));
            })
            .then(({ status, data }) => {
                if (status === 422) {
                    // Validation error
                    let errorMessage = 'Validation failed:\n';
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            errorMessage += `${data.errors[key].join(', ')}\n`;
                        });
                    } else if (data.message) {
                        errorMessage = data.message;
                    }
                    showCustomAlert(errorMessage, 'Validation Error', null, 'error');
                } else if (data.success) {
                    document.getElementById('categoryModal').classList.add('hidden');
                    showCustomAlert('Category saved successfully!', 'Success', () => {
                        location.reload();
                    }, 'success');
                } else {
                    showCustomAlert(data.message || 'Error saving category', 'Error', null, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Error saving category: ' + error.message, 'Error', null, 'error');
            });
        });

        // Custom Alert Function
        function showCustomAlert(message, title = 'Alert', callback = null, type = 'confirm') {
            // Remove existing alert if any
            const existingAlert = document.getElementById('customAlert');
            if (existingAlert) {
                existingAlert.remove();
            }

            // Create alert modal
            const alertModal = document.createElement('div');
            alertModal.id = 'customAlert';
            alertModal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50';
            
            let iconHtml = '';
            let buttonClass = '';
            let iconClass = '';
            
            if (type === 'success') {
                iconHtml = '<svg class="w-6 h-6 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                buttonClass = 'bg-green-600 hover:bg-green-700';
                iconClass = 'text-green-600';
            } else if (type === 'error') {
                iconHtml = '<svg class="w-6 h-6 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                buttonClass = 'bg-red-600 hover:bg-red-700';
                iconClass = 'text-red-600';
            } else {
                iconHtml = '<svg class="w-6 h-6 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                buttonClass = 'bg-blue-600 hover:bg-blue-700';
                iconClass = 'text-blue-600';
            }
            
            alertModal.innerHTML = `
                <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-6 w-96 max-w-sm mx-4 text-center">
                    ${iconHtml}
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">${title}</h3>
                    <p class="text-gray-600 mb-6 whitespace-pre-line text-left">${message}</p>
                    <div class="flex justify-center space-x-3">
                        ${type === 'confirm' ? `<button id="cancelAlert" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">Cancel</button>` : ''}
                        <button id="confirmAlert" class="px-4 py-2 ${buttonClass} text-white rounded-md text-sm">${type === 'confirm' ? 'Delete' : 'OK'}</button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(alertModal);
            
            // Handle confirm button
            document.getElementById('confirmAlert').addEventListener('click', function() {
                alertModal.remove();
                if (callback) callback();
            });
            
            // Handle cancel button (only for confirm type)
            if (type === 'confirm') {
                document.getElementById('cancelAlert').addEventListener('click', function() {
                    alertModal.remove();
                });
            }
            
            // Close on backdrop click for non-confirm alerts
            if (type !== 'confirm') {
                alertModal.addEventListener('click', function(e) {
                    if (e.target === alertModal) {
                        alertModal.remove();
                    }
                });
            }
        }

        // Apply filters functionality
        document.getElementById('applyFilters').addEventListener('click', function() {
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchInput').value;
            
            // Build URL with query parameters
            const url = new URL(window.location.href);
            url.searchParams.delete('page'); // Reset pagination when filtering
            
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            
            // Redirect to filtered URL
            window.location.href = url.toString();
        });

        // Handle Enter key in search input
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('applyFilters').click();
            }
        });

        // Handle status filter change
        document.getElementById('statusFilter').addEventListener('change', function() {
            document.getElementById('applyFilters').click();
        });

        // Search functionality (removed client-side search as we now use server-side)
        // The old client-side search has been replaced with server-side filtering

        // Bulk Operations Functionality
        let selectedCategories = [];

        // Update selected count and show/hide bulk actions bar
        function updateBulkActionsBar() {
            const selectedCount = selectedCategories.length;
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            
            if (selectedCount > 0) {
                bulkActionsBar.classList.remove('hidden');
                selectedCountSpan.textContent = `${selectedCount} ${selectedCount === 1 ? 'category' : 'categories'} selected`;
            } else {
                bulkActionsBar.classList.add('hidden');
            }
        }

        // Handle individual checkbox changes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('category-checkbox')) {
                const categoryId = parseInt(e.target.value);
                
                if (e.target.checked) {
                    if (!selectedCategories.includes(categoryId)) {
                        selectedCategories.push(categoryId);
                    }
                } else {
                    selectedCategories = selectedCategories.filter(id => id !== categoryId);
                }
                
                updateBulkActionsBar();
                updateSelectAllCheckbox();
            }
        });

        // Handle select all checkbox
        document.getElementById('selectAllCheckbox').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const isChecked = this.checked;
            
            selectedCategories = [];
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                if (isChecked) {
                    selectedCategories.push(parseInt(checkbox.value));
                }
            });
            
            updateBulkActionsBar();
        });

        // Update select all checkbox state based on individual selections
        function updateSelectAllCheckbox() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkedCount = selectedCategories.length;
            const totalCount = checkboxes.length;
            
            if (checkedCount === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCount === totalCount) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }
        }

        // Select All button
        document.getElementById('selectAllBtn').addEventListener('click', function() {
            document.getElementById('selectAllCheckbox').checked = true;
            document.getElementById('selectAllCheckbox').dispatchEvent(new Event('change'));
        });

        // Deselect All button
        document.getElementById('deselectAllBtn').addEventListener('click', function() {
            document.getElementById('selectAllCheckbox').checked = false;
            document.getElementById('selectAllCheckbox').dispatchEvent(new Event('change'));
        });

        // Bulk Delete functionality
        document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
            if (selectedCategories.length === 0) {
                showCustomAlert('Please select categories to delete', 'No Selection', null, 'error');
                return;
            }

            const message = `Are you sure you want to delete ${selectedCategories.length} ${selectedCategories.length === 1 ? 'category' : 'categories'}? This action cannot be undone.`;
            
            showCustomAlert(message, 'Confirm Bulk Delete', function() {
                // Perform bulk delete
                fetch('{{ route("admin.categories.bulk-delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        category_ids: selectedCategories
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showCustomAlert(data.message, 'Success', function() {
                            location.reload();
                        }, 'success');
                    } else {
                        showCustomAlert(data.message || 'Error deleting categories', 'Error', null, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showCustomAlert('Error deleting categories', 'Error', null, 'error');
                });
            }, 'confirm');
        });
    </script>
</body>
</html>