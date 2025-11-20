<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

class GalleryAlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'name' => 'Perayaan Idul Fitri 1445 H',
                'description' => 'Dokumentasi perayaan Idul Fitri bersama jamaah Masjid Al Azhar',
                'cover_image' => 'album-idul-fitri.jpg',
                'event_date' => now()->subMonths(3)->toDateString(),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pelatihan Manasik Haji 2024',
                'description' => 'Kegiatan pelatihan manasik haji untuk calon jamaah haji tahun 2024',
                'cover_image' => 'album-manasik.jpg',
                'event_date' => now()->subMonths(2)->toDateString(),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bakti Sosial Ramadhan 1445 H',
                'description' => 'Pembagian 1000 paket sembako untuk masyarakat kurang mampu',
                'cover_image' => 'album-baksos.jpg',
                'event_date' => now()->subMonths(4)->toDateString(),
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kajian Akbar Nasional',
                'description' => 'Kajian akbar dengan menghadirkan ulama nasional',
                'cover_image' => 'album-kajian.jpg',
                'event_date' => now()->subMonths(1)->toDateString(),
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Kegiatan Tahfidz Anak',
                'description' => 'Dokumentasi kegiatan tahfidz Al-Quran untuk anak-anak',
                'cover_image' => 'album-tahfidz.jpg',
                'event_date' => now()->subWeeks(2)->toDateString(),
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Renovasi Masjid 2024',
                'description' => 'Proses renovasi dan pengembangan fasilitas masjid',
                'cover_image' => 'album-renovasi.jpg',
                'event_date' => now()->subMonths(6)->toDateString(),
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($albums as $album) {
            GalleryAlbum::create($album);
        }
    }
}
