<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => 'Berita terkini seputar Masjid Al Azhar',
                'icon' => 'fas fa-newspaper',
                'color' => '#0053C5',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kajian',
                'slug' => 'kajian',
                'description' => 'Artikel kajian keislaman',
                'icon' => 'fas fa-book-open',
                'color' => '#10b981',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari pengurus masjid',
                'icon' => 'fas fa-bullhorn',
                'color' => '#f59e0b',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Liputan kegiatan masjid',
                'icon' => 'fas fa-calendar-alt',
                'color' => '#8b5cf6',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Opini',
                'slug' => 'opini',
                'description' => 'Opini dan pandangan keislaman',
                'icon' => 'fas fa-comment-dots',
                'color' => '#ef4444',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Ramadan',
                'slug' => 'ramadan',
                'description' => 'Konten spesial bulan Ramadan',
                'icon' => 'fas fa-moon',
                'color' => '#06b6d4',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Sub categories
        Category::create([
            'name' => 'Kajian Fiqih',
            'slug' => 'kajian-fiqih',
            'description' => 'Kajian ilmu fiqih',
            'icon' => 'fas fa-gavel',
            'color' => '#10b981',
            'parent_id' => 2,
            'order' => 1,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Kajian Tafsir',
            'slug' => 'kajian-tafsir',
            'description' => 'Kajian tafsir Al-Quran',
            'icon' => 'fas fa-book-quran',
            'color' => '#10b981',
            'parent_id' => 2,
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
