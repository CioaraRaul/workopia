<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get the test user
        $testUser = User::where('email', 'seed@example.com')->firstOrFail();

        // get all jobs
        $jobIds = Job::pluck('id')->toArray();

        //randomly select jobs to bookmark
        $randomJobIds = array_rand($jobIds, 3); // select 3 random job IDs

        // attach the selected jobs to the user's bookmarks for the test user
        foreach ($randomJobIds as $jobId) {
            $testUser->bookmarkedJobs()->attach($jobIds[$jobId]);
        }

    }
}
