# Textarea, Select, File & Button Components

## Textarea Component

Same pattern as the text input, but uses `<textarea>` with `rows` and `cols` props:

```blade
{{-- resources/views/components/inputs/text-area.blade.php --}}
@props(['id', 'name', 'label' => null, 'value' => '', 'placeholder' => '', 'rows' => 7, 'cols' => 30])

<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif
    <textarea cols="{{ $cols }}" rows="{{ $rows }}" id="{{ $id }}" name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
```

Usage:

```blade
<x-inputs.text-area id="description" name="description" label="Job Description"
    placeholder="We are seeking a skilled developer..." />
```

## Select Component

Uses an `$options` associative array (`value => label`) and loops with `@foreach`:

```blade
{{-- resources/views/components/inputs/select.blade.php --}}
@props(['id', 'name', 'label' => null, 'options' => [], 'value' => ''])

<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif
    <select id="{{ $id }}" name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror">
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
```

### Passing Arrays to Components

Use the `:` prefix to pass PHP arrays/expressions (instead of plain strings):

```blade
<x-inputs.select id="job_type" name="job_type" label="Job Type" :options="[
    'Full-Time' => 'Full-Time',
    'Part-Time' => 'Part-Time',
    'Contract' => 'Contract',
]" />
```

Without `:`, the value is treated as a string literal. With `:`, it's evaluated as PHP.

## File Input Component

Defaults `type` to `file` so it works out of the box:

```blade
{{-- resources/views/components/inputs/file.blade.php --}}
@props(['id', 'name', 'label' => null, 'type' => 'file'])
```

Usage:

```blade
<x-inputs.file id="company_logo" name="company_logo" label="Company Logo" />
```

## Button Component

Lives at `components/button.blade.php` (not in `inputs/` subdirectory), so it's `<x-button>`:

```blade
{{-- resources/views/components/button.blade.php --}}
@props(['type' => 'submit', 'label' => 'Save'])

<button type="{{ $type }}"
    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
    {{ $label }}
</button>
```

Usage:

```blade
<x-button type="submit" label="Save" />
```

## Key Takeaways

- Every form element type (text, textarea, select, file, button) follows the same pattern: props, conditional label, styling, error handling
- Use `:prop` syntax to pass PHP expressions (arrays, booleans) instead of strings
- Components not in a subdirectory use `<x-name>` directly (e.g., `<x-button>`)
- Components in subdirectories use dot notation (e.g., `<x-inputs.select>`)
