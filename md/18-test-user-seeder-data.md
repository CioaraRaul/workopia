# Test User Seeder & Job Seed Data

## DatabaseSeeder
- Refactored `DatabaseSeeder` to call individual seeders using `$this->call()`
- Seeders run in order: `TestUserSeeder` → `RandomUserSeeder` → `JobSeeder` → `RandomJobSeeder`

## TestUserSeeder
- Uses `firstOrCreate` to avoid duplicate email constraint violations
- Only creates the test user if one with the same email doesn't already exist

## JobSeeder & Seed Data
- Created `database/seeders/data/job_listings.php` with sample job listing data
- `JobSeeder` loads listings from the data file, assigns a random `user_id`, and adds timestamps

## firstOrCreate vs updateOrCreate
- `firstOrCreate`: finds by key or creates — does NOT update existing records
- `updateOrCreate`: finds by key and updates, or creates if not found
- Use `updateOrCreate` when you want to ensure fields are always synced

## Auth Facade in Controller
- Replaced `auth()->user()->id` with `Auth::id()` using the `Illuminate\Support\Facades\Auth` facade
- Avoids Intelephense "undefined method" warnings

## Owner-Only Edit/Delete in Views
- Wrapped Edit and Delete buttons in `@auth` and `@if (auth()->id() === $job->user_id)`
- Only the user who created the job can see the edit/delete buttons
