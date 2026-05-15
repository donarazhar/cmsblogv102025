<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        Slider::truncate();

        $sliders = [
            [
                'title' => 'Masjid Agung Al Azhar',
                'subtitle' => 'Pusat Dakwah & Peradaban Islam',
                'description' => 'Menjadi pusat ibadah, pendidikan, dan dakwah Islam yang menginspirasi umat sejak 1958 di jantung kota Jakarta.',
                'image' => 'assets/img/hero-masjid.jpg',
                'button_text' => 'Tentang Kami',
                'button_link' => '/profil/sejarah',
                'button_text_2' => 'Program Kami',
                'button_link_2' => '/programs',
                'text_position' => 'left',
                'overlay_color' => '#000000',
                'overlay_opacity' => 45,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Kajian Islam Rutin',
                'subtitle' => 'Tingkatkan Ilmu Agama Anda',
                'description' => 'Ikuti kajian rutin bersama para ustadz dan ulama ternama setiap pekan. Jadwal lengkap tersedia untuk jamaah.',
                'image' => 'assets/img/hero-kajian.jpg',
                'button_text' => 'Lihat Jadwal',
                'button_link' => '/schedules',
                'button_text_2' => null,
                'button_link_2' => null,
                'text_position' => 'right',
                'overlay_color' => '#000000',
                'overlay_opacity' => 40,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Salurkan Donasi Anda',
                'subtitle' => 'Berbagi untuk Sesama',
                'description' => 'Bersama kita wujudkan program sosial, pendidikan, dan pembangunan masjid melalui donasi yang amanah dan transparan.',
                'image' => 'assets/img/hero-masjid.jpg',
                'button_text' => 'Donasi Sekarang',
                'button_link' => '/donations',
                'button_text_2' => null,
                'button_link_2' => null,
                'text_position' => 'center',
                'overlay_color' => '#001f4d',
                'overlay_opacity' => 55,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
