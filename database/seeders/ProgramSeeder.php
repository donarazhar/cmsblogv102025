<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Kajian Fiqih Sehari-hari',
                'description' => 'Kajian fiqih praktis untuk kehidupan sehari-hari dengan Ustadz Dr. Ahmad Dahlan',
                'content' => '<p>Program kajian yang membahas masalah fiqih sehari-hari dengan pendekatan yang mudah dipahami.</p>',
                'type' => 'regular',
                'frequency' => 'weekly',
                'start_time' => '19:30:00',
                'end_time' => '21:00:00',
                'location' => 'Aula Utama',
                'organizer' => 'Divisi Kajian',
                'contact_person' => 'Ustadz Ahmad',
                'contact_phone' => '081234567890',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Tahfidz Quran Anak',
                'description' => 'Program menghafal Al-Quran untuk anak usia 7-12 tahun',
                'content' => '<p>Program tahfidz dengan metode menyenangkan untuk anak-anak.</p>',
                'type' => 'course',
                'frequency' => 'weekly',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'start_time' => '16:00:00',
                'end_time' => '17:30:00',
                'location' => 'Ruang Tahfidz',
                'max_participants' => 30,
                'current_participants' => 18,
                'registration_fee' => 250000,
                'is_registration_open' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Pelatihan Manasik Haji',
                'description' => 'Persiapan dan pelatihan manasik haji untuk calon jamaah haji',
                'type' => 'event',
                'frequency' => 'once',
                'start_date' => now()->addDays(30)->toDateString(),
                'end_date' => now()->addDays(32)->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'location' => 'Halaman Masjid',
                'organizer' => 'Panitia Haji Al Azhar',
                'max_participants' => 100,
                'current_participants' => 65,
                'registration_fee' => 500000,
                'is_registration_open' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Bakti Sosial Ramadhan',
                'description' => 'Program pembagian sembako untuk keluarga dhuafa',
                'type' => 'charity',
                'frequency' => 'once',
                'start_date' => now()->addMonths(2)->toDateString(),
                'location' => 'Wilayah Jakarta Selatan',
                'organizer' => 'Divisi Sosial',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Kelas Bahasa Arab',
                'description' => 'Belajar bahasa Arab untuk pemula',
                'type' => 'course',
                'frequency' => 'weekly',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'start_time' => '18:30:00',
                'end_time' => '20:00:00',
                'location' => 'Ruang Kelas 2',
                'max_participants' => 25,
                'current_participants' => 20,
                'registration_fee' => 300000,
                'is_registration_open' => true,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
