# Dashboard, Profile & Avatar

## Dashboard Controller
A dedicated controller for the user dashboard that shows their job listings:
```php
class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->latest()->get();
        return view('components.dashboard.index', compact('user', 'jobs'));
    }
}
```

## Profile Controller with Avatar Upload
Handles updating user profile info including avatar file uploads:
```php
class ProfileController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        // Validate including avatar image rules
        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle avatar upload with old file cleanup
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();
    }
}
```

### Key Points for File Uploads
- Use `Storage::disk('public')` to store and delete files in `storage/app/public/`
- `store('avatars', 'public')` saves to `storage/app/public/avatars/` and returns the relative path
- Always delete the old file before saving the new one to avoid orphaned files
- The form **must** have `enctype="multipart/form-data"` for file uploads to work
- Use `asset('storage/' . $user->avatar)` in Blade to generate the public URL

## UI Avatars (Default Avatar Fallback)
[UI Avatars](https://ui-avatars.com/) generates avatar images from initials — no signup or API key needed.

### Base URL
```
https://ui-avatars.com/api/
```

### Common Parameters
| Parameter    | Description                        | Example           |
|-------------|------------------------------------|--------------------|
| `name`      | Name to generate initials from     | `?name=John+Doe`  |
| `background`| Hex background color (no #)        | `&background=0D8ABC` |
| `color`     | Hex font color (no #)              | `&color=fff`       |
| `size`      | Image size in pixels (16-512)      | `&size=128`        |
| `rounded`   | Circular avatar (true/false)       | `&rounded=true`    |

### Usage in Blade
```blade
<img src="{{ $user->avatar
    ? asset('storage/' . $user->avatar)
    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128&rounded=true' }}"
    class="w-16 h-16 rounded-full object-cover">
```
This shows the uploaded avatar if it exists, otherwise generates one from the user's name.

## Adding Avatar Column to Users Table
Migration to add the avatar column:
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('avatar')->nullable()->after('password');
});
```
Don't forget to add `'avatar'` to the model's `$fillable` (or `#[Fillable]` attribute).

## Routes
```php
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')->middleware('auth');

Route::put('/profile', [ProfileController::class, 'update'])
    ->name('profile.update')->middleware('auth');
```

## Key Takeaways
- **`enctype="multipart/form-data"`** is required on any form with file inputs
- **`Storage::disk('public')->delete()`** removes old files to prevent storage bloat
- **UI Avatars** is a free, no-auth API for generating initial-based default avatars
- **Redirect from context**: use `request()->query('from')` to redirect back to the originating page (e.g., dashboard vs job listing)
