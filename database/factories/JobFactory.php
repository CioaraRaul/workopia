<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Associate the job with a user
            'title' => $this-> faker -> jobTitle(),
            'description' => $this-> faker -> paragraph(2,true),
            'salary' => $this-> faker -> numberBetween(30000, 150000),
            'strings' => implode(', ', $this->faker->words(3)),
            'job_type' => $this-> faker -> randomElement(['full-time', 'part-time', 'contract','temporary', 'internship', 'volunteer', 'on-call']),
            'remote' => $this-> faker -> boolean(),
            'requirements' => $this-> faker -> sentence(3, true),
            'benefits' => $this-> faker -> sentence(2, true),
            'address' => $this-> faker -> streetAddress(),
            'city' => $this-> faker -> city(),
            'state' => $this-> faker -> state(),
            'zipcode' => $this-> faker -> postcode(),
            'contact_email' => $this-> faker -> email(),
            'contact_phone' => $this-> faker -> phoneNumber(),
            'company_name' => $this-> faker -> company(),
            'company_description' => $this-> faker -> paragraph(2,true),
            'company_logo' => $this->faker->randomElement([
                'logo-algorix.png', 'logo-bitwave.png', 'logo-digital-media.png',
                'logo-nextgen.png', 'logo-pink-pig.png', 'logo-quantumcode.png',
                'logo-shield.png', 'logo-sparkle.png', 'logo-tec-solutions.png', 'logo-vencom.png',
            ]),
            'company_website' => $this-> faker -> url(),

        ];
    }
}
