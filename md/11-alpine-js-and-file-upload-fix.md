# Alpine.js Integration & File Upload Fix

## Alpine.js CDN Setup
- Added Alpine.js via CDN in `layout.blade.php` with the `defer` attribute
- `defer` ensures the script loads after the DOM is parsed

## Alpine.js: Mobile Menu Toggle
- `x-data="{ open: false }"` on the `<header>` defines reactive state
- `@click="open = !open"` on the hamburger button toggles the state
- `x-show="open"` on the mobile nav shows/hides it based on state
- Replaces the vanilla JS `classList.toggle('hidden')` approach with declarative Alpine

## Alpine.js: Auto-dismiss Alerts
- `x-data="{ show: true }"` initializes the alert as visible
- `x-init="setTimeout(() => show = false, {{ $timeout }})"` auto-hides after timeout
- `x-show="show"` controls visibility
- `$timeout` prop defaults to 5000ms, making it configurable per alert

## File Upload Path Fix
- **Problem:** `store('logos', 'public')` saved the path as `logos/filename.png` in the DB, but views prefixed `images/logos/`, causing double path `images/logos/logos/filename.png`
- **Fix:** Upload directly to `public/images/logos/` using `move(public_path('images/logos'), $filename)` and store just the filename
- `uniqid()` prefix prevents filename collisions
- `asset()` helper generates the correct full URL for the image path
- Consistent with factory/seeder logo values which are plain filenames
