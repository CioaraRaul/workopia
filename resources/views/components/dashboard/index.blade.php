<x-layout>
    <div class="bg-white p-8 rounded-lg shadow-md w-full">
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128&rounded=true' }}"
                alt="{{ $user->name }}"
                class="w-16 h-16 rounded-full object-cover">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-gray-600">Welcome back, {{ $user->name }}!</p>
            </div>
        </div>

        @if ($jobs->isEmpty())
            <p class="text-gray-600">You have not posted any jobs yet.</p>
        @else
            <div class="space-y-4">
                @foreach ($jobs as $job)
                    <div class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow-sm">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $job->title }}</h2>
                            <p class="text-gray-600">{{ Str::limit($job->description, 100) }}</p>
                        </div>
                        <div class="flex items-center gap-3 ml-4">
                            <a href="{{ route('jobs.edit', $job->id) }}?from=dashboard"
                                class="text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('jobs.destroy', $job->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this job?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md w-full mt-6">
        <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4">
            @csrf
            @method('PUT')

            <x-inputs.text id="name" name="name" label="Name" value="{{ $user->name }}" />
            <x-inputs.text id="email" name="email" type="email" label="Email" value="{{ $user->email }}" />

            <x-inputs.file id="avatar" name="avatar" label="Avatar" />

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Update
                Profile</button>
        </form>
    </div>
</x-layout>

