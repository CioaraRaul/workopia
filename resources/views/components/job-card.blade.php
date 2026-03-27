@props(['job'])

<div class="rounded-lg shadow-md bg-white p-4 flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center mb-3">
            <img src="{{ asset('images/logos/' . $job->company_logo) }}" alt="{{ $job->company_name }}"
                class="w-10 h-10 object-contain rounded mr-3">
            <div>
                <h2 class="text-xl font-bold">{{ $job->title }}</h2>
                <p class="text-sm text-gray-500">{{ ucfirst($job->job_type) }}</p>
            </div>
        </div>
        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($job->description, 100) }}</p>

        <div class="bg-gray-100 rounded p-3 text-sm space-y-1">
            <p><strong>Salary:</strong> ${{ number_format($job->salary) }}</p>
            <p>
                <strong>Location:</strong> {{ $job->city }}, {{ $job->state }}
                @if ($job->remote)
                    <span
                        class="inline-block bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded ml-1">Remote</span>
                @else
                    <span
                        class="inline-block bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded ml-1">On-site</span>
                @endif
            </p>
            @if ($job->strings)
                <p><strong>Tags:</strong> {{ ucwords(str_replace(',', ', ', $job->strings)) }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('jobs.show', $job->id) }}"
        class="block mt-4 text-center bg-blue-100 text-blue-800 font-semibold py-2 rounded hover:bg-blue-200 transition">
        Details
    </a>
</div>

