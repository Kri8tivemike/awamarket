// Modern Responsive Admin Dashboard JavaScript

class ResponsiveAdminDashboard {
    constructor() {
        this.isMobile = window.innerWidth <= 768;
        this.isTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
        this.sidebarOpen = false;
        
        this.init();
        this.bindEvents();
    }
    
    init() {
        this.createMobileElements();
        this.handleResize();
        this.initAnimations();
    }
    
    createMobileElements() {
        if (this.isMobile) {
            this.createMobileHeader();
            this.createSidebarOverlay();
            this.updateSidebarClasses();
        }
    }
    
    createMobileHeader() {
        const mainContent = document.querySelector('.main-content') || document.querySelector('main');
        if (!mainContent) return;
        
        const mobileHeader = document.createElement('div');
        mobileHeader.className = 'mobile-header lg:hidden';
        mobileHeader.innerHTML = `
            <button class="mobile-menu-btn focus-ring" id="mobileMenuBtn" aria-label="Toggle menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Admin Dashboard</h1>
            <div class="w-10"></div>
        `;
        
        mainContent.insertBefore(mobileHeader, mainContent.firstChild);
    }
    
    createSidebarOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay lg:hidden';
        overlay.id = 'sidebarOverlay';
        document.body.appendChild(overlay);
    }
    
    updateSidebarClasses() {
        const sidebar = document.querySelector('.sidebar-gradient');
        if (sidebar) {
            if (this.isMobile) {
                sidebar.classList.add('sidebar-mobile');
                sidebar.classList.remove('sidebar-tablet', 'sidebar-desktop');
            } else if (this.isTablet) {
                sidebar.classList.add('sidebar-tablet');
                sidebar.classList.remove('sidebar-mobile', 'sidebar-desktop');
            } else {
                sidebar.classList.add('sidebar-desktop');
                sidebar.classList.remove('sidebar-mobile', 'sidebar-tablet');
            }
        }
        
        const mainContent = document.querySelector('.main-content') || document.querySelector('main');
        if (mainContent) {
            if (this.isMobile) {
                mainContent.classList.add('main-content-mobile');
                mainContent.classList.remove('main-content-tablet', 'main-content-desktop');
            } else if (this.isTablet) {
                mainContent.classList.add('main-content-tablet');
                mainContent.classList.remove('main-content-mobile', 'main-content-desktop');
            } else {
                mainContent.classList.add('main-content-desktop');
                mainContent.classList.remove('main-content-mobile', 'main-content-tablet');
            }
        }
    }
    
    bindEvents() {
        // Mobile menu toggle
        document.addEventListener('click', (e) => {
            if (e.target.closest('#mobileMenuBtn')) {
                this.toggleSidebar();
            }
            
            if (e.target.closest('#sidebarOverlay')) {
                this.closeSidebar();
            }
        });
        
        // Window resize handler
        window.addEventListener('resize', this.debounce(() => {
            this.handleResize();
        }, 250));
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.sidebarOpen) {
                this.closeSidebar();
            }
        });
        
        // Touch gestures for mobile
        if ('ontouchstart' in window) {
            this.initTouchGestures();
        }
    }
    
    handleResize() {
        const oldIsMobile = this.isMobile;
        const oldIsTablet = this.isTablet;
        
        this.isMobile = window.innerWidth <= 768;
        this.isTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
        
        if (oldIsMobile !== this.isMobile || oldIsTablet !== this.isTablet) {
            this.updateLayout();
        }
        
        // Close sidebar on desktop
        if (!this.isMobile && this.sidebarOpen) {
            this.closeSidebar();
        }
    }
    
    updateLayout() {
        // Remove existing mobile elements
        const existingHeader = document.querySelector('.mobile-header');
        const existingOverlay = document.querySelector('.sidebar-overlay');
        
        if (existingHeader) existingHeader.remove();
        if (existingOverlay) existingOverlay.remove();
        
        // Update grid classes
        this.updateGridClasses();
        
        // Recreate mobile elements if needed
        if (this.isMobile) {
            this.createMobileElements();
        }
        
        this.updateSidebarClasses();
    }
    
    updateGridClasses() {
        // Update stats grid
        const statsGrid = document.querySelector('.grid');
        if (statsGrid && statsGrid.children.length === 4) {
            statsGrid.className = this.isMobile 
                ? 'grid stats-grid-mobile gap-6 mb-8'
                : this.isTablet 
                    ? 'grid stats-grid-tablet gap-6 mb-8'
                    : 'grid grid-cols-4 gap-6 mb-8';
        }
        
        // Update content grid
        const contentGrid = document.querySelector('.grid.grid-cols-3');
        if (contentGrid) {
            contentGrid.className = this.isMobile 
                ? 'grid content-grid-mobile gap-6'
                : this.isTablet 
                    ? 'grid content-grid-tablet gap-6'
                    : 'grid grid-cols-3 gap-6';
        }
        
        // Update quick actions grid
        const quickActionsGrid = document.querySelector('.grid.grid-cols-2');
        if (quickActionsGrid) {
            quickActionsGrid.className = this.isMobile 
                ? 'grid quick-actions-mobile'
                : 'grid grid-cols-2 gap-4';
        }
    }
    
    toggleSidebar() {
        if (this.sidebarOpen) {
            this.closeSidebar();
        } else {
            this.openSidebar();
        }
    }
    
    openSidebar() {
        const sidebar = document.querySelector('.sidebar-mobile');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar && overlay) {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            this.sidebarOpen = true;
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Focus management
            const firstNavItem = sidebar.querySelector('a');
            if (firstNavItem) {
                firstNavItem.focus();
            }
        }
    }
    
    closeSidebar() {
        const sidebar = document.querySelector('.sidebar-mobile');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar && overlay) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            this.sidebarOpen = false;
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Return focus to menu button
            const menuBtn = document.querySelector('#mobileMenuBtn');
            if (menuBtn) {
                menuBtn.focus();
            }
        }
    }
    
    initTouchGestures() {
        let startX = 0;
        let startY = 0;
        let isSwipeGesture = false;
        
        document.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isSwipeGesture = false;
        });
        
        document.addEventListener('touchmove', (e) => {
            if (!startX || !startY) return;
            
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            
            const diffX = startX - currentX;
            const diffY = startY - currentY;
            
            // Check if it's a horizontal swipe
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                isSwipeGesture = true;
                
                // Swipe right to open sidebar (from left edge)
                if (diffX < 0 && startX < 50 && !this.sidebarOpen) {
                    this.openSidebar();
                }
                
                // Swipe left to close sidebar
                if (diffX > 0 && this.sidebarOpen) {
                    this.closeSidebar();
                }
            }
        });
        
        document.addEventListener('touchend', () => {
            startX = 0;
            startY = 0;
            isSwipeGesture = false;
        });
    }
    
    initAnimations() {
        // Add staggered animations to stats cards
        const statsCards = document.querySelectorAll('.stats-card, .stats-card-2, .stats-card-3, .stats-card-4');
        if (statsCards.length > 0) {
            const statsGrid = statsCards[0].parentElement;
            if (statsGrid) {
                statsGrid.classList.add('animate-stagger');
            }
        }
        
        // Add fade-in animation to main content
        const mainContent = document.querySelector('.main-content') || document.querySelector('main');
        if (mainContent) {
            mainContent.classList.add('animate-fade-in-up');
        }
        
        // Intersection Observer for scroll animations
        this.initScrollAnimations();
    }
    
    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);
        
        // Observe cards and sections
        const elementsToObserve = document.querySelectorAll('.bg-white, .glass-effect');
        elementsToObserve.forEach(el => {
            observer.observe(el);
        });
    }
    
    // Utility function
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
    }
}

// Enhanced notification system for responsive design
class ResponsiveNotification {
    static show(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `
            fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm w-full
            transform translate-x-full transition-transform duration-300 ease-out
            ${type === 'success' ? 'bg-green-500 text-white' : 
              type === 'error' ? 'bg-red-500 text-white' : 
              type === 'warning' ? 'bg-yellow-500 text-black' : 
              'bg-blue-500 text-white'}
        `;
        
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium">${message}</span>
                <button class="ml-4 text-current opacity-70 hover:opacity-100" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    }
}

// Performance monitoring
class PerformanceMonitor {
    constructor() {
        this.metrics = {
            loadTime: 0,
            renderTime: 0,
            interactionTime: 0
        };
        
        this.init();
    }
    
    init() {
        // Measure page load time
        window.addEventListener('load', () => {
            this.metrics.loadTime = performance.now();
            console.log(`Page loaded in ${this.metrics.loadTime.toFixed(2)}ms`);
        });
        
        // Measure first contentful paint
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.name === 'first-contentful-paint') {
                        console.log(`First Contentful Paint: ${entry.startTime.toFixed(2)}ms`);
                    }
                }
            });
            
            observer.observe({ entryTypes: ['paint'] });
        }
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize responsive dashboard
    window.responsiveAdmin = new ResponsiveAdminDashboard();
    
    // Initialize performance monitoring
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        new PerformanceMonitor();
    }
    
    // Add global notification function
    window.showNotification = ResponsiveNotification.show;
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading states for buttons
    document.querySelectorAll('button, .btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!this.disabled && !this.classList.contains('loading')) {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 1000);
            }
        });
    });
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ResponsiveAdminDashboard,
        ResponsiveNotification,
        PerformanceMonitor
    };
}