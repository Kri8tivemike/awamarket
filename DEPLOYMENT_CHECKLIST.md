# 🚀 cPanel Deployment Checklist

## ⏱️ Before You Start
**Estimated Time:** 30 minutes  
**Downtime:** 5-10 minutes  
**Best Time:** During low traffic hours

---

## ✅ Pre-Deployment (Do This First!)

- [ ] **1. Backup Database**
  - Go to cPanel → phpMyAdmin
  - Export all tables
  - Save `.sql` file to your computer
  - **File saved to:** `_________________________`

- [ ] **2. Backup Files**
  - Download entire `public_html` folder
  - Or use FTP to download everything
  - **Backup location:** `_________________________`

- [ ] **3. Test Backup** (Important!)
  - Can you open the backup files?
  - Is the SQL file complete?

- [ ] **4. Build Assets Locally**
  ```bash
  npm run build
  ```

- [ ] **5. Note Your Database Credentials**
  - Database name: `_________________________`
  - Username: `_________________________`
  - Password: `_________________________`

---

## 📤 Upload Phase

### Method 1: FTP (Recommended)

- [ ] **Connect to FTP**
  - Host: `_________________________`
  - Port: 21
  - Username: `_________________________`

- [ ] **Upload These Folders** (drag & drop entire folders):
  - [ ] `app/Http/Controllers/Auth/`
  - [ ] `app/Http/Requests/Auth/` ← NEW
  - [ ] `resources/views/auth/` ← NEW
  - [ ] `resources/views/profile/` ← NEW
  - [ ] `resources/views/layouts/`
  - [ ] `resources/views/components/`

- [ ] **Upload These Individual Files**:
  - [ ] `routes/web.php`
  - [ ] `routes/auth.php` ← NEW
  - [ ] `bootstrap/app.php`
  - [ ] `public/js/admin-responsive.js`
  - [ ] `composer.json`
  - [ ] `composer.lock`

### Method 2: ZIP Upload

- [ ] Create ZIP locally (exclude node_modules, vendor, storage)
- [ ] Upload ZIP to cPanel File Manager
- [ ] Extract in correct location
- [ ] Overwrite when prompted

---

## 🖥️ Server Commands Phase

### Step 1: Connect to SSH
- [ ] Open cPanel Terminal (or SSH client)
- [ ] Navigate to Laravel directory:
  ```bash
  cd /home/YOURUSERNAME/public_html
  ```

### Step 2: Install Dependencies
- [ ] Run composer install:
  ```bash
  composer install --no-dev --optimize-autoloader
  ```
  - **Time:** 2-5 minutes ⏱️
  - **Status:** `_________________________`

### Step 3: Run Migrations
- [ ] Run migrations:
  ```bash
  php artisan migrate --force
  ```
  - **Tables created:** `_________________________`
  - **Any errors?:** `_________________________`

### Step 4: Clear Caches
- [ ] Clear all caches:
  ```bash
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  php artisan cache:clear
  ```

### Step 5: Optimize for Production
- [ ] Optimize application:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan optimize
  ```

### Step 6: Set Permissions
- [ ] Fix permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  ```

---

## 👤 User Setup Phase

### Create Admin User (if you don't have one)

- [ ] Open tinker:
  ```bash
  php artisan tinker
  ```

- [ ] Create user:
  ```php
  \App\Models\User::create([
      'name' => 'Admin',
      'email' => 'your-email@domain.com',
      'password' => bcrypt('your-secure-password')
  ]);
  ```

- [ ] Exit tinker: `exit`

### OR Use Existing User
- [ ] I already have a user
- [ ] Email: `_________________________`
- [ ] Password: `_________________________`

---

## ⚙️ Configuration Check

- [ ] **Check `.env` file** (via cPanel File Manager):
  - [ ] `APP_ENV=production`
  - [ ] `APP_DEBUG=false`
  - [ ] `SESSION_DRIVER=file`
  - [ ] `SESSION_LIFETIME=120`
  - [ ] `APP_KEY=` (should already be set)
  - [ ] Database credentials correct

---

## 🧪 Testing Phase

### Test 1: Homepage
- [ ] Visit: `https://yourdomain.com`
- [ ] Does it load? ✅ / ❌
- [ ] Any errors? `_________________________`

### Test 2: Login Page
- [ ] Visit: `https://yourdomain.com/login`
- [ ] Does it load? ✅ / ❌
- [ ] Logo showing correctly? ✅ / ❌
- [ ] Any errors? `_________________________`

### Test 3: Login Functionality
- [ ] Enter credentials
- [ ] Click "Log in"
- [ ] Redirects to `/admin`? ✅ / ❌
- [ ] Any errors? `_________________________`

### Test 4: Admin Panel
- [ ] Dashboard loads? ✅ / ❌
- [ ] User info shows in sidebar? ✅ / ❌
- [ ] Name: `_________________________`
- [ ] Email: `_________________________`
- [ ] Products page works? ✅ / ❌
- [ ] Categories page works? ✅ / ❌
- [ ] Orders page works? ✅ / ❌

### Test 5: Logout
- [ ] Click "Logout" button in sidebar
- [ ] Redirects to homepage? ✅ / ❌
- [ ] Try accessing `/admin` again
- [ ] Redirects to login? ✅ / ❌

### Test 6: Customer Experience
- [ ] Shop page loads? ✅ / ❌
- [ ] Products display? ✅ / ❌
- [ ] Can add to cart? ✅ / ❌
- [ ] Checkout works? ✅ / ❌

---

## 🎉 Post-Deployment

- [ ] **Monitor for 30 minutes**
  - Check for errors in logs
  - Watch for customer issues

- [ ] **Check Logs**
  ```bash
  tail -50 storage/logs/laravel.log
  ```
  - Any errors? `_________________________`

- [ ] **Announce Success**
  - Update team
  - Document any issues encountered

- [ ] **Keep Backup Safe**
  - Don't delete backup for 24 hours
  - Test backup restore process

---

## 🚨 Emergency Rollback (If Needed)

### If Something Breaks:

1. **Restore Database**
   - [ ] Go to phpMyAdmin
   - [ ] Import backup SQL file
   - [ ] Verify data restored

2. **Restore Files**
   - [ ] Delete uploaded files via FTP
   - [ ] Re-upload from backup
   - [ ] Verify files restored

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Test Site**
   - [ ] Homepage works?
   - [ ] Admin panel accessible?

---

## 📝 Notes Section

### Issues Encountered:
```
_________________________________________________________________

_________________________________________________________________

_________________________________________________________________
```

### Solutions Applied:
```
_________________________________________________________________

_________________________________________________________________

_________________________________________________________________
```

### Deployment Time:
- Start time: `___________`
- End time: `___________`
- Total time: `___________`
- Actual downtime: `___________`

---

## ✅ Deployment Complete!

- [ ] All tests passed
- [ ] No errors in logs
- [ ] Backup safely stored
- [ ] Documentation updated
- [ ] Team notified

**Deployed by:** `_________________________`  
**Date:** `_________________________`  
**Version:** Auth Update v1.0

---

**🎊 Congratulations! Your site is now live with the new authentication system!**
