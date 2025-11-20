<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryAlbum;
use App\Models\User;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $albums = GalleryAlbum::all();
        $users = User::all();

        // Galeri untuk setiap album
        foreach ($albums as $album) {
            // 5-8 foto per album
            $photoCount = rand(5, 8);

            for ($i = 1; $i <= $photoCount; $i++) {
                Gallery::create([
                    'title' => $album->name . ' - Foto ' . $i,
                    'description' => 'Dokumentasi kegiatan ' . $album->name,
                    'image' => 'gallery-' . $album->id . '-' . $i . '.jpg',
                    'type' => 'image',
                    'album_id' => $album->id,
                    'uploaded_by' => $users->random()->id,
                    'order' => $i,
                    'is_featured' => $i === 1,
                    'is_active' => true,
                ]);
            }
        }

        // Galeri video
        $videos = [
            [
                'title' => 'Khutbah Jumat - Pentingnya Silaturahmi',
                'description' => 'Khutbah Jumat oleh Ustadz Dr. Ahmad Dahlan tentang pentingnya menjaga silaturahmi',
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'uploaded_by' => $users->random()->id,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Kajian Tafsir Surat Al-Kahfi',
                'description' => 'Kajian tafsir Surat Al-Kahfi dengan Ustadz Muhammad Syarif',
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'uploaded_by' => $users->random()->id,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Tutorial Wudhu yang Benar',
                'description' => 'Panduan praktis tata cara wudhu sesuai sunnah',
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'uploaded_by' => $users->random()->id,
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($videos as $video) {
            Gallery::create($video);
        }
    }
}
