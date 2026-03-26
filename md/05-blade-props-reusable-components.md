# Blade Props & Reusable Components

## @props Directive

Use `@props` in anonymous Blade components to define default prop values directly in the template:

```blade
@props([
    'heading' => 'Default Heading',
    'subtitle' => 'Default subtitle text',
    'link' => '/default',
])
```

- No need for a PHP component class when using `@props`
- Props become available as variables (`$heading`, `$subtitle`, etc.)
- Defaults are used when the prop is not passed

## Nesting Components

Components can use other components inside them:

```blade
{{-- bottom-banner.blade.php --}}
<x-button-link :url="$link" :icon="$linkIcon">{{ $linkText }}</x-button-link>
```

- Use `:prop` syntax to pass PHP variables/expressions
- Use `prop` (without colon) for static string values

## ButtonLink Component

Reusable button styled as a link with optional icon:

```blade
@props(['url' => '/', 'icon' => null, 'active' => false, 'mobile' => false, 'block' => false])

<a href="{{ $url }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded ...">
    @if($icon)
        <i class="fa fa-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
```

- `$slot` captures content between opening and closing tags
- Conditional rendering with `@if` for optional elements

## NavLink with Mobile Support

Added `mobile` prop to toggle between desktop and mobile styles:

```blade
@props(['url' => '/', 'active' => false, 'icon' => null, 'mobile' => false])

<a href="{{ $url }}" class="{{ $mobile ? 'block px-4 hover:bg-blue-700' : 'hover:text-yellow-300 px-2' }}">
```

## Layout Conditional Sections

Show components only on specific pages using `request()->is()`:

```blade
@if (request()->is('/'))
    <x-hero />
    <x-top-banner />
@endif
```
