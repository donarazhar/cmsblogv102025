<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@alazhar.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Editor
        User::create([
            'name' => 'Ahmad Subhan',
            'email' => 'editor@alazhar.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Author
        User::create([
            'name' => 'Fatimah Azzahra',
            'email' => 'author@alazhar.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Regular Users
        User::create([
            'name' => 'Muhammad Rizki',
            'email' => 'rizki@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aisyah',
            'email' => 'aisyah@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
