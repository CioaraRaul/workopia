<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('job_listings')->truncate();
        DB::table('users')->truncate();
        DB::table('job_user_bookmarks')->truncate();


        $this->call([
            TestUserSeeder::class,
            RandomUserSeeder::class,
            JobSeeder::class,
            RandomJobSeeder::class,
            BookmarkSeeder::class,
        ]);
    }
}
