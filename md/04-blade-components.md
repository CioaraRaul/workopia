# Blade Components in Laravel

## What We Learned

### Why Switch from `@extends`/`@yield` to Components?
Blade components (`<x-...>`) are the modern approach in Laravel. They feel more like HTML, are easier to read, and support slots, props, and encapsulated logic via a PHP class.

### Creating a Component
Use Artisan to generate both the class and the view:
```bash
php artisan make:component Layout
php artisan make:component Header
```

This creates two files per component:
- **Class**: `app/View/Components/Layout.php` — contains logic, props, and points to the view.
- **View**: `resources/views/components/header.blade.php` — the HTML template.

### Component Class Structure
```php
namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public function render()
    {
        return view('layout');  // points to resources/views/layout.blade.php
    }
}
```
- The `render()` method returns which Blade view to use.
- A component doesn't have to live in `components/` — `Layout` renders `layout.blade.php` from the root views folder.

### Using Components in Blade
Instead of `@extends('layout')` + `@section` / `@yield`, wrap content in the component tag:

**Before (template inheritance):**
```php
@extends('layout')

@section('content')
    <h1>Welcome</h1>
@endsection
```

**After (components):**
```php
<x-layout>
    <h1>Welcome</h1>
</x-layout>
```

- `<x-layout>` looks for a component named `Layout`.
- Everything between `<x-layout>...</x-layout>` becomes the **default slot** (`{{ $slot }}`).

### Slots — Replacing `@yield`
In the layout view, replace `@yield('content')` with `{{ $slot }}`:
```html
<main class="container mx-auto p-4 mt-4">
    {{ $slot }}
</main>
```

For **named slots** (like the page title), use `<x-slot>`:
```php
<x-layout>
    <x-slot name="title">Create Job</x-slot>
    <h1>Create jobs</h1>
</x-layout>
```

In the layout, access it with a fallback using the null coalescing operator:
```html
<title>{{ $title ?? 'Workopia | Find and list jobs' }}</title>
```

- `{{ $slot }}` — the default (unnamed) slot, receives all content not inside a named `<x-slot>`.
- `<x-slot name="title">` — a named slot, accessed as `{{ $title }}` in the component view.
- `??` — PHP null coalescing operator, provides a default when the slot isn't passed.

### Nesting Components — Replacing `@include`
Instead of `@include('partials.navbar')`, use a component tag:

**Before:**
```php
@include('partials.navbar')
```

**After:**
```html
<x-header />
```

- Self-closing `<x-header />` works for components with no slot content.
- The old `partials/navbar.blade.php` was deleted and replaced by `components/header.blade.php` + `app/View/Components/Header.php`.

### Adding Tailwind CSS via Vite
In the layout `<head>`:
```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@vite('resources/css/app.css')
```
- `@vite()` includes assets processed by Vite (Laravel's default bundler).
- This enables Tailwind CSS classes like `bg-gray-100`, `container`, `mx-auto`, etc.

### Useful Blade Helpers in Components
```php
{{ url('/jobs') }}              {{-- Generate full URL --}}
{{ request()->is('jobs') }}     {{-- Check if current path matches (returns bool) --}}
```

These were used in the header for active-link highlighting:
```html
<a href="{{ url('/jobs') }}"
   class="text-white hover:underline py-2 {{ request()->is('jobs') ? 'text-yellow-500 font-bold' : '' }}">
    All Jobs
</a>
```

### File Organization After Migration
```
app/View/Components/
├── Header.php               ← component class
└── Layout.php               ← component class (renders layout.blade.php)

resources/views/
├── layout.blade.php          ← uses {{ $slot }} instead of @yield
├── components/
│   └── header.blade.php      ← replaces partials/navbar.blade.php
├── pages/
│   └── index.blade.php       ← uses <x-layout> instead of @extends
└── jobs/
    ├── index.blade.php
    ├── show.blade.php
    └── create.blade.php
```

### Quick Reference: Old vs New
| Old (Template Inheritance) | New (Components) |
|---|---|
| `@extends('layout')` | `<x-layout>` |
| `@yield('content')` | `{{ $slot }}` |
| `@section('content') ... @endsection` | Content between `<x-layout>...</x-layout>` |
| `@yield('title', 'default')` | `{{ $title ?? 'default' }}` |
| `@section('title') X @endsection` | `<x-slot name="title">X</x-slot>` |
| `@include('partials.navbar')` | `<x-header />` |
