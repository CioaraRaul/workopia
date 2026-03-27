@props(['type' => 'submit', 'label' => 'Save'])

<button type="{{ $type }}"
    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
    {{ $label }}
</button>
