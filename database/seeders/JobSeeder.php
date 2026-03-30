<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load job listings from file
        $jobListings = include database_path('seeders/data/job_listings.php');

        // get test user id from database

        $testUserId = User::where('email', 'test@example.com')->value('id');

        // Get all other user ids from user model
        $userIds = User::where('email', '!=', 'test@example.com')->pluck('id')->toArray();

        foreach ($jobListings as $index => &$listing) {
            if($index < 2) {
                // Assign test user id to first 2 listings
                $listing['user_id'] = $testUserId;
            } else {
                // Assign random user id to remaining listings
                $listing['user_id'] = $userIds[array_rand($userIds)];
            }

            // Add timestamps
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }
    }
}
