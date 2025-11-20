<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        $donations = [
            [
                'campaign_name' => 'Renovasi Masjid Al Azhar 2025',
                'description' => 'Program renovasi dan modernisasi fasilitas masjid untuk kenyamanan jamaah',
                'content' => '<h2>Tujuan Renovasi</h2>
<p>Program renovasi ini bertujuan untuk:</p>
<ul>
<li>Memperluas ruang sholat utama</li>
<li>Menambah fasilitas wudhu</li>
<li>Memasang AC di seluruh ruangan</li>
<li>Memperbaiki sistem sound system</li>
<li>Memperindah landscape masjid</li>
</ul>
<p>Mari bersama-sama berkontribusi untuk kebaikan umat.</p>',
                'image' => 'donation-renovasi.jpg',
                'category' => 'renovation',
                'target_amount' => 5000000000,
                'current_amount' => 2350000000,
                'donor_count' => 450,
                'start_date' => now()->subMonths(2)->toDateString(),
                'end_date' => now()->addMonths(10)->toDateString(),
                'is_urgent' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
                'payment_methods' => json_encode([
                    'bank_transfer' => [
                        'bank' => 'Bank Syariah Indonesia',
                        'account_number' => '1234567890',
                        'account_name' => 'YPI Al Azhar',
                    ],
                    'qris' => true,
                ]),
            ],
            [
                'campaign_name' => 'Zakat Fitrah Ramadhan 1446 H',
                'description' => 'Penyaluran zakat fitrah untuk mustahik di sekitar masjid',
                'content' => '<p>Salurkan zakat fitrah Anda melalui Masjid Al Azhar. Zakat akan disalurkan kepada mustahik yang berhak.</p>
<p><strong>Besaran Zakat:</strong> Rp 50.000/jiwa</p>',
                'image' => 'donation-zakat.jpg',
                'category' => 'zakat',
                'target_amount' => 500000000,
                'current_amount' => 125000000,
                'donor_count' => 2500,
                'start_date' => now()->addMonths(1)->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'is_urgent' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
                'payment_methods' => json_encode([
                    'bank_transfer' => [
                        'bank' => 'Bank Syariah Indonesia',
                        'account_number' => '1234567890',
                        'account_name' => 'YPI Al Azhar - Zakat',
                    ],
                    'qris' => true,
                    'cash' => true,
                ]),
            ],
            [
                'campaign_name' => 'Beasiswa Anak Yatim',
                'description' => 'Program beasiswa pendidikan untuk 100 anak yatim',
                'content' => '<h2>Program Beasiswa</h2>
<p>Program ini memberikan bantuan pendidikan untuk anak yatim dari SD hingga SMA.</p>
<p><strong>Yang akan diberikan:</strong></p>
<ul>
<li>Biaya sekolah bulanan</li>
<li>Seragam dan buku</li>
<li>Uang saku</li>
<li>Bimbingan belajar</li>
</ul>',
                'image' => 'donation-beasiswa.jpg',
                'category' => 'program',
                'target_amount' => 1000000000,
                'current_amount' => 650000000,
                'donor_count' => 320,
                'start_date' => now()->subMonth()->toDateString(),
                'end_date' => now()->addMonths(11)->toDateString(),
                'is_urgent' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
                'payment_methods' => json_encode([
                    'bank_transfer' => [
                        'bank' => 'Bank Syariah Indonesia',
                        'account_number' => '1234567890',
                        'account_name' => 'YPI Al Azhar - Beasiswa',
                    ],
                    'qris' => true,
                ]),
            ],
            [
                'campaign_name' => 'Qurban 1446 H',
                'description' => 'Program penyaluran hewan qurban untuk berbagi dengan dhuafa',
                'content' => '<h2>Paket Qurban</h2>
<ul>
<li>Kambing: Rp 2.500.000</li>
<li>Sapi (1/7): Rp 3.000.000</li>
<li>Sapi (Full): Rp 21.000.000</li>
</ul>
<p>Daging qurban akan disalurkan kepada masyarakat kurang mampu.</p>',
                'image' => 'donation-qurban.jpg',
                'category' => 'qurban',
                'target_amount' => 300000000,
                'current_amount' => 85000000,
                'donor_count' => 65,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(4)->toDateString(),
                'is_urgent' => false,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
                'payment_methods' => json_encode([
                    'bank_transfer' => [
                        'bank' => 'Bank Syariah Indonesia',
                        'account_number' => '1234567890',
                        'account_name' => 'YPI Al Azhar - Qurban',
                    ],
                    'qris' => true,
                    'cash' => true,
                ]),
            ],
            [
                'campaign_name' => 'Infaq Operasional Masjid',
                'description' => 'Infaq untuk operasional harian masjid',
                'content' => '<p>Infaq untuk operasional masjid meliputi:</p>
<ul>
<li>Listrik dan air</li>
<li>Kebersihan</li>
<li>Perawatan fasilitas</li>
<li>Gaji karyawan</li>
<li>Kegiatan dakwah</li>
</ul>',
                'image' => 'donation-infaq.jpg',
                'category' => 'infaq',
                'target_amount' => null,
                'current_amount' => 450000000,
                'donor_count' => 1200,
                'is_urgent' => false,
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
                'payment_methods' => json_encode([
                    'bank_transfer' => [
                        'bank' => 'Bank Syariah Indonesia',
                        'account_number' => '1234567890',
                        'account_name' => 'YPI Al Azhar - Infaq',
                    ],
                    'qris' => true,
                    'cash' => true,
                ]),
            ],
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}
