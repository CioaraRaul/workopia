@props(['type', 'message'])

@if (session()->has($type))
    <div
        class="{{ $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }} border px-4 py-3 rounded mb-4">
        <p>{{ $message }}</p>
    </div>
@endif

