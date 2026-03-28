<?php

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a job listing via the form', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Software Engineer',
        'description' => 'A test job description',
        'salary' => 90000,
        'tags' => 'php,laravel',
        'job_type' => 'Full-Time',
        'remote' => '1',
        'requirements' => 'PHP experience',
        'benefits' => 'Health insurance',
        'company_name' => 'Test Company',
        'company_description' => 'A test company',
        'company_website' => 'https://example.com',
        'contact_phone' => '1234567890',
        'contact_email' => 'test@example.com',
        'address' => '123 Main St',
        'city' => 'Albany',
        'state' => 'NY',
        'zipcode' => '12201',
    ];

    $response = $this->post('/jobs', $formData);

    $response->assertRedirect(route('jobs.index'));

    $this->assertDatabaseHas('job_listings', [
        'title' => 'Test Software Engineer',
        'strings' => 'php,laravel',
        'job_type' => 'full-time',
        'city' => 'Albany',
        'state' => 'NY',
    ]);
});
