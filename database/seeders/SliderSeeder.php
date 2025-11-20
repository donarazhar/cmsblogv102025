<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Selamat Datang di Masjid Agung Al Azhar',
                'subtitle' => 'Pusat Kegiatan Keagamaan dan Dakwah Islam',
                'description' => 'Mari bersama-sama membangun umat yang lebih baik melalui ibadah, ilmu, dan amal sholeh',
                'image' => 'slider-1.jpg',
                'button_text' => 'Lihat Program',
                'button_link' => '/programs',
                'button_text_2' => 'Hubungi Kami',
                'button_link_2' => '/contact',
                'text_position' => 'center',
                'overlay_color' => '#000000',
                'overlay_opacity' => 40,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ramadhan Kareem 1446 H',
                'subtitle' => 'Mari Ramaikan Bulan Penuh Berkah',
                'description' => 'Program spesial Ramadhan: Tarawih, Kajian, Tahfidz, dan Buka Puasa Bersama',
                'image' => 'slider-2.jpg',
                'button_text' => 'Info Lengkap',
                'button_link' => '/ramadhan',
                'text_position' => 'left',
                'overlay_color' => '#0053C5',
                'overlay_opacity' => 50,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Kajian Islam Rutin',
                'subtitle' => 'Tingkatkan Ilmu Agama Anda',
                'description' => 'Kajian rutin setiap hari dengan ustadz-ustadz terbaik',
                'image' => 'slider-3.jpg',
                'button_text' => 'Jadwal Kajian',
                'button_link' => '/schedules',
                'text_position' => 'right',
                'overlay_color' => '#000000',
                'overlay_opacity' => 45,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Salurkan Donasi Anda',
                'subtitle' => 'Berbagi untuk Sesama',
                'description' => 'Infaq, sedekah, dan zakat Anda sangat berarti untuk kegiatan dakwah dan sosial',
                'image' => 'slider-4.jpg',
                'button_text' => 'Donasi Sekarang',
                'button_link' => '/donations',
                'text_position' => 'center',
                'overlay_color' => '#10b981',
                'overlay_opacity' => 40,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
