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
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            SliderSeeder::class,
            PageSeeder::class,
            ProgramSeeder::class,
            GalleryAlbumSeeder::class,
            GallerySeeder::class,
            ScheduleSeeder::class,
            AnnouncementSeeder::class,
            StaffSeeder::class,
            TestimonialSeeder::class,
            DonationSeeder::class,
            DonationTransactionSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
