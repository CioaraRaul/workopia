# 12 - Logo Storage Path Fix

## Key Learnings

### Moving Uploads from `public/` to `storage/`
- **Before:** Logos were uploaded to `public/images/logos/` using `public_path()`
- **After:** Logos are now uploaded to `storage/app/public/logos/` using `storage_path('app/public/logos')`
- Views reference logos via `asset('storage/logos/...')` which resolves through Laravel's storage symlink

### Why Use `storage/` Instead of `public/`
- Laravel's `storage/app/public` directory is the standard place for user-uploaded files
- `php artisan storage:link` creates a symlink from `public/storage` -> `storage/app/public`
- Keeps uploaded files separate from application assets
- Works consistently across deployment environments

### Handling Missing Logos
- Always check if `company_logo` exists before rendering an `<img>` tag
- Without the check, a null logo produces a broken image (`<img src="/storage/logos/">`)
- A fallback placeholder (e.g., first letter of company name) provides better UX

### Key Functions
- `storage_path('app/public/logos')` - absolute path to the storage directory
- `asset('storage/logos/filename.png')` - public URL via the symlink
- `$file->move(destination, filename)` - moves uploaded file to target directory
