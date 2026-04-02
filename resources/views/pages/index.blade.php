<x-layout>

    <h1 class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Welcome to workopia</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($jobs as $job)
            <x-job-card :job="$job" />
        @empty

            <p>No jobs available</p>
        @endforelse ()
    </div>

    <a href="{{ route('jobs.index') }}"
        class="block text-center text-xl bg-blue-100 text-blue-800 font-semibold py-2 rounded hover:bg-blue-200 transition">
        <i class="fa fa-arrow-alt-circle-right">
            View all jobs
        </i>
    </a>

    <x-bottom-banner />
</x-layout>

