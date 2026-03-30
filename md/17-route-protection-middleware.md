# Route Protection with Middleware

## Middleware Groups in Routes

Instead of using `Route::resource()`, define routes explicitly and group them by access level using middleware:

```php
// Public routes — anyone can access
Route::get('/jobs', [JobController::class, 'index']);

// Guest only — redirects to home if already logged in
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'register']);
});

// Auth only — redirects to login if not authenticated
Route::middleware('auth')->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::get('/dashboard', fn() => 'Dashboard');
});
```

## Route Order Matters with Wildcards

Literal routes **must** come before wildcard routes at the same path level. Otherwise, Laravel matches the literal string as the wildcard parameter:

```php
// Correct — /jobs/create and /jobs/saved match first
Route::get('/jobs/create', ...);
Route::get('/jobs/saved', ...);
Route::get('/jobs/{job}', ...);   // {job} only matches actual IDs

// Wrong — /jobs/{job} catches "create" and "saved" as IDs
Route::get('/jobs/{job}', ...);
Route::get('/jobs/create', ...);  // never reached
```

This caused `invalid input syntax for type bigint: "create"` because Laravel passed the string "create" as a job ID to the database query.

## Conditional Blade Attributes with `@auth`

You can use `@auth` / `@endauth` directives directly inside HTML attributes to conditionally add behavior:

```blade
<form method="POST" action="{{ route('jobs.destroy', $job->id) }}"
    @auth onsubmit="return confirm('Are you sure?')" @endauth>
```

- **Logged in**: the confirm dialog appears before deleting
- **Guest**: the form submits directly, and the `auth` middleware redirects to login

## Built-in Middleware

- `auth` — requires authentication, redirects to the `login` named route if not authenticated
- `guest` — requires the user is NOT authenticated, redirects to home if they are
