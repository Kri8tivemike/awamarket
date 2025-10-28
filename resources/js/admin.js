// Admin Dashboard JavaScript Functionality

// Mobile Navigation Toggle
function initMobileNavigation() {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.querySelector('.mobile-nav-toggle');
    const overlay = document.createElement('div');
    
    if (!sidebar || !toggleBtn) return;
    
    // Create overlay for mobile
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 hidden';
    overlay.id = 'sidebar-overlay';
    document.body.appendChild(overlay);
    
    // Toggle sidebar
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    });
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
    
    // Close sidebar on window resize if desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
}

// Notification System
class AdminNotification {
    constructor() {
        this.container = this.createContainer();
    }
    
    createContainer() {
        const container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
        return container;
    }
    
    show(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `admin-notification admin-notification-${type} show`;
        
        const icon = this.getIcon(type);
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="${icon} text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        this.container.appendChild(notification);
        
        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, duration);
        }
        
        return notification;
    }
    
    getIcon(type) {
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        return icons[type] || icons.info;
    }
    
    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    }
    
    error(message, duration = 5000) {
        return this.show(message, 'error', duration);
    }
    
    warning(message, duration = 5000) {
        return this.show(message, 'warning', duration);
    }
    
    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    }
}

// Initialize notification system
const adminNotification = new AdminNotification();

// Modal Management
class AdminModal {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.overlay = this.modal?.querySelector('.modal-overlay');
        this.closeButtons = this.modal?.querySelectorAll('[data-modal-close]');
        
        if (this.modal) {
            this.init();
        }
    }
    
    init() {
        // Close on overlay click
        if (this.overlay) {
            this.overlay.addEventListener('click', (e) => {
                if (e.target === this.overlay) {
                    this.close();
                }
            });
        }
        
        // Close on close button click
        this.closeButtons?.forEach(btn => {
            btn.addEventListener('click', () => this.close());
        });
        
        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) {
                this.close();
            }
        });
    }
    
    open() {
        if (this.modal) {
            this.modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Focus first input
            const firstInput = this.modal.querySelector('input, textarea, select');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        }
    }
    
    close() {
        if (this.modal) {
            this.modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }
    
    isOpen() {
        return this.modal && !this.modal.classList.contains('hidden');
    }
}

// Form Validation
class AdminFormValidator {
    constructor(formId, rules = {}) {
        this.form = document.getElementById(formId);
        this.rules = rules;
        this.errors = {};
        
        if (this.form) {
            this.init();
        }
    }
    
    init() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validate()) {
                e.preventDefault();
                this.showErrors();
            }
        });
        
        // Real-time validation
        Object.keys(this.rules).forEach(fieldName => {
            const field = this.form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('blur', () => this.validateField(fieldName));
                field.addEventListener('input', () => this.clearFieldError(fieldName));
            }
        });
    }
    
    validate() {
        this.errors = {};
        let isValid = true;
        
        Object.keys(this.rules).forEach(fieldName => {
            if (!this.validateField(fieldName)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    validateField(fieldName) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        const rules = this.rules[fieldName];
        
        if (!field || !rules) return true;
        
        const value = field.value.trim();
        
        // Required validation
        if (rules.required && !value) {
            this.errors[fieldName] = rules.messages?.required || `${fieldName} is required`;
            return false;
        }
        
        // Skip other validations if field is empty and not required
        if (!value && !rules.required) return true;
        
        // Email validation
        if (rules.email && !this.isValidEmail(value)) {
            this.errors[fieldName] = rules.messages?.email || 'Please enter a valid email address';
            return false;
        }
        
        // Min length validation
        if (rules.minLength && value.length < rules.minLength) {
            this.errors[fieldName] = rules.messages?.minLength || `Minimum ${rules.minLength} characters required`;
            return false;
        }
        
        // Max length validation
        if (rules.maxLength && value.length > rules.maxLength) {
            this.errors[fieldName] = rules.messages?.maxLength || `Maximum ${rules.maxLength} characters allowed`;
            return false;
        }
        
        // Custom validation
        if (rules.custom && !rules.custom(value)) {
            this.errors[fieldName] = rules.messages?.custom || 'Invalid value';
            return false;
        }
        
        return true;
    }
    
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    showErrors() {
        Object.keys(this.errors).forEach(fieldName => {
            this.showFieldError(fieldName, this.errors[fieldName]);
        });
    }
    
    showFieldError(fieldName, message) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (!field) return;
        
        field.classList.add('error');
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message text-red-500 text-xs mt-1';
        errorElement.textContent = message;
        field.parentNode.appendChild(errorElement);
    }
    
    clearFieldError(fieldName) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (!field) return;
        
        field.classList.remove('error');
        const errorMessage = field.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
        
        delete this.errors[fieldName];
    }
    
    clearAllErrors() {
        this.errors = {};
        this.form.querySelectorAll('.error').forEach(field => {
            field.classList.remove('error');
        });
        this.form.querySelectorAll('.error-message').forEach(error => {
            error.remove();
        });
    }
}

// Data Table with Search and Pagination
class AdminDataTable {
    constructor(tableId, options = {}) {
        this.table = document.getElementById(tableId);
        this.options = {
            searchable: true,
            sortable: true,
            paginated: true,
            pageSize: 10,
            ...options
        };
        
        this.data = [];
        this.filteredData = [];
        this.currentPage = 1;
        this.sortColumn = null;
        this.sortDirection = 'asc';
        
        if (this.table) {
            this.init();
        }
    }
    
    init() {
        this.extractData();
        this.createControls();
        this.bindEvents();
        this.render();
    }
    
    extractData() {
        const rows = this.table.querySelectorAll('tbody tr');
        this.data = Array.from(rows).map(row => {
            const cells = row.querySelectorAll('td');
            return Array.from(cells).map(cell => cell.textContent.trim());
        });
        this.filteredData = [...this.data];
    }
    
    createControls() {
        const container = document.createElement('div');
        container.className = 'admin-table-controls mb-4 flex flex-col sm:flex-row gap-4 justify-between';
        
        if (this.options.searchable) {
            const searchContainer = document.createElement('div');
            searchContainer.className = 'admin-search-container flex-1 max-w-md';
            searchContainer.innerHTML = `
                <div class="relative">
                    <i class="fas fa-search admin-search-icon"></i>
                    <input type="text" id="${this.table.id}-search" class="admin-search-input admin-form-input" placeholder="Search...">
                </div>
            `;
            container.appendChild(searchContainer);
        }
        
        this.table.parentNode.insertBefore(container, this.table);
        
        if (this.options.paginated) {
            this.createPagination();
        }
    }
    
    createPagination() {
        const paginationContainer = document.createElement('div');
        paginationContainer.id = `${this.table.id}-pagination`;
        paginationContainer.className = 'admin-pagination';
        this.table.parentNode.appendChild(paginationContainer);
    }
    
    bindEvents() {
        if (this.options.searchable) {
            const searchInput = document.getElementById(`${this.table.id}-search`);
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    this.search(e.target.value);
                });
            }
        }
        
        if (this.options.sortable) {
            const headers = this.table.querySelectorAll('th[data-sortable]');
            headers.forEach((header, index) => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    this.sort(index);
                });
            });
        }
    }
    
    search(query) {
        if (!query) {
            this.filteredData = [...this.data];
        } else {
            this.filteredData = this.data.filter(row => 
                row.some(cell => 
                    cell.toLowerCase().includes(query.toLowerCase())
                )
            );
        }
        this.currentPage = 1;
        this.render();
    }
    
    sort(columnIndex) {
        if (this.sortColumn === columnIndex) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortColumn = columnIndex;
            this.sortDirection = 'asc';
        }
        
        this.filteredData.sort((a, b) => {
            const aVal = a[columnIndex];
            const bVal = b[columnIndex];
            
            let comparison = 0;
            if (aVal > bVal) comparison = 1;
            if (aVal < bVal) comparison = -1;
            
            return this.sortDirection === 'desc' ? -comparison : comparison;
        });
        
        this.render();
    }
    
    render() {
        this.renderTable();
        if (this.options.paginated) {
            this.renderPagination();
        }
    }
    
    renderTable() {
        const tbody = this.table.querySelector('tbody');
        if (!tbody) return;
        
        const startIndex = (this.currentPage - 1) * this.options.pageSize;
        const endIndex = startIndex + this.options.pageSize;
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        tbody.innerHTML = '';
        
        if (pageData.length === 0) {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = this.table.querySelectorAll('th').length;
            cell.className = 'text-center py-8 text-gray-500';
            cell.textContent = 'No data found';
            row.appendChild(cell);
            tbody.appendChild(row);
            return;
        }
        
        pageData.forEach(rowData => {
            const row = document.createElement('tr');
            rowData.forEach(cellData => {
                const cell = document.createElement('td');
                cell.className = 'px-4 py-3 border-b border-gray-200';
                cell.textContent = cellData;
                row.appendChild(cell);
            });
            tbody.appendChild(row);
        });
    }
    
    renderPagination() {
        const container = document.getElementById(`${this.table.id}-pagination`);
        if (!container) return;
        
        const totalPages = Math.ceil(this.filteredData.length / this.options.pageSize);
        
        if (totalPages <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <button class="admin-pagination-btn ${this.currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${this.currentPage === 1 ? 'disabled' : ''} 
                    onclick="adminDataTables['${this.table.id}'].goToPage(${this.currentPage - 1})">
                <i class="fas fa-chevron-left"></i>
            </button>
        `;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) {
                paginationHTML += `
                    <button class="admin-pagination-btn ${i === this.currentPage ? 'active' : ''}" 
                            onclick="adminDataTables['${this.table.id}'].goToPage(${i})">
                        ${i}
                    </button>
                `;
            } else if (i === this.currentPage - 3 || i === this.currentPage + 3) {
                paginationHTML += '<span class="px-2">...</span>';
            }
        }
        
        // Next button
        paginationHTML += `
            <button class="admin-pagination-btn ${this.currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${this.currentPage === totalPages ? 'disabled' : ''} 
                    onclick="adminDataTables['${this.table.id}'].goToPage(${this.currentPage + 1})">
                <i class="fas fa-chevron-right"></i>
            </button>
        `;
        
        container.innerHTML = paginationHTML;
    }
    
    goToPage(page) {
        const totalPages = Math.ceil(this.filteredData.length / this.options.pageSize);
        if (page >= 1 && page <= totalPages) {
            this.currentPage = page;
            this.render();
        }
    }
}

// Global data tables registry
window.adminDataTables = {};

// Drag and Drop functionality
class AdminDragDrop {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.options = {
            handle: '.drag-handle',
            placeholder: 'drag-placeholder',
            onReorder: null,
            ...options
        };
        
        if (this.container) {
            this.init();
        }
    }
    
    init() {
        this.container.addEventListener('dragstart', this.handleDragStart.bind(this));
        this.container.addEventListener('dragover', this.handleDragOver.bind(this));
        this.container.addEventListener('drop', this.handleDrop.bind(this));
        this.container.addEventListener('dragend', this.handleDragEnd.bind(this));
        
        // Make items draggable
        this.updateDraggableItems();
    }
    
    updateDraggableItems() {
        const items = this.container.querySelectorAll('[data-draggable]');
        items.forEach(item => {
            item.draggable = true;
            const handle = item.querySelector(this.options.handle);
            if (handle) {
                handle.style.cursor = 'move';
            }
        });
    }
    
    handleDragStart(e) {
        if (!e.target.hasAttribute('data-draggable')) return;
        
        this.draggedElement = e.target;
        e.target.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', e.target.outerHTML);
    }
    
    handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        
        const afterElement = this.getDragAfterElement(e.clientY);
        if (afterElement == null) {
            this.container.appendChild(this.draggedElement);
        } else {
            this.container.insertBefore(this.draggedElement, afterElement);
        }
    }
    
    handleDrop(e) {
        e.preventDefault();
        if (this.options.onReorder) {
            const items = Array.from(this.container.querySelectorAll('[data-draggable]'));
            const newOrder = items.map(item => item.dataset.id || item.id);
            this.options.onReorder(newOrder);
        }
    }
    
    handleDragEnd(e) {
        if (this.draggedElement) {
            this.draggedElement.classList.remove('dragging');
            this.draggedElement = null;
        }
    }
    
    getDragAfterElement(y) {
        const draggableElements = [...this.container.querySelectorAll('[data-draggable]:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
}

// Utility Functions
const AdminUtils = {
    // Format currency
    formatCurrency(amount, currency = 'USD') {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: currency
        }).format(amount);
    },
    
    // Format date
    formatDate(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        return new Intl.DateTimeFormat('en-US', { ...defaultOptions, ...options }).format(new Date(date));
    },
    
    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Copy to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            adminNotification.success('Copied to clipboard');
        } catch (err) {
            console.error('Failed to copy: ', err);
            adminNotification.error('Failed to copy to clipboard');
        }
    },
    
    // Confirm dialog
    confirm(message, onConfirm, onCancel = null) {
        if (window.confirm(message)) {
            onConfirm();
        } else if (onCancel) {
            onCancel();
        }
    }
};

// Initialize admin dashboard on DOM load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile navigation
    initMobileNavigation();
    
    // Initialize data tables
    document.querySelectorAll('[data-admin-table]').forEach(table => {
        const options = JSON.parse(table.dataset.adminTable || '{}');
        window.adminDataTables[table.id] = new AdminDataTable(table.id, options);
    });
    
    // Initialize drag and drop
    document.querySelectorAll('[data-admin-dragdrop]').forEach(container => {
        const options = JSON.parse(container.dataset.adminDragdrop || '{}');
        new AdminDragDrop(container.id, options);
    });
    
    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Export for global use
window.AdminModal = AdminModal;
window.AdminFormValidator = AdminFormValidator;
window.AdminDataTable = AdminDataTable;
window.AdminDragDrop = AdminDragDrop;
window.adminNotification = adminNotification;
window.AdminUtils = AdminUtils;