<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Sambutan Ramadan 1446 H di Masjid Agung Al Azhar',
                'excerpt' => 'Persiapan menyambut bulan suci Ramadan dengan berbagai program ibadah dan kajian intensif.',
                'content' => '<p>Alhamdulillah, kita akan segera memasuki bulan Ramadan 1446 H. Masjid Agung Al Azhar telah mempersiapkan berbagai program spesial untuk menyambut bulan penuh berkah ini.</p>

<p>Program-program yang akan dilaksanakan antara lain:</p>
<ul>
<li>Tarawih berjamaah setiap malam</li>
<li>Kajian intensif tafsir Al-Quran</li>
<li>Program tahfidz Quran</li>
<li>Buka puasa bersama setiap Jumat</li>
<li>Pembagian paket sembako untuk dhuafa</li>
</ul>

<p>Mari kita sambut Ramadan dengan penuh sukacita dan tingkatkan ibadah kita di bulan mulia ini.</p>',
                'category_id' => 1,
                'author_id' => 2,
                'status' => 'published',
                'post_type' => 'news',
                'is_featured' => true,
                'published_at' => now()->subDays(1),
                'views_count' => 250,
                'tags' => [1, 4, 7],
            ],
            [
                'title' => 'Pentingnya Sholat Berjamaah dalam Islam',
                'excerpt' => 'Memahami keutamaan dan hikmah sholat berjamaah menurut Al-Quran dan Hadist.',
                'content' => '<h2>Keutamaan Sholat Berjamaah</h2>

<p>Rasulullah SAW bersabda: "Sholat berjamaah lebih utama 27 derajat dibanding sholat sendirian." (HR. Bukhari dan Muslim)</p>

<h3>Hikmah Sholat Berjamaah</h3>
<p>Beberapa hikmah sholat berjamaah antara lain:</p>
<ol>
<li>Mempererat ukhuwah Islamiyah</li>
<li>Melatih kedisiplinan</li>
<li>Menumbuhkan rasa persaudaraan</li>
<li>Memperkuat spiritualitas</li>
</ol>

<p>Mari kita biasakan untuk sholat berjamaah di masjid, khususnya bagi kaum muslimin.</p>',
                'category_id' => 2,
                'author_id' => 3,
                'status' => 'published',
                'post_type' => 'article',
                'is_featured' => true,
                'published_at' => now()->subDays(3),
                'views_count' => 180,
                'tags' => [1, 2, 3],
            ],
            [
                'title' => 'Kajian Rutin Minggu Pagi Kembali Dibuka',
                'excerpt' => 'Pengumuman dibukanya kembali kajian rutin setiap Minggu pagi dengan Ustadz Dr. Ahmad Dahlan.',
                'content' => '<p>Assalamu\'alaikum warahmatullahi wabarakatuh,</p>

<p>Dengan ini kami mengumumkan bahwa kajian rutin Minggu pagi akan kembali dibuka mulai tanggal 15 Januari 2025.</p>

<h3>Detail Kajian:</h3>
<ul>
<li><strong>Tema:</strong> Tafsir Juz Amma</li>
<li><strong>Pemateri:</strong> Ustadz Dr. Ahmad Dahlan, MA</li>
<li><strong>Waktu:</strong> Setiap Minggu, 08.00 - 10.00 WIB</li>
<li><strong>Tempat:</strong> Aula Utama Masjid Al Azhar</li>
<li><strong>Biaya:</strong> Gratis</li>
</ul>

<p>Mari kita ramaikan kajian rutin ini untuk menambah ilmu dan pahala kita.</p>',
                'category_id' => 3,
                'author_id' => 1,
                'status' => 'published',
                'post_type' => 'announcement',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'views_count' => 320,
                'tags' => [2, 7, 11],
            ],
            [
                'title' => 'Sukses Gelar Bakti Sosial untuk 500 Keluarga Dhuafa',
                'excerpt' => 'Program bakti sosial pembagian sembako untuk masyarakat kurang mampu di sekitar masjid.',
                'content' => '<p>Alhamdulillah, program bakti sosial yang diselenggarakan Masjid Agung Al Azhar telah berjalan dengan lancar pada hari Sabtu kemarin.</p>

<p>Dalam acara ini, sebanyak 500 paket sembako berhasil didistribusikan kepada keluarga dhuafa di wilayah Jakarta Selatan.</p>

<h3>Isi Paket Sembako:</h3>
<ul>
<li>Beras 10 kg</li>
<li>Minyak goreng 2 liter</li>
<li>Gula pasir 1 kg</li>
<li>Telur 1 kg</li>
<li>Mie instan 1 dus</li>
<li>Susu kotak 1 dus</li>
</ul>

<p>Terima kasih kepada seluruh donatur dan volunteer yang telah membantu mensukseskan program ini.</p>',
                'category_id' => 4,
                'author_id' => 2,
                'status' => 'published',
                'post_type' => 'event',
                'is_featured' => true,
                'published_at' => now()->subDays(7),
                'views_count' => 420,
                'tags' => [5, 12],
            ],
            [
                'title' => 'Membangun Keluarga Sakinah Mawaddah Warahmah',
                'excerpt' => 'Tips dan panduan membangun keluarga yang harmonis berdasarkan nilai-nilai Islam.',
                'content' => '<h2>Fondasi Keluarga Sakinah</h2>

<p>Keluarga sakinah adalah dambaan setiap muslim. Allah SWT berfirman dalam QS. Ar-Rum: 21 tentang cinta dan kasih sayang dalam keluarga.</p>

<h3>Kunci Keluarga Harmonis:</h3>
<ol>
<li><strong>Komunikasi yang baik</strong> - Saling mendengar dan memahami</li>
<li><strong>Saling menghormati</strong> - Menghargai peran masing-masing</li>
<li><strong>Ibadah bersama</strong> - Sholat berjamaah di rumah</li>
<li><strong>Pendidikan anak</strong> - Mendidik dengan akhlak mulia</li>
<li><strong>Kesabaran</strong> - Menghadapi ujian dengan sabar</li>
</ol>

<p>Semoga kita semua diberi keluarga yang sakinah, mawaddah, warahmah.</p>',
                'category_id' => 5,
                'author_id' => 3,
                'status' => 'published',
                'post_type' => 'article',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'views_count' => 156,
                'tags' => [1, 9, 10],
            ],
        ];

        foreach ($posts as $postData) {
            $tags = $postData['tags'];
            unset($postData['tags']);

            $post = Post::create($postData);
            $post->tags()->attach($tags);
        }

        // Create additional posts
        for ($i = 1; $i <= 15; $i++) {
            $post = Post::create([
                'title' => 'Artikel Contoh ' . $i,
                'excerpt' => 'Ini adalah excerpt artikel contoh ke-' . $i,
                'content' => '<p>Ini adalah konten artikel contoh ke-' . $i . '. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                'category_id' => rand(1, 6),
                'author_id' => rand(1, 3),
                'status' => 'published',
                'post_type' => 'article',
                'published_at' => now()->subDays(rand(1, 30)),
                'views_count' => rand(50, 500),
            ]);

            $post->tags()->attach([rand(1, 6), rand(7, 12)]);
        }
    }
}
