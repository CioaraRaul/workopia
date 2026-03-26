# Blade Templates in Laravel

## What We Learned

### What is Blade?
Blade is Laravel's templating engine. Template files use the `.blade.php` extension and live in `resources/views/`.

### Layouts with `@yield` and `@extends`
Create a master layout that child views can fill in:

**layout.blade.php** (the master):
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Workopia | Find and list jobs')</title>
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
</body>
</html>
```

**pages/index.blade.php** (a child):
```php
@extends('layout')

@section('content')
    <h1>Welcome to workopia</h1>
@endsection
```

- `@yield('name', 'default')` — placeholder in the layout. Second argument is an optional default value.
- `@extends('layout')` — child view declares which layout it uses.
- `@section('name') ... @endsection` — child fills in a `@yield` slot.

### Partials with `@include`
Break reusable pieces into their own files:

```php
@include('partials.navbar')
```

**partials/navbar.blade.php**:
```html
<nav>
    <a href="/">Home</a>
    <a href="/jobs">Jobs</a>
    <a href="/jobs/create">Create Job</a>
</nav>
```
- Dot notation maps to folder structure: `partials.navbar` → `resources/views/partials/navbar.blade.php`.

### Outputting Variables
```php
{{ $job }}
```
- Double curly braces **escape** HTML by default (safe against XSS).
- Use `{!! $html !!}` for unescaped output (be careful).

### Loops with `@forelse`
```php
@forelse ($jobs as $job)
    <li>{{ $loop->index }} {{ $job }}</li>
@empty
    <p>No jobs available</p>
@endforelse
```
- `@forelse` works like `@foreach` but has an `@empty` block for when the array is empty.
- The `$loop` variable is automatically available inside loops:
  - `$loop->index` — zero-based index (0, 1, 2…)
  - `$loop->iteration` — one-based index (1, 2, 3…)
  - `$loop->first` / `$loop->last` — boolean checks
  - `$loop->count` — total items

### CSRF Protection
```html
<form action="/jobs" method="POST">
    @csrf
    <input type="text" name="title" />
    <button type="submit">Submit</button>
</form>
```
- `@csrf` generates a hidden token field that Laravel validates on POST/PUT/DELETE requests.
- Without it, the form submission will fail with a **419** status code.

### View File Organization
```
resources/views/
├── layout.blade.php          ← master layout
├── pages/
│   └── index.blade.php       ← home page
├── partials/
│   └── navbar.blade.php      ← reusable navbar
└── jobs/
    ├── index.blade.php        ← list jobs
    ├── show.blade.php         ← single job
    └── create.blade.php       ← create form
```
- Group views by feature (e.g., `jobs/`) or purpose (e.g., `partials/`).
- Dot notation in code maps to directory separators: `view('jobs.index')` → `jobs/index.blade.php`.
