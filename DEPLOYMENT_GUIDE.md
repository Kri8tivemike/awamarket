# AwaMarket - cPanel Deployment Guide

## Pre-Deployment Review Results ✅

### Security Status: **READY**
- ✅ No hardcoded credentials found
- ✅ All sensitive data uses environment variables
- ✅ Models properly use `$fillable` arrays (mass assignment protection)
- ✅ Authentication middleware properly configured
- ✅ CSRF protection in place

### Code Quality Status: **ACTION REQUIRED**
- ⚠️ **Multiple `console.log()` statements found in production code**
- ⚠️ Debug statements present (non-critical, for development only)

### Configuration Status: **READY**
- ✅ Environment configuration uses proper env() helpers
- ✅ ImageHandler uses relative paths (no local XAMPP paths)
- ✅ File storage configured correctly for symlinks
- ✅ Vite configuration ready for production builds

---

## Critical Issues to Address Before Deployment

### 🔴 HIGH PRIORITY - Remove Console Logs

Multiple files contain `console.log()` statements that should be removed or commented out for production:

**Files with console.log:**
1. `resources/js/admin.js` (6 instances)
2. `public/js/admin-responsive.js` (15 instances)
3. `resources/views/admin/products.blade.php` (21 instances)
4. `resources/views/pages/product-details.blade.php` (12 instances)
5. `resources/views/components/product-card.blade.php` (9 instances)
6. `resources/views/admin/orders/edit.blade.php` (11 instances)
7. Other view files with debug logs

**Recommended Action:**
```bash
# Search and review all console.log statements
grep -r "console\.log" resources/ public/js/

# Option 1: Comment them out manually
# Option 2: Remove them with sed (backup first!)
# find resources/ -type f -name "*.blade.php" -exec sed -i.bak 's/console\.log/\/\/ console.log/g' {} +
```

---

## cPanel Deployment Checklist

### Phase 1: Prepare Local Environment

#### 1. Clean Up Debug Code
```bash
# Remove or comment out console.log statements
# Review and clean debug code manually
```

#### 2. Build Production Assets
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/web-projects/awamarket/awamarket

# Install dependencies (if not already installed)
npm install

# Build production assets with Vite
npm run build

# Verify build output exists
ls -la public/build/
```

#### 3. Optimize Composer Dependencies
```bash
# Install production dependencies only (no dev packages)
composer install --optimize-autoloader --no-dev

# If you need dev packages later, restore with:
# composer install
```

#### 4. Test Production Build Locally
```bash
# Set environment to production temporarily
# Copy .env to .env.backup first
cp .env .env.backup

# Test with production settings
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Phase 2: Prepare Files for Upload

#### 1. Create Deployment Package
```bash
# Create a clean copy excluding unnecessary files
cd /Applications/XAMPP/xamppfiles/htdocs/web-projects/awamarket/

# Option 1: Zip entire project (excluding development files)
zip -r awamarket-deploy.zip awamarket \
  -x "awamarket/node_modules/*" \
  -x "awamarket/.git/*" \
  -x "awamarket/storage/logs/*" \
  -x "awamarket/storage/framework/cache/*" \
  -x "awamarket/storage/framework/sessions/*" \
  -x "awamarket/storage/framework/views/*" \
  -x "awamarket/.env" \
  -x "awamarket/database/database.sqlite"

# Option 2: Use Git to export clean copy (if using Git)
# git archive --format=zip --output=awamarket-deploy.zip HEAD
```

#### 2. Prepare Database Export (if you have data)
```bash
# If using SQLite locally and want to export data:
php artisan migrate:fresh --seed # Clean start

# For existing data, export to SQL
# You'll recreate database on cPanel MySQL
```

---

### Phase 3: cPanel Configuration

#### 1. Upload Files to cPanel

**Method 1: File Manager**
1. Login to cPanel
2. Navigate to **File Manager**
3. Go to your domain's root (usually `public_html` or `www`)
4. Upload `awamarket-deploy.zip`
5. Extract the zip file
6. Move contents of `awamarket` folder to root (or subdirectory)

**Method 2: FTP/SFTP**
```bash
# Use FileZilla or command line
sftp username@yourdomain.com
put awamarket-deploy.zip
```

**Important Directory Structure:**
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← THIS SHOULD BE YOUR DOCUMENT ROOT
│   ├── index.php
│   ├── .htaccess
│   └── storage/     ← Symlink (create later)
├── resources/
├── routes/
├── storage/
├── vendor/
└── .env             ← Create this manually
```

#### 2. Set Document Root

**Critical:** Your domain must point to the `public/` directory, not the Laravel root.

In cPanel:
1. Go to **Domains** or **Addon Domains**
2. Set **Document Root** to: `/home/username/public_html/public`
   - OR if Laravel is in subdirectory: `/home/username/public_html/awamarket/public`

#### 3. Create MySQL Database

1. Go to **MySQL Databases** in cPanel
2. Create a new database: `username_awamarket`
3. Create a database user: `username_awa_user`
4. Set a strong password
5. Add user to database with **ALL PRIVILEGES**
6. Note down:
   - Database name
   - Username
   - Password
   - Host (usually `localhost`)

---

### Phase 4: Configure Environment

#### 1. Create .env File

In cPanel File Manager or via SSH:

```bash
cd /home/username/public_html
nano .env  # or use File Manager editor
```

**Production .env Configuration:**
```env
APP_NAME=AwaMarket
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://awamarket.ng

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# MySQL Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_awamarket
DB_USERNAME=username_awa_user
DB_PASSWORD=your_strong_password_here

# Session Configuration (database recommended for production)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.awamarket.ng

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

CACHE_STORE=database

# Mail Configuration (configure your SMTP settings)
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your_email@awamarket.ng
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@awamarket.ng
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

#### 2. Generate Application Key

```bash
# Via SSH
cd /home/username/public_html
php artisan key:generate

# Or manually generate and add to .env:
# APP_KEY=base64:RandomBase64StringHere
```

#### 3. Set File Permissions

```bash
# Via SSH (recommended)
cd /home/username/public_html

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# If needed, set ownership (replace 'username' with your cPanel user)
chown -R username:username storage
chown -R username:username bootstrap/cache
```

**Via File Manager:**
1. Right-click `storage` folder → Permissions → `755` or `775`
2. Right-click `bootstrap/cache` → Permissions → `755` or `775`

---

### Phase 5: Database Setup

#### 1. Run Migrations

```bash
# Via SSH
cd /home/username/public_html
php artisan migrate --force

# The --force flag is required in production
```

#### 2. Create Admin User

```bash
php artisan tinker --execute="
\$user = new \App\Models\User();
\$user->name = 'Admin';
\$user->email = 'admin@awamarket.ng';
\$user->password = \Hash::make('your_secure_password_here');
\$user->email_verified_at = now();
\$user->save();
"
```

---

### Phase 6: Storage and Symlinks

#### 1. Create Storage Symlink

```bash
# Via SSH
cd /home/username/public_html
php artisan storage:link

# Verify symlink exists
ls -la public/storage
```

**If SSH not available:**
1. Use File Manager to create symlink manually
2. Or create `.htaccess` rewrite rule in `public/` directory

#### 2. Create Required Directories

```bash
mkdir -p public/uploads/products
mkdir -p public/uploads/categories
mkdir -p public/uploads/banners
mkdir -p public/uploads/promotion-banners
mkdir -p storage/app/public/option_images

chmod -R 775 public/uploads
chmod -R 775 storage/app/public
```

---

### Phase 7: Optimization

#### 1. Cache Configuration

```bash
cd /home/username/public_html

# Clear all caches first
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
php artisan optimize
```

#### 2. Queue Worker Setup (Optional but Recommended)

If your cPanel supports cron jobs:

1. Go to **Cron Jobs** in cPanel
2. Add this command to run every minute:
```bash
cd /home/username/public_html && php artisan queue:work --stop-when-empty
```

---

### Phase 8: Security Hardening

#### 1. Protect Sensitive Files

Create/verify `.htaccess` in root directory:

```apache
# /home/username/public_html/.htaccess
<FilesMatch "^\.env">
    Order allow,deny
    Deny from all
</FilesMatch>

<FilesMatch "^composer\.(json|lock)">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### 2. Verify Public .htaccess

Ensure `public/.htaccess` exists with Laravel's default rules:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### 3. Force HTTPS (Recommended)

Add to `public/.htaccess` at the top:

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

### Phase 9: Testing

#### 1. Frontend Tests
- ✅ Homepage loads: `https://awamarket.ng`
- ✅ Shop page works: `https://awamarket.ng/shop-now`
- ✅ Product details load
- ✅ Cart functionality works
- ✅ Checkout with WhatsApp integration

#### 2. Admin Panel Tests
- ✅ Login: `https://awamarket.ng/login`
- ✅ Dashboard loads
- ✅ Products CRUD operations
- ✅ Categories CRUD operations
- ✅ Image uploads work
- ✅ Orders management
- ✅ Banners management

#### 3. Image Upload Tests
- ✅ Product image upload
- ✅ Product option images
- ✅ Category image upload
- ✅ Banner image upload
- ✅ All images display correctly

---

## Troubleshooting Common Issues

### Issue: 500 Internal Server Error

**Solution:**
1. Check file permissions (755 for directories, 644 for files)
2. Verify `.env` file exists and is configured correctly
3. Check `storage/logs/laravel.log` for detailed errors
4. Clear caches: `php artisan config:clear && php artisan cache:clear`

### Issue: Images Not Displaying

**Solution:**
1. Verify storage symlink: `ls -la public/storage`
2. Check directory permissions: `chmod -R 775 storage`
3. Verify `APP_URL` in `.env` matches your domain
4. Check if files exist: `ls -la public/uploads/`

### Issue: Session/Cart Not Working

**Solution:**
1. Run migration for sessions table: `php artisan migrate`
2. Verify `SESSION_DRIVER=database` in `.env`
3. Clear session cache: `php artisan cache:clear`
4. Check `storage/framework/sessions` permissions

### Issue: CSS/JS Not Loading

**Solution:**
1. Verify `public/build/` directory exists
2. Check if `manifest.json` is present: `cat public/build/manifest.json`
3. Rebuild assets: `npm run build` (locally, then re-upload)
4. Clear view cache: `php artisan view:clear`

### Issue: Database Connection Failed

**Solution:**
1. Verify database credentials in `.env`
2. Check if database exists in cPanel → MySQL Databases
3. Verify user has privileges on database
4. Try `DB_HOST=127.0.0.1` instead of `localhost`
5. Check if cPanel allows remote database connections

### Issue: "No application encryption key has been specified"

**Solution:**
```bash
php artisan key:generate
# Or manually add APP_KEY to .env
```

---

## Post-Deployment Monitoring

### 1. Enable Error Logging

In production, errors are logged to `storage/logs/laravel.log`:

```bash
# View recent errors
tail -n 100 storage/logs/laravel.log

# Monitor in real-time (if SSH available)
tail -f storage/logs/laravel.log
```

### 2. Monitor Disk Space

```bash
# Check storage usage
du -sh storage/
du -sh public/uploads/
```

### 3. Regular Backups

**Database Backup (cPanel):**
1. cPanel → Backup Wizard
2. Schedule automatic backups

**Files Backup:**
```bash
# Create compressed backup
tar -czf awamarket-backup-$(date +%Y%m%d).tar.gz \
  /home/username/public_html \
  --exclude='node_modules' \
  --exclude='storage/logs' \
  --exclude='storage/framework/cache'
```

---

## Performance Optimization (Post-Launch)

### 1. Enable OPcache

In cPanel → PHP Settings → Enable OPcache

### 2. Use Content Delivery Network (CDN)

Consider using Cloudflare for:
- Free SSL
- DDoS protection
- Static asset caching
- Performance optimization

### 3. Database Optimization

```bash
# Run periodically
php artisan optimize:clear
php artisan optimize
```

---

## Important Commands Reference

```bash
# Clear all caches
php artisan optimize:clear

# Cache for production
php artisan optimize

# View routes
php artisan route:list

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Generate app key
php artisan key:generate

# Run queue worker (if using queues)
php artisan queue:work

# View logs
tail -f storage/logs/laravel.log
```

---

## Support Contacts

- **Laravel Documentation:** https://laravel.com/docs/12.x
- **cPanel Documentation:** https://docs.cpanel.net/
- **Your Hosting Provider Support:** Contact for server-specific issues

---

## Deployment Status Tracker

- [ ] Console.log statements removed/commented
- [ ] Production assets built (`npm run build`)
- [ ] Files uploaded to cPanel
- [ ] Document root set to `public/` directory
- [ ] MySQL database created
- [ ] `.env` file configured
- [ ] Application key generated
- [ ] File permissions set (755/775)
- [ ] Migrations run successfully
- [ ] Admin user created
- [ ] Storage symlink created
- [ ] Upload directories created
- [ ] Configuration cached
- [ ] Frontend tested
- [ ] Admin panel tested
- [ ] Image uploads tested
- [ ] HTTPS enabled
- [ ] Backups configured

---

**Last Updated:** January 2025
**Laravel Version:** 12.x
**PHP Version Required:** 8.2+
