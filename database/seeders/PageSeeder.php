<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>Sejarah Masjid Agung Al Azhar</h2>
<p>Masjid Agung Al Azhar merupakan salah satu masjid terbesar di Jakarta yang telah berdiri sejak tahun 1960-an. Masjid ini tidak hanya menjadi tempat ibadah, tetapi juga pusat pendidikan dan dakwah Islam.</p>

<h3>Visi</h3>
<p>Menjadi pusat kegiatan keagamaan, pendidikan, dan dakwah Islam yang modern dan berperan aktif dalam pembangunan masyarakat.</p>

<h3>Misi</h3>
<ul>
<li>Menyelenggarakan kegiatan ibadah yang berkualitas</li>
<li>Memberikan pendidikan Islam yang komprehensif</li>
<li>Melaksanakan dakwah Islam yang rahmatan lil alamin</li>
<li>Memberdayakan masyarakat melalui program-program sosial</li>
</ul>',
                'template' => 'about',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 1,
                'icon' => 'fas fa-mosque',
            ],
            [
                'title' => 'Sejarah',
                'slug' => 'sejarah',
                'content' => '<p>Masjid Agung Al Azhar didirikan pada tahun 1960 oleh YPI Al Azhar dengan tujuan menyediakan tempat ibadah yang layak bagi umat Islam di Jakarta...</p>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 2,
                'parent_id' => 1,
            ],
            [
                'title' => 'Fasilitas',
                'slug' => 'fasilitas',
                'content' => '<h2>Fasilitas Masjid</h2>
<ul>
<li>Ruang sholat utama kapasitas 5000 jamaah</li>
<li>Ruang wudhu pria dan wanita</li>
<li>Perpustakaan Islam</li>
<li>Aula serbaguna</li>
<li>Ruang kelas untuk kajian</li>
<li>Kantor sekretariat</li>
<li>Parkir luas</li>
</ul>',
                'template' => 'default',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 3,
            ],
            [
                'title' => 'Hubungi Kami',
                'slug' => 'contact',
                'content' => '<h2>Kontak Masjid Agung Al Azhar</h2>
<p>Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau ingin berpartisipasi dalam kegiatan kami.</p>',
                'template' => 'contact',
                'status' => 'published',
                'show_in_menu' => true,
                'menu_order' => 4,
                'icon' => 'fas fa-envelope',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
