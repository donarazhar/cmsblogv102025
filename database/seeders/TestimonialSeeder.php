<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Dr. Rahmat Hidayat',
                'role' => 'Jamaah Tetap',
                'company' => 'Universitas Indonesia',
                'content' => 'Masjid Al Azhar telah menjadi rumah spiritual saya selama 10 tahun terakhir. Kajian-kajiannya sangat berkualitas dan membuka wawasan keislaman saya. Fasilitasnya juga sangat nyaman untuk beribadah.',
                'photo' => 'testimonial-1.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'role' => 'Peserta Kajian Muslimah',
                'content' => 'Alhamdulillah, kajian muslimah di Al Azhar sangat membantu saya memahami peran sebagai istri dan ibu dalam Islam. Ustadzah-ustadzahnya sangat ramah dan kompeten.',
                'photo' => 'testimonial-2.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'name' => 'Muhammad Fauzan',
                'role' => 'Alumni Tahfidz',
                'company' => 'Mahasiswa',
                'content' => 'Program tahfidz di Al Azhar sangat terstruktur dan menyenangkan. Saya berhasil menghafal 10 juz dalam waktu 2 tahun berkat bimbingan ustadz yang sabar dan metode yang tepat.',
                'photo' => 'testimonial-3.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'name' => 'Ir. Ahmad Zaini',
                'role' => 'Donatur Tetap',
                'company' => 'Pengusaha',
                'content' => 'Saya sangat senang bisa berkontribusi untuk masjid ini. Transparansi pengelolaan donasi sangat baik, dan program-program sosialnya sangat menyentuh hati.',
                'photo' => 'testimonial-4.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => true,
                'order' => 4,
            ],
            [
                'name' => 'Fatimah Azzahra',
                'role' => 'Jamaah',
                'content' => 'Masjid Al Azhar bukan hanya tempat ibadah, tapi juga pusat pembelajaran dan silaturahmi. Suasananya sangat sejuk dan nyaman.',
                'photo' => 'testimonial-5.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
                'order' => 5,
            ],
            [
                'name' => 'Rudi Hartono',
                'role' => 'Peserta Kajian',
                'company' => 'Karyawan Swasta',
                'content' => 'Kajian malam setelah Isya sangat membantu saya untuk tetap terhubung dengan ilmu agama meskipun sibuk bekerja. Materinya praktis dan aplikatif.',
                'photo' => 'testimonial-6.jpg',
                'rating' => 4,
                'status' => 'approved',
                'is_featured' => false,
                'order' => 6,
            ],
            [
                'name' => 'Hj. Aminah Zahra',
                'role' => 'Jamaah Senior',
                'content' => 'Sudah lebih dari 20 tahun saya menjadi jamaah Al Azhar. Perkembangan masjid ini sangat pesat tapi tetap mempertahankan nilai-nilai kebersamaan yang kuat.',
                'photo' => 'testimonial-7.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
                'order' => 7,
            ],
            [
                'name' => 'Andi Wijaya',
                'role' => 'Orang Tua Santri',
                'content' => 'Anak saya sangat senang mengikuti program tahfidz untuk anak. Pengajaran yang menyenangkan membuat anak tidak merasa terbebani.',
                'photo' => 'testimonial-8.jpg',
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
                'order' => 8,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Pending testimonials
        Testimonial::create([
            'name' => 'Budi Setiawan',
            'role' => 'Jamaah Baru',
            'content' => 'Baru pertama kali datang, pelayanannya sangat ramah.',
            'rating' => 4,
            'status' => 'pending',
            'is_featured' => false,
            'order' => 9,
        ]);
    }
}
