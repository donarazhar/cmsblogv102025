<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Islam', 'slug' => 'islam', 'color' => '#0053C5'],
            ['name' => 'Dakwah', 'slug' => 'dakwah', 'color' => '#10b981'],
            ['name' => 'Sholat', 'slug' => 'sholat', 'color' => '#8b5cf6'],
            ['name' => 'Puasa', 'slug' => 'puasa', 'color' => '#06b6d4'],
            ['name' => 'Zakat', 'slug' => 'zakat', 'color' => '#f59e0b'],
            ['name' => 'Haji', 'slug' => 'haji', 'color' => '#ef4444'],
            ['name' => 'Quran', 'slug' => 'quran', 'color' => '#0053C5'],
            ['name' => 'Hadist', 'slug' => 'hadist', 'color' => '#10b981'],
            ['name' => 'Akhlak', 'slug' => 'akhlak', 'color' => '#8b5cf6'],
            ['name' => 'Keluarga', 'slug' => 'keluarga', 'color' => '#ec4899'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'color' => '#f97316'],
            ['name' => 'Sosial', 'slug' => 'sosial', 'color' => '#14b8a6'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
