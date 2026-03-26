<x-layout>
    <h1>Available jobsd</h1>

    <ul>
        @forelse ($jobs as $job)
            <li> {{ $loop->index }} {{ $job }}
            </li>
        @empty

            <p>No jobs available</p>
        @endforelse ()

    </ul>

</x-layout>

