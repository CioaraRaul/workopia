# Alert Component & Flash Messages

## Flash Messages in Layout
- Use `session('success')` and `session('error')` in the layout to display flash messages globally
- Place the alert component above `{{ $slot }}` so it appears at the top of every page

## Alert Blade Component
- Created `x-alert` component with `type` and `message` props
- `session()->has($type)` can check if a specific session key exists inside the component

## Tailwind Dynamic Class Pitfall
- **Never construct Tailwind classes dynamically** like `bg-{{ $color }}-100` — Tailwind's JIT/purge scans for full class strings and won't find dynamically built ones
- Instead, use full static class strings in conditionals:
  ```blade
  {{ $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }}
  ```
- This ensures all classes are visible to Tailwind at build time
