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
                'name' => 'Dr. KH. Zahrudin Sultoni, M.A',
                'position' => 'Ketua Takmir MAA',
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
                'name' => 'Drs. H. Tatang Komara, M.A',
                'position' => 'Kepala Kantor Masjid',
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
            ]
        ];

        foreach ($staff as $person) {
            Staff::create($person);
        }
    }
}
