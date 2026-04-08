<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <section class="md:col-span-3">
            <div class="rounded-lg shadow-md bg-white p-3">
                <div class="flex justify-between items-center">
                    <a class="block p-4 text-blue-700" href="{{ route('jobs.index') }}">
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Back To Listings
                    </a>
                    @can('update', $job)
                        <div class="flex space-x-3 ml-4">
                            <a href="{{ route('jobs.edit', $job->id) }}"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                            <!-- Delete Form -->
                            <form method="POST" action="{{ route('jobs.destroy', $job->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                            <!-- End Delete Form -->
                        </div>
                    @endcan
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        {{ $job->title }}
                    </h2>
                    <p class="text-gray-700 text-lg mt-2">
                        {{ $job->description }}
                    </p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Job Type:</strong> {{ $job->job_type }}
                        </li>
                        <li class="mb-2">
                            <strong>Remote:</strong> {{ $job->remote ? 'Yes' : 'No' }}
                        </li>
                        <li class="mb-2">
                            <strong>Salary:</strong> {{ $job->salary }}
                        </li>
                        <li class="mb-2">
                            <strong>Site Location:</strong> {{ $job->city }}, {{ $job->state }}
                        </li>
                        @if ($job->tags)
                            <li class="mb-2">
                                <strong>Tags:</strong>
                                {{ $job->tags }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="container mx-auto p-4">
                @if ($job->requirements || $job->benefits)
                    <h2 class="text-xl font-semibold mb-4">Job Details</h2>
                    <div class="rounded-lg shadow-md bg-white p-4">
                        <h3 class="text-lg font-semibold mb-2 text-blue-500">
                            Job Requirements
                        </h3>
                        <p>
                            {{ $job->requirements }}
                        </p>
                        <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">
                            Benefits
                        </h3>
                        <p>
                            {{ $job->benefits }}
                        </p>
                    </div>
                @endif
                <div x-cloak x-data="{ open: false }">
                    <button
                        @click="open = true"
                        class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-gray-700 bg-gray-100 hover:bg-gray-200"
                    >
                        Apply Now
                    </button>

                    <x-modal title="Apply For {{ $job->title }}">
                        <form method="POST" action="{{ route('applicants.store', $job->id) }}" enctype="multipart/form-data">
                            @csrf
                            <x-inputs.text id="full_name" name="full_name" label="Full Name" :required="true" />
                            <x-inputs.text id="contact_info" name="contact_info" label="Contact Info" :required="true" />
                            <x-inputs.file id="resume" name="resume" label="Resume" />
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md w-full">
                                Submit Application
                            </button>
                        </form>
                    </x-modal>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <div id="map"></div>
            </div>
        </section>

        <aside class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-xl text-center mb-4 font-bold">Company Info</h3>
            @if ($job->company_logo)
                <img src="{{ asset('storage/logos/' . $job->company_logo) }}" alt="{{ $job->company_name }}"
                    class="w-full rounded-lg mb-4 m-auto" />
            @endif
            <h4 class="text-lg font-bold">{{ $job->company_name }}</h4>
            @if ($job->company_description)
                <p class="text-gray-700 text-sm my-3">
                    {{ $job->company_description }}
                </p>
            @endif
            @if ($job->company_website)
                <a href="{{ $job->company_website }}" target="_blank" class="text-blue-500">Visit Website</a>
            @endif
            @if ($job->contact_phone)
                <p class="text-gray-700 text-sm mt-2">
                    <strong>Phone:</strong> {{ $job->contact_phone }}
                </p>
            @endif
            @if ($job->contact_email)
                <p class="text-gray-700 text-sm">
                    <strong>Email:</strong> {{ $job->contact_email }}
                </p>
            @endif

            {{-- Bookmark button --}}
            @php $isBookmarked = auth()->check() && auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists(); @endphp
            @php $isBookmarked = auth()->check() && auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists(); @endphp
            <form method="POST" action="{{ $isBookmarked ? route('bookmarks.destroy', $job->id) : route('bookmarks.store', $job->id) }}">
                @csrf
                @if ($isBookmarked)
                    @method('DELETE')
                @endif

                <button type="submit"
                    class="{{ $isBookmarked ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center mt-4">
                    <i class="fas fa-bookmark mr-3"></i>
                    {{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark Listing' }}
                </button>
            </form>
        </aside>
    </div>

</x-layout>

