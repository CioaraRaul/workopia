<x-layout>
    <x-slot name='title'> Edit Job </x-slot>
    <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
        <h2 class="text-4xl text-center font-bold mb-4">
            Edit Job Listing
        </h2>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('jobs.update', $job->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>

            <x-inputs.text id="title" name="title" label="Job Title" placeholder="Software Engineer" :value="$job->title" />

            <x-inputs.text-area id="description" name="description" label="Job Description"
                placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..." :value="$job->description" />

            <x-inputs.text id="salary" name="salary" type="number" label="Annual Salary" placeholder="90000" :value="$job->salary" />

            <x-inputs.text-area id="requirements" name="requirements" label="Requirements"
                placeholder="Bachelor's degree in Computer Science" :value="$job->requirements" />

            <x-inputs.text-area id="benefits" name="benefits" label="Benefits"
                placeholder="Health insurance, 401k, paid time off" :value="$job->benefits" />

            <x-inputs.text id="tags" name="tags" label="Tags (comma-separated)"
                placeholder="development,coding,java,python" :value="$job->strings" />

            <x-inputs.select id="job_type" name="job_type" label="Job Type" :options="[
                'Full-Time' => 'Full-Time',
                'Part-Time' => 'Part-Time',
                'Contract' => 'Contract',
                'Temporary' => 'Temporary',
                'Internship' => 'Internship',
                'Volunteer' => 'Volunteer',
                'On-Call' => 'On-Call',
            ]" :value="ucfirst($job->job_type)" />

            <x-inputs.select id="remote" name="remote" label="Remote" :options="[
                '0' => 'No',
                '1' => 'Yes',
            ]" :value="(string) $job->remote" />

            <x-inputs.text id="address" name="address" label="Address" placeholder="123 Main St" :value="$job->address" />

            <x-inputs.text id="city" name="city" label="City" placeholder="Albany" :value="$job->city" />

            <x-inputs.text id="state" name="state" label="State" placeholder="NY" :value="$job->state" />

            <x-inputs.text id="zipcode" name="zipcode" label="ZIP Code" placeholder="12201" :value="$job->zipcode" />

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info
            </h2>

            <x-inputs.text id="company_name" name="company_name" label="Company Name" placeholder="Company name" :value="$job->company_name" />

            <x-inputs.text-area id="company_description" name="company_description" label="Company Description"
                placeholder="Company Description" :value="$job->company_description" />

            <x-inputs.text id="company_website" name="company_website" label="Company Website"
                placeholder="Enter website" type="url" :value="$job->company_website" />

            <x-inputs.text id="contact_phone" name="contact_phone" label="Contact Phone" placeholder="Enter phone" :value="$job->contact_phone" />

            <x-inputs.text id="contact_email" name="contact_email" type="email" label="Contact Email"
                placeholder="Email where you want to receive applications" :value="$job->contact_email" />

            @if($job->company_logo)
                <div class="mb-4">
                    <label class="block text-gray-700">Current Logo</label>
                    <img src="{{ asset('storage/logos/' . $job->company_logo) }}" alt="Company Logo" class="w-32 h-32 object-contain mt-2">
                </div>
            @endif

            <x-inputs.file id="company_logo" name="company_logo" label="Company Logo" />

            <x-button type="submit" label="Update" />
        </form>
    </div>
</x-layout>
