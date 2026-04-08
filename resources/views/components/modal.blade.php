@props(['title' => 'Modal'])

<div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/50"
        @click="open = false"
    ></div>

    {{-- Modal panel --}}
    <div
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-xl p-6 mx-4"
        @click.stop
    >
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
            <button
                @click="open = false"
                class="text-gray-400 hover:text-gray-600 transition-colors"
                aria-label="Close modal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        {{ $slot }}
    </div>
</div>
