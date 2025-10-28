# Cart Session Persistence Fix

## Problem
The cart was not persisting data across page navigations due to session management issues:
- Different session cookies were being generated on each API request
- POST `/api/cart/add` succeeded with one session ID
- GET `/api/cart` returned empty data with a different session ID
- Cart appeared empty after navigation even though items were added

## Root Cause
API routes in Laravel 11 don't include the full web middleware stack by default. While `StartSession` middleware was added, the cookie encryption/decryption middleware (`EncryptCookies` and `AddQueuedCookiesToResponse`) were missing, causing session cookies to not be properly handled.

## Solutions Implemented

### 1. Added Required Cookie Middleware to API Routes
**File:** `bootstrap/app.php`

Added the complete middleware stack for session management to API routes:
```php
$middleware->api(prepend: [
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
]);
```

This ensures:
- Cookies are properly encrypted/decrypted
- Session cookies are sent back to the client
- Sessions persist across requests

### 2. Explicit Session Saving in CartController
**File:** `app/Http/Controllers/CartController.php`

Added `Session::save()` calls after all cart modifications to ensure data is immediately persisted:
- After `addToCart()` - Line 65
- After `updateQuantity()` - Line 89
- After `removeItem()` - Line 122
- After `clearCart()` - Line 148

### 3. Added Stateful Domains Configuration
**File:** `config/session.php`

Added stateful domains configuration for local development:
```php
'stateful_domains' => [
    'localhost',
    '127.0.0.1',
    '127.0.0.1:8000',
    'localhost:8000',
],
```

### 4. Exempted API Routes from CSRF Verification
**File:** `bootstrap/app.php`

Added API routes to CSRF exemption list:
```php
$middleware->validateCsrfTokens(except: [
    'admin/products/*',
    'admin/categories/*',
    'api/*', // Exempt all API routes from CSRF
]);
```

## Testing Results

### Before Fix
```bash
# Add to cart
POST /api/cart/add
Response: {"success":true,"cart_count":1}
Set-Cookie: awamarket-session=SessionID_1

# Check cart (different session)
GET /api/cart
Response: {"cart":[],"count":0}
Set-Cookie: awamarket-session=SessionID_2  # ❌ Different session!
```

### After Fix
```bash
# Add to cart
curl -X POST http://127.0.0.1:8000/api/cart/add -c cookies.txt
Response: {"success":true,"cart_count":1}

# Check cart (same session)
curl -X GET http://127.0.0.1:8000/api/cart -b cookies.txt
Response: {
  "cart":[{
    "id":"13_7edabf994b76a00cbc60c95af337db8f",
    "product_id":13,
    "product_name":"Premium Organic Honey",
    "option_name":"weight",
    "price":24.99,
    "quantity":1
  }],
  "count":1,
  "subtotal":"24.99",
  "tax":"2.00",
  "total":"26.99"
}  # ✅ Cart persists!
```

## Additional Notes

### Session Driver
The application uses the `database` session driver (configured in `.env`):
```env
SESSION_DRIVER=database
```

The sessions table migration was already present and applied.

### Cache Clearing
After making these changes, caches were cleared:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Benefits of This Fix

1. **Persistent Cart Data** - Cart items now persist across page navigations
2. **Consistent Session Management** - Same session ID maintained throughout user journey
3. **Proper Cookie Handling** - Encrypted cookies are properly managed
4. **API Route Compatibility** - API routes now work seamlessly with sessions
5. **Production Ready** - Solution works for both development and production environments

## Future Considerations

1. **Guest Cart Migration** - Consider implementing guest cart migration when users log in
2. **Cart Expiration** - Session lifetime is set to 120 minutes (configurable in `.env`)
3. **Redis Session Driver** - For high-traffic production environments, consider switching to Redis:
   ```env
   SESSION_DRIVER=redis
   ```

## Related Files Modified

- `bootstrap/app.php` - Middleware configuration
- `app/Http/Controllers/CartController.php` - Explicit session saving
- `config/session.php` - Stateful domains configuration

## Date Fixed
October 25, 2025
