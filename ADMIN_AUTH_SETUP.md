# Admin Authentication Setup Guide

## ✅ Changes Made

### 1. Added Authentication Middleware
- All `/admin/*` routes now require authentication via `middleware(['auth'])`
- Unauthenticated users will be redirected to `/login`

### 2. Installed Laravel Breeze
- Provides complete authentication scaffolding
- Login, registration, password reset functionality
- Authentication views using Blade templates

### 3. Created Admin User
- **Email:** `admin@awamarket.com`
- **Password:** `admin123`

---

## 🚀 Deployment to cPanel

### Step 1: Upload Files
1. Upload **ALL** files to your cPanel hosting
2. Make sure these directories are writable (chmod 755 or 775):
   - `storage/`
   - `bootstrap/cache/`

### Step 2: Database & Migrations
```bash
php artisan migrate --force
```

### Step 3: Create Admin User on Production
Run this command via SSH or cPanel Terminal:

```bash
php artisan tinker --execute="\App\Models\User::create(['name' => 'Admin', 'email' => 'your-email@domain.com', 'password' => bcrypt('your-secure-password')]);"
```

**IMPORTANT:** Change the email and password to your actual credentials!

### Step 4: Update .env File
Make sure your production `.env` has:

```env
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Step 5: Clear Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔐 How It Works

### Before (Insecure)
```
http://yourdomain.com/admin → ❌ Direct access to admin panel
```

### After (Secure)
```
http://yourdomain.com/admin → 🔒 Redirects to /login
After login → ✅ Access to admin panel
```

---

## 📋 Testing Locally

1. Visit `http://localhost:8000/admin`
2. You should be redirected to `http://localhost:8000/login`
3. Login with:
   - **Email:** `admin@awamarket.com`
   - **Password:** `admin123`
4. After successful login, you'll be redirected to `/admin/dashboard`

---

## 🔑 Creating Additional Admin Users

### Via Tinker (Recommended)
```bash
php artisan tinker
```

Then inside tinker:
```php
\App\Models\User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password123')
]);
```

### Via Registration Page
- Visit `/register` to create new users
- **Note:** You may want to disable public registration in production

---

## 🛡️ Security Best Practices

### 1. Disable Public Registration (Production Only)
Edit `routes/auth.php` and remove/comment out:
```php
// Route::get('register', [RegisteredUserController::class, 'create'])
//     ->name('register');
// Route::post('register', [RegisteredUserController::class, 'store']);
```

### 2. Strong Passwords
- Use minimum 12 characters
- Include uppercase, lowercase, numbers, and symbols

### 3. Change Default Admin Credentials
After first login, create a new admin user with a secure email/password and delete the default one.

### 4. Add Admin Role (Optional - Advanced)
For better security, add an `is_admin` column to users table:

```bash
php artisan make:migration add_is_admin_to_users_table
```

In the migration:
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_admin')->default(false);
    });
}
```

Then update middleware to check `is_admin`:
```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ...
});
```

---

## 🐞 Troubleshooting

### Issue: "Session store not set on request"
**Solution:** Make sure `SESSION_DRIVER=file` in `.env` and run:
```bash
php artisan config:clear
```

### Issue: "419 Page Expired" on Login
**Solution:** Clear browser cache and cookies, or run:
```bash
php artisan cache:clear
php artisan config:clear
```

### Issue: "Route [dashboard] not defined" after login
**Solution:** Already fixed! The login now redirects to `/admin` (admin.dashboard route) instead of the non-existent `/dashboard` route.

### Issue: Redirects to wrong URL after login
**Solution:** Already configured! Authenticated users are automatically redirected to `/admin`.

---

## 📞 Support

If you encounter issues after deployment:
1. Check `.env` configuration
2. Verify database connection
3. Check file permissions (storage & bootstrap/cache)
4. Review Laravel logs in `storage/logs/laravel.log`
