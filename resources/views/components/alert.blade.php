@props(['type', 'message', 'timeout' => 5000])

@if (session()->has($type))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, {{ $timeout }})" x-show="show"
        class="{{ $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} border px-4 py-3 rounded mb-4">
        <p>{{ $message }}</p>
    </div>
@endif

