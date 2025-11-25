<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'about',
                'custom_url' => null,
                'content' => '<p>Halaman ini mengarah ke tentang kami.</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 2,
                'icon' => 'fas fa-mosque',
                'meta_title' => 'Tentang Kami',
                'meta_description' => 'Tentang Masjid Agung Al Azhar',
            ],
            [
                'title' => 'Program',
                'slug' => 'programs',
                'custom_url' => null,
                'content' => '<p>Halaman ini mengarah ke daftar program.</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 3,
                'icon' => 'fas fa-calendar-check',
                'meta_title' => 'Program & Kegiatan',
                'meta_description' => 'Daftar program dan kegiatan Masjid Al Azhar',
            ],
            [
                'title' => 'Berita',
                'slug' => 'blog',
                'custom_url' => null,
                'content' => '<p>Halaman ini mengarah ke daftar berita.</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 4,
                'icon' => 'fas fa-newspaper',
                'meta_title' => 'Berita & Artikel',
                'meta_description' => 'Berita terbaru dari Masjid Al Azhar',
            ],
            [
                'title' => 'Galeri',
                'slug' => 'galery',
                'custom_url' => null,
                'content' => '<p>Halaman ini mengarah ke galeri foto.</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 5,
                'icon' => 'fas fa-images',
                'meta_title' => 'Galeri Foto',
                'meta_description' => 'Galeri dokumentasi kegiatan Masjid Al Azhar',
            ],
            [
                'title' => 'Kontak',
                'slug' => 'contact',
                'custom_url' => null,
                'content' => '<p>Halaman ini mengarah ke halaman kontak.</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 6,
                'icon' => 'fas fa-envelope',
                'meta_title' => 'Hubungi Kami',
                'meta_description' => 'Hubungi Masjid Al Azhar',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}