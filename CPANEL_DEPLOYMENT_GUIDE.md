# Safe cPanel Deployment Guide - Authentication Update

## 🎯 Overview
This guide will help you safely update your live cPanel website with the new authentication system without breaking existing functionality.

---

## ⚠️ CRITICAL: Backup First!

### Before ANY Changes:
1. **Backup Database** via cPanel phpMyAdmin
   - Export all tables
   - Save the SQL file locally

2. **Backup Files** via cPanel File Manager
   - Download entire public_html folder
   - Or use FTP to download everything

3. **Test Backup** - Verify you can restore if needed

---

## 📋 What Changed (Summary)

### New Features:
1. ✅ **Admin Authentication** - Login required for `/admin` routes
2. ✅ **Logout Functionality** - Working logout button in admin sidebar
3. ✅ **User Profile Display** - Shows logged-in user info
4. ✅ **Custom Logo** - AwaMarket logo on login page
5. ✅ **Laravel Breeze** - Complete authentication scaffolding

### Files Modified:
- Authentication routes and controllers
- Admin sidebar component
- JavaScript files
- Login/register views
- Middleware configuration

---

## 🚀 Deployment Strategy: Two Approaches

### Option 1: Full Update (Recommended for Small Sites)
**Pros:** Everything stays in sync  
**Cons:** Brief downtime (2-5 minutes)

### Option 2: Incremental Update (Recommended for Live Sites)
**Pros:** Minimal downtime  
**Cons:** More steps, careful coordination needed

---

## 📦 Files & Folders to Update

### 1. **CRITICAL FILES** (Must Update - Authentication Won't Work Without These)

#### A. Routes
```
routes/
  ├── web.php          ← Admin authentication middleware
  ├── auth.php         ← Breeze auth routes (NEW FILE)
  └── api.php          ← No changes needed
```

#### B. Controllers
```
app/Http/Controllers/Auth/
  └── AuthenticatedSessionController.php  ← Updated destroy() method
```

#### C. Middleware Configuration
```
bootstrap/
  └── app.php          ← Authentication redirects configured
```

#### D. Views
```
resources/views/
  ├── auth/
  │   └── login.blade.php              ← Breeze login (NEW)
  ├── components/
  │   ├── admin-sidebar.blade.php      ← Logout button added
  │   └── application-logo.blade.php   ← Custom logo (NEW)
  ├── layouts/
  │   ├── guest.blade.php              ← Auth layout (NEW)
  │   └── navigation.blade.php         ← Logo updated (NEW)
  └── profile/                         ← Profile pages (NEW FOLDER)
```

#### E. JavaScript
```
public/js/
  └── admin-responsive.js  ← Logout button fix
```

---

### 2. **DATABASE MIGRATIONS** (Run These on cPanel)

```bash
php artisan migrate --force
```

This creates:
- `users` table (may already exist)
- `password_reset_tokens` table
- `sessions` table
- Other Breeze tables

**Note:** If tables exist, migrations will skip them safely.

---

### 3. **COMPOSER DEPENDENCIES** (Must Update)

New packages added:
```json
"laravel/breeze": "^2.3"
```

**On cPanel via SSH:**
```bash
composer install --no-dev --optimize-autoloader
```

---

### 4. **NPM BUILD** (If You Modified Frontend)

If you've changed any JS/CSS:
```bash
npm install
npm run build
```

Upload the built files from `public/build/`

---

## 🔧 Step-by-Step Deployment Process

### Phase 1: Preparation (Local)

1. **Export Database Schema**
```bash
php artisan schema:dump
```

2. **Build Assets**
```bash
npm run build
```

3. **Create Deployment Package**
```bash
# Exclude unnecessary files
zip -r awamarket-update.zip \
  app/ \
  bootstrap/ \
  config/ \
  database/ \
  public/ \
  resources/ \
  routes/ \
  composer.json \
  composer.lock \
  package.json \
  -x "*.git*" -x "node_modules/*" -x "vendor/*" -x "storage/*"
```

---

### Phase 2: cPanel Upload

#### Method A: Via File Manager

1. **Login to cPanel**
2. **Open File Manager** → Navigate to `public_html`
3. **Upload ZIP** file
4. **Extract** in the correct directory
5. **Overwrite** when prompted (backup already done!)

#### Method B: Via FTP

1. **Connect via FTP** (FileZilla, Cyberduck, etc.)
2. **Navigate** to your Laravel root directory
3. **Upload Changed Files** (see list below)
4. **Overwrite** existing files

---

### Phase 3: Server-Side Commands

**Connect via SSH** (or use cPanel Terminal):

```bash
# Navigate to your Laravel directory
cd /home/youruser/public_html

# Install/Update Composer dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permissions (if needed)
chmod -R 755 storage bootstrap/cache
```

---

### Phase 4: Create Admin User

**If you don't have an admin user yet:**

```bash
php artisan tinker
```

Then inside tinker:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'your-email@domain.com',
    'password' => bcrypt('your-secure-password')
]);
```

**Or use existing user** - just make sure you know the credentials!

---

### Phase 5: Update .env Configuration

**Check these in your production `.env`:**

```env
# Authentication
APP_ENV=production
APP_DEBUG=false

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Make sure APP_KEY is set
APP_KEY=base64:your-existing-key-here

# Database (verify correct)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## 📂 Quick Update File List (For FTP)

### Minimum Files to Update:

```
✅ MUST UPDATE:
routes/web.php
routes/auth.php (NEW)
bootstrap/app.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
resources/views/components/admin-sidebar.blade.php
resources/views/components/application-logo.blade.php
public/js/admin-responsive.js

✅ NEW FOLDERS (Upload Entire Folders):
resources/views/auth/
resources/views/profile/
resources/views/layouts/ (has updates)
app/Http/Controllers/Auth/ (entire folder)
app/Http/Requests/Auth/ (NEW folder)

✅ COMPOSER:
composer.json
composer.lock
```

---

## 🧪 Testing Checklist

### After Deployment:

1. **Test Homepage**
   - [ ] Visit `https://yourdomain.com`
   - [ ] Verify it loads normally

2. **Test Login**
   - [ ] Visit `https://yourdomain.com/login`
   - [ ] Login with admin credentials
   - [ ] Should redirect to `/admin`

3. **Test Admin Panel**
   - [ ] Dashboard loads
   - [ ] Sidebar shows user info
   - [ ] All menu items work

4. **Test Logout**
   - [ ] Click logout button
   - [ ] Should redirect to homepage
   - [ ] Try accessing `/admin` - should redirect to login

5. **Test Customer Experience**
   - [ ] Shop page works
   - [ ] Products display
   - [ ] Cart functionality
   - [ ] Checkout process

---

## 🚨 Rollback Plan (If Something Goes Wrong)

### Immediate Rollback:

1. **Restore Database**
   - Go to phpMyAdmin
   - Import your backup SQL file

2. **Restore Files**
   - Delete uploaded files
   - Re-upload from your backup

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

---

## 🔍 Common Issues & Solutions

### Issue 1: "419 Page Expired" on Login
**Cause:** CSRF token mismatch  
**Fix:**
```bash
php artisan config:clear
php artisan cache:clear
```

### Issue 2: "Route [login] not defined"
**Cause:** Auth routes not loaded  
**Fix:** Ensure `routes/auth.php` exists and is required in `routes/web.php`

### Issue 3: White Screen / 500 Error
**Cause:** Missing dependencies or permissions  
**Fix:**
```bash
composer install --no-dev
chmod -R 755 storage bootstrap/cache
php artisan cache:clear
```

### Issue 4: Admin Can't Login
**Cause:** No users in database  
**Fix:** Create user via tinker (see Phase 4)

### Issue 5: Assets Not Loading
**Cause:** Build files missing  
**Fix:** Upload `public/build/` folder with all assets

---

## 📊 Deployment Time Estimates

| Task | Time | Downtime? |
|------|------|-----------|
| Backup | 5 min | No |
| Upload Files (FTP) | 5-10 min | No |
| Composer Install | 2-5 min | Yes |
| Run Migrations | 1-2 min | Yes |
| Clear Caches | 1 min | Yes |
| Testing | 5-10 min | No |
| **Total** | **~20-35 min** | **~5-10 min** |

---

## 💡 Pro Tips

1. **Deploy During Low Traffic** - Early morning or late night
2. **Maintenance Mode** - Use `php artisan down` before changes
3. **Monitor Logs** - Check `storage/logs/laravel.log` after deployment
4. **Incremental Testing** - Test each feature after deployment
5. **Keep Backup Handy** - For at least 24 hours after deployment

---

## 📞 Quick Reference Commands

```bash
# Enter maintenance mode
php artisan down --message="Updating authentication system"

# Exit maintenance mode
php artisan up

# Check Laravel version
php artisan --version

# Check routes
php artisan route:list

# Test database connection
php artisan tinker --execute="DB::connection()->getPdo();"

# View logs
tail -50 storage/logs/laravel.log
```

---

## ✅ Deployment Checklist

Print this and check off as you go:

- [ ] Backup database
- [ ] Backup files
- [ ] Test backup locally
- [ ] Build assets (`npm run build`)
- [ ] Upload files to cPanel
- [ ] Run `composer install`
- [ ] Run migrations
- [ ] Update `.env` settings
- [ ] Create admin user (if needed)
- [ ] Clear all caches
- [ ] Optimize for production
- [ ] Test login page
- [ ] Test admin panel
- [ ] Test logout
- [ ] Test existing functionality
- [ ] Monitor for errors
- [ ] Remove old backups (after 24h)

---

**Good luck with your deployment! 🚀**
