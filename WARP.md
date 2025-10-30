# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

AwaMarket is a Laravel 12 e-commerce application with an admin dashboard, built with:
- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Tailwind CSS, Alpine.js, Livewire 3.6
- **Build Tools**: Vite, NPM
- **Database**: SQLite (development), MySQL-compatible for production
- **Additional**: Laravel Breeze for authentication, DomPDF for PDF generation, Maatwebsite/Excel for exports

## Essential Commands

### Development Environment

```bash
# Full setup (first time)
composer run-script setup

# Start all development services concurrently (server, queue, logs, vite)
composer run-script dev

# Individual services
php artisan serve                    # Start Laravel server
php artisan queue:listen --tries=1   # Start queue worker
php artisan pail --timeout=0        # Start log viewer
npm run dev                          # Start Vite dev server

# Build assets for production
npm run build
```

### Testing

```bash
# Run all tests
composer run-script test
# OR
php artisan test

# Run specific test file
php artisan test tests/Feature/YourTest.php

# Run specific test method
php artisan test --filter test_method_name

# Run with coverage (requires PCOV or Xdebug)
php artisan test --coverage
```

### Code Quality

```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific file/directory
./vendor/bin/pint app/Http/Controllers
./vendor/bin/pint resources/views
```

### Database Operations

```bash
# Run migrations
php artisan migrate

# Fresh migration with seeders
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_tablename_table

# Rollback migrations
php artisan migrate:rollback
```

### Cache Management

```bash
# Clear all caches (development)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan optimize
```

## Architecture Overview

### Core Business Logic Flow

1. **Customer Flow**: Homepage → Shop → Product Details → Cart → Checkout (WhatsApp integration)
2. **Admin Flow**: Login → Dashboard → Manage (Products/Categories/Orders/Banners/WhatsApp Settings)

### Key Models & Relationships

- **Product** → belongs to Category, has options (JSON), featured image, multiple images
- **Category** → has many Products, has image, is_active status
- **Order** → has many OrderItems, customer info (JSON), status enum
- **Banner** → single main banner system with is_active toggle
- **PromotionBanner** → multiple promotional banners with positioning
- **WhatsAppSetting** → global WhatsApp configuration

### Controller Architecture

- **AdminController**: Handles all admin operations (products, categories, orders, banners, settings)
  - Uses `ImageHandler` utility for image processing
  - Implements filtering, pagination, and search
  - Exports functionality via Maatwebsite/Excel

- **HomeController**: Public homepage, WhatsApp settings API
- **ShopController**: Product listing and detail pages
- **CartController**: Cart management, checkout, order creation

### Frontend Architecture

- **Blade Templates**: Located in `resources/views/`
  - Layout: `layouts/app.blade.php`, `layouts/admin.blade.php`
  - Components: `components/` for reusable UI elements
  - Admin views: `admin/` subdirectory
  - Auth views: `auth/` for Laravel Breeze authentication

- **JavaScript**: 
  - Main app: `resources/js/app.js`
  - Admin responsive: `public/js/admin-responsive.js`

### Image Handling

The application uses a custom `ImageHandler` utility (`app/Utils/ImageHandler.php`) for:
- Product images (featured + gallery)
- Category images
- Banner images
- Automatic directory creation
- Old image cleanup

### Session Management

- **Cart**: Session-based cart storage
- **Authentication**: File-based sessions (configurable in .env)
- **Session lifetime**: 120 minutes default

## Development Patterns

### Validation Pattern
Controllers use Laravel's Validator facade with explicit rules:
```php
$validator = Validator::make($request->all(), [
    'field' => 'required|string|max:255',
]);
```

### Query Filtering Pattern
Applied consistently in admin controllers:
```php
$query = Model::query();
if ($request->has('filter')) {
    $query->where('field', $request->filter);
}
$results = $query->paginate(10);
```

### Image Upload Pattern
Consistent use of ImageHandler utility:
```php
use App\Utils\ImageHandler;
$imagePath = ImageHandler::handleUpload($request->file('image'), 'directory');
```

## Deployment Considerations

### Environment Configuration
- Set `APP_ENV=production` and `APP_DEBUG=false` in production
- Configure database credentials appropriately
- Set proper `APP_URL`

### Required Directories
Ensure these directories exist with write permissions:
- `storage/app/public/`
- `bootstrap/cache/`
- `storage/framework/`

### Asset Building
Always run `npm run build` before deployment to compile production assets.

### Database
Run migrations with `--force` flag in production:
```bash
php artisan migrate --force
```

## XAMPP Local Development

This project is configured for XAMPP on macOS. The project path is:
`/Applications/XAMPP/xamppfiles/htdocs/web-projects/awamarket/awamarket/`

Ensure XAMPP Apache and MySQL services are running before starting development.

## WhatsApp Integration

The application includes WhatsApp checkout integration:
- Settings managed via Admin Panel → WhatsApp Settings
- Phone number and default message configurable
- API endpoint: `/api/whatsapp-settings`

## Common Troubleshooting

### Session Issues
If cart or authentication sessions aren't persisting:
1. Check `SESSION_DRIVER` in `.env`
2. Clear session files: `rm -rf storage/framework/sessions/*`
3. Ensure proper permissions on storage directory

### Image Upload Issues
1. Check `storage/app/public` symlink exists
2. Run `php artisan storage:link` if needed
3. Verify write permissions on storage directories

### Migration Issues
1. Check database connection in `.env`
2. For SQLite, ensure database file exists: `touch database/database.sqlite`
3. Clear config cache: `php artisan config:clear`