# Logout & Auth-Based Navigation

## Logout Functionality

### Route
```php
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
```

### Controller Method
The logout method in `LoginController` handles three things:
1. `Auth::logout()` — logs the user out
2. `$request->session()->invalidate()` — invalidates the session
3. `$request->session()->regenerateToken()` — regenerates the CSRF token to prevent session fixation attacks

### Reusable Logout Button Component
Created `<x-logout-button />` with dynamic props:
- `label` — button text, defaults to `"Logout"`
- `mobile` — adds mobile-specific styling when `true`

Uses `@props` directive to define defaults:
```blade
@props(['label' => 'Logout', 'mobile' => false])
```

## Auth-Based Navigation with `@auth` / `@else` / `@endauth`

Blade provides `@auth` and `@guest` directives to conditionally show content based on authentication status:

```blade
@auth
    {{-- Only visible to logged-in users --}}
    <x-nav-link url="/dashboard">Dashboard</x-nav-link>
    <x-logout-button />
@else
    {{-- Only visible to guests --}}
    <x-nav-link url="/login">Login</x-nav-link>
    <x-nav-link url="/register">Register</x-nav-link>
@endauth
```

### Navigation Visibility Rules
- **Always visible**: Home, All Jobs
- **Authenticated users**: Saved Jobs, Dashboard, Create Job, Logout
- **Guests**: Login, Register
