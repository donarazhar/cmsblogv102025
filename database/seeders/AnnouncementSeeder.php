<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $announcements = [
            [
                'title' => 'Perubahan Jadwal Sholat Jumat',
                'content' => 'Mulai tanggal 1 Februari 2025, sholat Jumat akan dilaksanakan pada pukul 12.30 WIB. Mohon perhatiannya.',
                'type' => 'warning',
                'priority' => 'high',
                'icon' => 'fas fa-exclamation-triangle',
                'show_on_homepage' => true,
                'show_popup' => true,
                'is_active' => true,
                'order' => 1,
                'created_by' => $user->id,
            ],
            [
                'title' => 'Pendaftaran Kelas Tahfidz Dibuka',
                'content' => 'Pendaftaran kelas tahfidz Al-Quran untuk anak usia 7-12 tahun telah dibuka. Kuota terbatas hanya 30 peserta. Daftar sekarang!',
                'type' => 'success',
                'priority' => 'medium',
                'icon' => 'fas fa-book-quran',
                'link' => '/programs',
                'link_text' => 'Daftar Sekarang',
                'show_on_homepage' => true,
                'show_popup' => false,
                'is_active' => true,
                'order' => 2,
                'created_by' => $user->id,
            ],
            [
                'title' => 'Renovasi Area Parkir',
                'content' => 'Area parkir sebelah timur masjid sedang dalam proses renovasi. Mohon gunakan area parkir sebelah barat. Terima kasih atas pengertiannya.',
                'type' => 'info',
                'priority' => 'medium',
                'icon' => 'fas fa-hard-hat',
                'show_on_homepage' => true,
                'show_popup' => false,
                'is_active' => true,
                'order' => 3,
                'created_by' => $user->id,
            ],
            [
                'title' => 'Kajian Spesial Ramadhan',
                'content' => 'Alhamdulillah, akan ada kajian spesial Ramadhan setiap setelah tarawih dengan tema "Meraih Keberkahan Ramadhan". Jangan lewatkan!',
                'type' => 'success',
                'priority' => 'high',
                'icon' => 'fas fa-moon',
                'link' => '/schedules',
                'link_text' => 'Lihat Jadwal',
                'start_date' => now()->toDateTimeString(),
                'end_date' => now()->addMonths(2)->toDateTimeString(),
                'show_on_homepage' => true,
                'show_popup' => true,
                'is_active' => true,
                'order' => 4,
                'created_by' => $user->id,
            ],
            [
                'title' => 'Penyaluran Zakat Fitrah',
                'content' => 'Panitia zakat masjid telah siap menerima zakat fitrah mulai H-10 Ramadhan. Zakat dapat disalurkan melalui panitia atau transfer bank.',
                'type' => 'info',
                'priority' => 'urgent',
                'icon' => 'fas fa-hand-holding-heart',
                'link' => '/donations',
                'link_text' => 'Info Lengkap',
                'start_date' => now()->toDateTimeString(),
                'end_date' => now()->addMonths(3)->toDateTimeString(),
                'show_on_homepage' => true,
                'show_popup' => false,
                'is_active' => true,
                'order' => 5,
                'created_by' => $user->id,
            ],
            [
                'title' => 'Protokol Kesehatan Tetap Diterapkan',
                'content' => 'Himbauan untuk tetap menjaga protokol kesehatan selama beraktivitas di masjid. Mari jaga kebersihan dan kesehatan bersama.',
                'type' => 'warning',
                'priority' => 'low',
                'icon' => 'fas fa-shield-virus',
                'show_on_homepage' => false,
                'show_popup' => false,
                'is_active' => true,
                'order' => 6,
                'created_by' => $user->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
