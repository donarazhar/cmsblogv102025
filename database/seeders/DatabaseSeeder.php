<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            ProfileSeeder::class,
            ProgramSeeder::class,
            SliderSeeder::class,
            PostSeeder::class,
            DonationSeeder::class,
        ]);
    }
}
