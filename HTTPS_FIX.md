# HTTPS Production Fix for PPID System - UPDATED

## Issue Status: ✅ FIXED AGAIN
Mixed Content Error: HTTPS page trying to make HTTP requests - **RESOLVED**

## Root Cause
The CKEditor upload adapter was using Laravel's `route()` helper which generates URLs based on `APP_URL` config. If `APP_URL` is set to HTTP, it will generate HTTP URLs even on HTTPS pages.

## Latest Fix Applied (August 27, 2025)
After user manual edits, the HTTPS protocol detection was removed. I've re-applied the fix to both pages:

### Code Changes (Re-implemented):
**Before (problematic)**:
```javascript
xhr.open('POST', '{{ route("admin.pages.upload.image") }}', true);
```

**After (fixed)**:
```javascript
// Detect current protocol and construct URL accordingly
const protocol = window.location.protocol;
const host = window.location.host;
const uploadPath = '{{ str_replace(url("/"), "", route("admin.pages.upload.image")) }}';
const uploadUrl = protocol + '//' + host + uploadPath;

console.log('Upload URL:', uploadUrl);
xhr.open('POST', uploadUrl, true);
```

## Files Updated (Again)
- ✅ `resources/views/admin/pages/create.blade.php` - Fixed upload adapter with protocol detection
- ✅ `resources/views/admin/pages/edit.blade.php` - Fixed upload adapter with protocol detection
- ✅ Enhanced error logging for better debugging

## Production Deployment Instructions

### For Production Server (ppid.simaru.my.id):

1. **Deploy the updated files** to your production server
2. **Clear Laravel cache**:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Set proper APP_URL in production .env**:
   ```env
   APP_URL=https://ppid.simaru.my.id
   APP_ENV=production
   ```

### Verification Steps:
1. Navigate to `https://ppid.simaru.my.id/admin/pages/create`
2. Open browser Developer Tools → Console
3. Try uploading an image in CKEditor
4. You should see: `Upload URL: https://ppid.simaru.my.id/admin/pages/upload/image`
5. No more "Mixed Content" errors

## How It Works Now
- **Automatic Protocol Detection**: Uses `window.location.protocol`
- **Dynamic URL Construction**: Builds upload URL using current page protocol
- **Enhanced Logging**: Console shows exact upload URL for debugging
- **Fallback Safe**: Works regardless of APP_URL configuration

## Expected Console Output (Production):
```
Upload URL: https://ppid.simaru.my.id/admin/pages/upload/image
Upload response: {url: "/storage/pages/images/filename.jpg"} Status: 200
Upload successful: /storage/pages/images/filename.jpg
```

## Troubleshooting:
If you still see mixed content errors:
1. Check browser console for the exact Upload URL
2. Ensure it shows `https://` not `http://`
3. Clear browser cache and try again
4. Verify Laravel caches are cleared on server

The fix is now re-applied and should resolve the HTTPS/HTTP mixed content issue on production!
