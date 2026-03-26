    @props([
    'heading' => 'Looking to hire?',
    'subtitle' => 'Post your job listing now and find the perfect candidate.',
    'link' => 'create-job.html',
    'linkText' => 'Create Job',
    'linkIcon' => 'edit',
])

<section class="container mx-auto my-6">
        <div class="bg-blue-800 text-white rounded p-4 flex items-center justify-between flex-col md:flex-row gap-4">
            <div>
                <h2 class="text-xl font-semibold">{{ $heading }}</h2>
                <p class="text-gray-200 text-lg mt-2">
                    {{ $subtitle }}
                </p>
            </div>
            <x-button-link :url="$link" :icon="$linkIcon">{{ $linkText }}</x-button-link>
        </div>
    </section>

