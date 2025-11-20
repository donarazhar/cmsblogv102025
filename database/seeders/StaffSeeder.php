<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            // Pengurus / Board
            [
                'name' => 'Prof. Dr. H. Abdullah Rahman, MA',
                'position' => 'Ketua Yayasan',
                'department' => 'Yayasan',
                'type' => 'board',
                'biography' => 'Ketua Yayasan Pendidikan Islam Al Azhar sejak 2015. Lulusan Al-Azhar University Kairo dengan pengalaman lebih dari 30 tahun dalam bidang pendidikan Islam.',
                'photo' => 'staff-ketua.jpg',
                'email' => 'ketua@alazhar.or.id',
                'phone' => '081234567001',
                'social_media' => json_encode([
                    'facebook' => 'https://facebook.com/abdullahrahman',
                    'instagram' => 'https://instagram.com/abdullahrahman',
                ]),
                'join_date' => now()->subYears(10)->toDateString(),
                'order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. H. Muhammad Syarif, Lc., MA',
                'position' => 'Direktur Masjid',
                'department' => 'Direktorat',
                'type' => 'board',
                'biography' => 'Direktur Masjid Agung Al Azhar yang bertanggung jawab atas seluruh kegiatan operasional masjid.',
                'photo' => 'staff-direktur.jpg',
                'email' => 'direktur@alazhar.or.id',
                'phone' => '081234567002',
                'join_date' => now()->subYears(8)->toDateString(),
                'order' => 2,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Imam
            [
                'name' => 'Ustadz Dr. Ahmad Dahlan, MA',
                'position' => 'Imam Besar',
                'department' => 'Keimaman',
                'type' => 'imam',
                'biography' => 'Imam Besar Masjid Al Azhar. Lulusan Universitas Al-Azhar Kairo dengan spesialisasi Fiqih dan Ushul Fiqih. Aktif memberikan kajian rutin.',
                'photo' => 'staff-imam1.jpg',
                'email' => 'ahmad.dahlan@alazhar.or.id',
                'phone' => '081234567003',
                'specialization' => 'Fiqih, Ushul Fiqih',
                'social_media' => json_encode([
                    'instagram' => 'https://instagram.com/ustadz.ahmad',
                    'youtube' => 'https://youtube.com/@ustadz.ahmad',
                ]),
                'join_date' => now()->subYears(12)->toDateString(),
                'order' => 3,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ustadz Prof. Dr. Abdullah Syukri, Lc., MA',
                'position' => 'Imam',
                'department' => 'Keimaman',
                'type' => 'imam',
                'biography' => 'Imam masjid dengan keahlian dalam bidang Tafsir Al-Quran. Dosen Universitas Islam Negeri.',
                'photo' => 'staff-imam2.jpg',
                'email' => 'abdullah.syukri@alazhar.or.id',
                'phone' => '081234567004',
                'specialization' => 'Tafsir, Ulumul Quran',
                'join_date' => now()->subYears(10)->toDateString(),
                'order' => 4,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ustadz H. Hamzah Fathoni, S.Ag., MA',
                'position' => 'Imam',
                'department' => 'Keimaman',
                'type' => 'imam',
                'biography' => 'Imam dengan spesialisasi Aqidah dan Akhlak. Aktif dalam kegiatan dakwah.',
                'photo' => 'staff-imam3.jpg',
                'email' => 'hamzah.fathoni@alazhar.or.id',
                'phone' => '081234567005',
                'specialization' => 'Aqidah, Akhlak',
                'join_date' => now()->subYears(8)->toDateString(),
                'order' => 5,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Ustadz/Teacher
            [
                'name' => 'Ustadz Muhammad Ridwan, S.Pd.I',
                'position' => 'Guru Tahfidz',
                'department' => 'Pendidikan',
                'type' => 'teacher',
                'biography' => 'Guru tahfidz Al-Quran dengan pengalaman mengajar lebih dari 15 tahun. Hafal 30 juz.',
                'photo' => 'staff-teacher1.jpg',
                'email' => 'ridwan@alazhar.or.id',
                'phone' => '081234567006',
                'specialization' => 'Tahfidz Al-Quran',
                'join_date' => now()->subYears(15)->toDateString(),
                'order' => 6,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Ustadz Ali Imron, S.Ag',
                'position' => 'Guru Tahsin',
                'department' => 'Pendidikan',
                'type' => 'teacher',
                'biography' => 'Qori internasional dan guru tahsin Al-Quran. Juara MTQ Nasional.',
                'photo' => 'staff-teacher2.jpg',
                'email' => 'ali.imron@alazhar.or.id',
                'phone' => '081234567007',
                'specialization' => 'Tahsin, Qiraah',
                'join_date' => now()->subYears(7)->toDateString(),
                'order' => 7,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Ustadzah Dr. Siti Aminah, MA',
                'position' => 'Pembina Muslimah',
                'department' => 'Pendidikan',
                'type' => 'teacher',
                'biography' => 'Pembina kajian muslimah dan konselor keluarga Islam.',
                'photo' => 'staff-teacher3.jpg',
                'email' => 'siti.aminah@alazhar.or.id',
                'phone' => '081234567008',
                'specialization' => 'Fiqih Wanita, Keluarga Sakinah',
                'join_date' => now()->subYears(6)->toDateString(),
                'order' => 8,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Staff
            [
                'name' => 'Ahmad Fauzi, S.Kom',
                'position' => 'Kepala Tata Usaha',
                'department' => 'Administrasi',
                'type' => 'staff',
                'biography' => 'Mengelola administrasi dan sistem informasi masjid.',
                'photo' => 'staff-admin1.jpg',
                'email' => 'fauzi@alazhar.or.id',
                'phone' => '081234567009',
                'join_date' => now()->subYears(5)->toDateString(),
                'order' => 9,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'Koordinator Humas',
                'department' => 'Humas',
                'type' => 'staff',
                'biography' => 'Menangani hubungan masyarakat dan media.',
                'photo' => 'staff-humas.jpg',
                'email' => 'humas@alazhar.or.id',
                'phone' => '081234567010',
                'join_date' => now()->subYears(4)->toDateString(),
                'order' => 10,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($staff as $person) {
            Staff::create($person);
        }
    }
}
