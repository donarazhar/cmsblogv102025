<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Jadwal Sholat Harian (recurring)
        $prayers = [
            ['title' => 'Sholat Subuh', 'time' => '04:30:00'],
            ['title' => 'Sholat Dzuhur', 'time' => '12:00:00'],
            ['title' => 'Sholat Ashar', 'time' => '15:15:00'],
            ['title' => 'Sholat Maghrib', 'time' => '18:00:00'],
            ['title' => 'Sholat Isya', 'time' => '19:15:00'],
        ];

        foreach ($prayers as $prayer) {
            Schedule::create([
                'title' => $prayer['title'],
                'type' => 'prayer',
                'start_time' => $prayer['time'],
                'frequency' => 'daily',
                'is_recurring' => true,
                'imam' => 'Imam Tetap',
                'location' => 'Ruang Sholat Utama',
                'color' => '#0053C5',
                'is_active' => true,
            ]);
        }

        // Jadwal Kajian Mingguan
        $weeklyStudies = [
            [
                'title' => 'Kajian Fiqih Sehari-hari',
                'day' => 'monday',
                'start_time' => '19:30:00',
                'end_time' => '21:00:00',
                'speaker' => 'Ustadz Dr. Ahmad Dahlan, MA',
                'description' => 'Kajian fiqih praktis untuk kehidupan sehari-hari',
            ],
            [
                'title' => 'Kajian Tafsir Al-Quran',
                'day' => 'tuesday',
                'start_time' => '19:30:00',
                'end_time' => '21:00:00',
                'speaker' => 'Ustadz Prof. Dr. Abdullah Syukri, Lc., MA',
                'description' => 'Kajian tafsir Juz Amma',
            ],
            [
                'title' => 'Kajian Hadist',
                'day' => 'wednesday',
                'start_time' => '19:30:00',
                'end_time' => '21:00:00',
                'speaker' => 'Ustadz Muhammad Syarif, S.Ag',
                'description' => 'Kajian Riyadhus Shalihin',
            ],
            [
                'title' => 'Kajian Aqidah',
                'day' => 'thursday',
                'start_time' => '19:30:00',
                'end_time' => '21:00:00',
                'speaker' => 'Ustadz Dr. Hamzah Fathoni, MA',
                'description' => 'Memperkuat aqidah Islamiyah',
            ],
            [
                'title' => 'Kajian Keluarga Sakinah',
                'day' => 'friday',
                'start_time' => '16:00:00',
                'end_time' => '17:30:00',
                'speaker' => 'Ustadzah Dr. Siti Aminah, MA',
                'description' => 'Membangun keluarga yang harmonis',
            ],
            [
                'title' => 'Tahsin & Tahfidz Dewasa',
                'day' => 'saturday',
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'speaker' => 'Ustadz Qori Ali Imron',
                'description' => 'Belajar membaca Al-Quran dengan baik',
            ],
            [
                'title' => 'Kajian Minggu Pagi',
                'day' => 'sunday',
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'speaker' => 'Ustadz Dr. Ahmad Dahlan, MA',
                'description' => 'Kajian tematik Islam kontemporer',
            ],
        ];

        foreach ($weeklyStudies as $study) {
            Schedule::create([
                'title' => $study['title'],
                'description' => $study['description'],
                'type' => 'class',
                'day_of_week' => $study['day'],
                'start_time' => $study['start_time'],
                'end_time' => $study['end_time'],
                'speaker' => $study['speaker'],
                'location' => 'Aula Utama',
                'frequency' => 'weekly',
                'is_recurring' => true,
                'color' => '#10b981',
                'is_active' => true,
            ]);
        }

        // Event Khusus
        $events = [
            [
                'title' => 'Peringatan Maulid Nabi Muhammad SAW',
                'description' => 'Peringatan Maulid Nabi dengan kajian dan sholawat',
                'date' => now()->addDays(15)->toDateString(),
                'start_time' => '19:00:00',
                'end_time' => '22:00:00',
                'speaker' => 'Habib Umar bin Hafidz',
                'location' => 'Aula Utama',
                'color' => '#f59e0b',
            ],
            [
                'title' => 'Seminar Parenting Islami',
                'description' => 'Seminar mendidik anak di era digital',
                'date' => now()->addDays(20)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '15:00:00',
                'speaker' => 'Dr. Aisyah Dahlan, M.Psi',
                'location' => 'Aula Serbaguna',
                'color' => '#8b5cf6',
            ],
            [
                'title' => 'Buka Puasa Bersama Anak Yatim',
                'description' => 'Program buka puasa dengan 200 anak yatim',
                'date' => now()->addMonths(2)->toDateString(),
                'start_time' => '17:30:00',
                'end_time' => '19:30:00',
                'location' => 'Halaman Masjid',
                'color' => '#ef4444',
            ],
        ];

        foreach ($events as $event) {
            Schedule::create([
                'title' => $event['title'],
                'description' => $event['description'],
                'type' => 'event',
                'date' => $event['date'],
                'start_time' => $event['start_time'],
                'end_time' => $event['end_time'],
                'speaker' => $event['speaker'] ?? null,
                'location' => $event['location'],
                'frequency' => 'once',
                'is_recurring' => false,
                'color' => $event['color'],
                'is_active' => true,
            ]);
        }
    }
}
