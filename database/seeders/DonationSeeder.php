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
                'campaign_name' => 'Renovasi Masjid Al Azhar',
                'slug' => 'renovasi-masjid-al-azhar',
                'description' => 'Mari bersama-sama merenovasi Masjid Al Azhar agar lebih nyaman untuk beribadah',
                'content' => 'Masjid Al Azhar membutuhkan renovasi menyeluruh untuk meningkatkan kenyamanan jamaah dalam beribadah. Dana yang terkumpul akan digunakan untuk memperbaiki atap, lantai, sound system, dan fasilitas wudhu.',
                'category' => 'renovation',
                'target_amount' => 500000000,
                'current_amount' => 125000000,
                'donor_count' => 235,
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
                'is_urgent' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
                'payment_methods' => ['bank_transfer', 'qris', 'cash'],
            ],
            [
                'campaign_name' => 'Infaq Jumat Berkah',
                'slug' => 'infaq-jumat-berkah',
                'description' => 'Infaq rutin setiap hari Jumat untuk operasional masjid dan kegiatan dakwah',
                'content' => 'Program infaq rutin untuk mendukung operasional masjid termasuk listrik, air, kebersihan, dan kegiatan dakwah mingguan.',
                'category' => 'infaq',
                'target_amount' => null,
                'current_amount' => 45000000,
                'donor_count' => 567,
                'start_date' => now()->subMonths(3),
                'end_date' => null,
                'is_urgent' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
                'payment_methods' => ['bank_transfer', 'qris', 'cash'],
            ],
            [
                'campaign_name' => 'Sedekah untuk Yatim dan Dhuafa',
                'slug' => 'sedekah-yatim-dhuafa',
                'description' => 'Bantu anak yatim dan kaum dhuafa di sekitar masjid dengan sedekah Anda',
                'content' => 'Program sedekah untuk membantu anak-anak yatim dan kaum dhuafa di lingkungan masjid. Dana akan disalurkan dalam bentuk sembako, biaya pendidikan, dan bantuan kesehatan.',
                'category' => 'sedekah',
                'target_amount' => 100000000,
                'current_amount' => 67500000,
                'donor_count' => 421,
                'start_date' => now()->subMonth(),
                'end_date' => now()->addMonths(2),
                'is_urgent' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
                'payment_methods' => ['bank_transfer', 'qris', 'cash', 'other'],
            ],
            [
                'campaign_name' => 'Zakat Fitrah 1446 H',
                'slug' => 'zakat-fitrah-1446h',
                'description' => 'Tunaikan zakat fitrah Anda melalui Masjid Al Azhar',
                'content' => 'Pembayaran zakat fitrah untuk Ramadhan 1446 H. Zakat akan disalurkan kepada mustahik yang berhak di sekitar wilayah masjid.',
                'category' => 'zakat',
                'target_amount' => 75000000,
                'current_amount' => 23000000,
                'donor_count' => 189,
                'start_date' => now(),
                'end_date' => now()->addMonths(4),
                'is_urgent' => false,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
                'payment_methods' => ['bank_transfer', 'qris', 'cash'],
            ],
            [
                'campaign_name' => 'Wakaf Tanah untuk Pondok Tahfidz',
                'slug' => 'wakaf-tanah-pondok-tahfidz',
                'description' => 'Wakaf untuk pembangunan pondok tahfidz Al-Quran generasi penghafal Al-Quran',
                'content' => 'Program wakaf tanah seluas 2000 m² untuk pembangunan pondok pesantren tahfidz Al-Quran. Target total pembelian tanah Rp 2 Miliar.',
                'category' => 'wakaf',
                'target_amount' => 2000000000,
                'current_amount' => 456000000,
                'donor_count' => 89,
                'start_date' => now()->subWeeks(2),
                'end_date' => now()->addYear(),
                'is_urgent' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 0,
                'payment_methods' => ['bank_transfer'],
            ],
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}
