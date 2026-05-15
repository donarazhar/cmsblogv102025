<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Seed program kegiatan Masjid Al Azhar.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Majelis Taklim MAA',
                'description' => 'Majelis taklim rutin Masjid Agung Al Azhar yang mengkaji kitab-kitab klasik dan kontemporer untuk meningkatkan pemahaman keislaman jamaah.',
                'content' => '<h3>Majelis Taklim Masjid Agung Al Azhar</h3><p>Program kajian rutin harian yang membahas berbagai topik keislaman mulai dari fiqih, akidah, akhlak, hingga tafsir Al-Quran. Dibimbing oleh asatidz yang kompeten dan berpengalaman.</p><h4>Jadwal Kajian</h4><ul><li><strong>Ba\'da Subuh</strong> - Tafsir Al-Quran</li><li><strong>Ba\'da Dzuhur</strong> - Fiqih Ibadah</li><li><strong>Ba\'da Maghrib</strong> - Hadits & Siroh Nabawiyah</li></ul>',
                'icon' => 'fas fa-book-quran',
                'type' => 'regular',
                'frequency' => 'daily',
                'start_time' => '05:30:00',
                'end_time' => '07:00:00',
                'location' => 'Ruang Utama Masjid Al Azhar',
                'organizer' => 'DKM Al Azhar',
                'speaker' => 'Ustadz Syamsul Arifin',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Pelaksanaan Shalat Jum\'at',
                'description' => 'Shalat Jumat berjamaah dengan khutbah yang inspiratif dari khatib-khatib pilihan, dilaksanakan setiap hari Jumat di Masjid Agung Al Azhar.',
                'content' => '<h3>Shalat Jum\'at Masjid Agung Al Azhar</h3><p>Pelaksanaan shalat Jumat yang khidmat dengan khatib-khatib pilihan dari kalangan ulama dan dai terkemuka. Kapasitas lebih dari 5.000 jamaah.</p><h4>Jadwal</h4><ul><li>Adzan I: 11:30 WIB</li><li>Khutbah: 12:00 WIB</li><li>Shalat Jumat: 12:30 WIB</li></ul>',
                'icon' => 'fas fa-mosque',
                'type' => 'regular',
                'frequency' => 'weekly',
                'start_time' => '11:30:00',
                'end_time' => '13:00:00',
                'location' => 'Masjid Agung Al Azhar',
                'organizer' => 'DKM Al Azhar',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Konsultasi dan Pengislaman',
                'description' => 'Layanan konsultasi keagamaan dan bimbingan bagi mualaf yang ingin memperdalam ajaran Islam dengan pendampingan ustadz berpengalaman.',
                'content' => '<h3>Konsultasi Keagamaan & Pengislaman</h3><p>Masjid Agung Al Azhar menyediakan layanan konsultasi keagamaan untuk umum dan program pengislaman (konversi) bagi saudara baru yang ingin memeluk Islam.</p><h4>Layanan</h4><ul><li>Konsultasi masalah fiqih dan muamalah</li><li>Bimbingan pra-nikah Islami</li><li>Pendampingan mualaf</li><li>Sertifikat pengislaman resmi</li></ul>',
                'icon' => 'fas fa-hands-helping',
                'type' => 'regular',
                'frequency' => 'weekly',
                'start_time' => '09:00:00',
                'end_time' => '15:00:00',
                'location' => 'Kantor Sekretariat DKM',
                'organizer' => 'Divisi Dakwah DKM',
                'contact_person' => 'Ustadz Abdul Malik',
                'contact_phone' => '021-7397222',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Kegiatan Ramadhan Mubarak',
                'description' => 'Rangkaian kegiatan selama bulan Ramadhan termasuk tadarus, ifthar bersama, tarawih, dan itikaf di 10 malam terakhir.',
                'content' => '<h3>Program Ramadhan Mubarak</h3><p>Serangkaian kegiatan ibadah intensif selama bulan suci Ramadhan untuk memaksimalkan pahala dan mendekatkan diri kepada Allah SWT.</p><h4>Program Unggulan</h4><ul><li><strong>Tadarus Al-Quran</strong> - Khatam 30 juz selama Ramadhan</li><li><strong>Ifthar Bersama</strong> - Buka puasa bersama jamaah setiap hari</li><li><strong>Shalat Tarawih</strong> - 20 rakaat dengan imam hafidz</li><li><strong>Itikaf</strong> - 10 malam terakhir Ramadhan</li><li><strong>Zakat Fitrah</strong> - Penerimaan dan distribusi zakat</li></ul>',
                'icon' => 'fas fa-moon',
                'type' => 'event',
                'frequency' => 'yearly',
                'location' => 'Masjid Agung Al Azhar',
                'organizer' => 'Panitia Ramadhan DKM',
                'max_participants' => 5000,
                'is_featured' => true,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Kursus Bahasa Arab',
                'description' => 'Program pembelajaran bahasa Arab untuk pemula hingga mahir, dengan metode modern dan interaktif agar jamaah bisa memahami Al-Quran.',
                'content' => '<h3>Kursus Bahasa Arab Al Azhar</h3><p>Program kursus bahasa Arab yang terstruktur untuk membantu jamaah memahami Al-Quran dan hadits secara langsung tanpa terjemahan.</p><h4>Level Kursus</h4><ul><li><strong>Level 1 (Pemula)</strong> - Huruf, kosakata dasar, percakapan sederhana</li><li><strong>Level 2 (Menengah)</strong> - Nahwu, shorof, membaca teks</li><li><strong>Level 3 (Mahir)</strong> - Balaghah, tafsir langsung</li></ul><h4>Biaya</h4><p>Rp 500.000 / semester (termasuk buku dan materi)</p>',
                'icon' => 'fas fa-language',
                'type' => 'course',
                'frequency' => 'weekly',
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'location' => 'Ruang Kelas Lantai 2',
                'organizer' => 'Lembaga Pendidikan Al Azhar',
                'speaker' => 'Ustadz Hasan Basri, Lc.',
                'max_participants' => 30,
                'current_participants' => 22,
                'registration_fee' => 500000,
                'is_registration_open' => true,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Program Pemuda / Remaja (YISC)',
                'description' => 'Youth Islamic Study Club - Wadah pembinaan generasi muda muslim melalui kegiatan kajian, diskusi, dan kegiatan sosial yang menarik.',
                'content' => '<h3>YISC - Youth Islamic Study Club</h3><p>Program khusus untuk pemuda dan remaja usia 15-30 tahun. Menggabungkan kajian Islam kontemporer dengan kegiatan yang relevan dengan kehidupan anak muda.</p><h4>Kegiatan</h4><ul><li>Halaqah mingguan (Sabtu sore)</li><li>Diskusi tematik dan sharing session</li><li>Camping dakwah</li><li>Bakti sosial dan volunteer</li><li>Turnamen olahraga antar masjid</li></ul>',
                'icon' => 'fas fa-users',
                'type' => 'regular',
                'frequency' => 'monthly',
                'start_time' => '15:00:00',
                'end_time' => '17:00:00',
                'location' => 'Aula Serbaguna Lt. 2',
                'organizer' => 'YISC Al Azhar',
                'contact_person' => 'Kak Rizky',
                'contact_phone' => '0812-3456-7890',
                'max_participants' => 100,
                'current_participants' => 65,
                'is_registration_open' => true,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Tahsin & Tahfidz Al-Quran',
                'description' => 'Program perbaikan bacaan (tahsin) dan menghafal (tahfidz) Al-Quran dengan metode talaqqi langsung bersama ustadz hafidz.',
                'content' => '<h3>Program Tahsin & Tahfidz</h3><p>Program intensif untuk memperbaiki bacaan Al-Quran sesuai kaidah tajwid dan menghafal Al-Quran dengan bimbingan langsung dari pengajar yang hafidz.</p><h4>Kelas Tersedia</h4><ul><li><strong>Tahsin Pemula</strong> - Makhraj, tajwid dasar (Senin & Rabu)</li><li><strong>Tahsin Lanjutan</strong> - Gharib, waqf & ibtida (Selasa & Kamis)</li><li><strong>Tahfidz</strong> - Setoran & muraja\'ah harian (Setiap hari)</li></ul>',
                'icon' => 'fas fa-book-open',
                'type' => 'course',
                'frequency' => 'daily',
                'start_time' => '06:00:00',
                'end_time' => '07:30:00',
                'location' => 'Ruang Tahfidz Masjid Al Azhar',
                'organizer' => 'Divisi Pendidikan DKM',
                'speaker' => 'Ustadz Muhammad Ridwan, Hafidz',
                'max_participants' => 50,
                'current_participants' => 38,
                'is_featured' => true,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Kajian Keluarga Sakinah',
                'description' => 'Kajian bulanan tentang membangun keluarga sakinah mawaddah warahmah dengan narasumber pakar keluarga Islam.',
                'content' => '<h3>Kajian Keluarga Sakinah</h3><p>Program kajian bulanan yang membahas berbagai aspek kehidupan rumah tangga Islami, mulai dari pra-nikah hingga mendidik anak sesuai sunnah.</p><h4>Topik Pembahasan</h4><ul><li>Memilih pasangan sesuai sunnah</li><li>Hak dan kewajiban suami istri</li><li>Mendidik anak di era digital</li><li>Manajemen keuangan keluarga Islami</li><li>Komunikasi efektif dalam rumah tangga</li></ul>',
                'icon' => 'fas fa-home',
                'type' => 'regular',
                'frequency' => 'monthly',
                'start_time' => '16:00:00',
                'end_time' => '17:30:00',
                'location' => 'Aula Utama Masjid Al Azhar',
                'organizer' => 'Divisi Dakwah DKM',
                'speaker' => 'Ustadzah Dr. Siti Aminah, MA',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($programs as $data) {
            Program::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        $this->command->info('✅ Program Kegiatan berhasil di-seed! (' . count($programs) . ' program)');
    }
}
