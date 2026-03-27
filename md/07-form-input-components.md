# Form Input Components

## Creating Reusable Input Components

Instead of repeating the same HTML for every form field, create a reusable Blade component under `components/inputs/`:

```blade
{{-- resources/views/components/inputs/text.blade.php --}}
@props(['id', 'name', 'label' => null, 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div class="mb-4">
    @if($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif
    <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" />
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
```

## Using Props Dynamically

- Replace all hardcoded values with prop variables (`{{ $id }}`, `{{ $name }}`, etc.)
- Use `@error($name)` instead of `@error('hardcoded')` so validation errors work for any field
- Use `old($name, $value)` to repopulate the field on validation failure, with a fallback default
- Use `@if($label)` to conditionally render optional elements when the prop defaults to `null`

## Subdirectory Components

Components inside subdirectories use dot notation:

```blade
{{-- components/inputs/text.blade.php → x-inputs.text --}}
<x-inputs.text id="title" name="title" label="Job Title" placeholder="Software Engineer" />
<x-inputs.text id="salary" name="salary" type="number" label="Annual Salary" placeholder="90000" />
<x-inputs.text id="contact_email" name="contact_email" type="email" label="Contact Email" placeholder="Email" />
```

## Benefits

- One-line usage per field instead of 7+ lines of repeated HTML
- Validation error display is built-in
- `old()` repopulation is built-in
- Consistent styling across all inputs
- Change the look of every input by editing one file
