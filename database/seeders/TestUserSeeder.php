<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): User
    {
        $user = User::firstOrCreate(
            ['email' => 'seed@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('testtest'),
            ]
        );

        return $user;
    }
}
