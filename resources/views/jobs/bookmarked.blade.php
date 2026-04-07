<x-layout>
    <h1 class="text-2xl">Saved Jobs</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($bookmarks as $job)
            <x-job-card :job="$job" />
        @empty
            <p>No saved jobs yet</p>
        @endforelse
    </div>
    {{-- pagination links --}}
    {{ $bookmarks->links() }}
</x-layout>

