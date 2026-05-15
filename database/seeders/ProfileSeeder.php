<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Seed konten profil Tentang Kami:
     * - Sejarah Masjid
     * - Visi & Misi
     * - Struktur Organisasi
     * - Fasilitas
     */
    public function run(): void
    {
        $this->seedSejarah();
        $this->seedVisiMisi();
        $this->seedStrukturOrganisasi();
        $this->seedFasilitas();

        $this->command->info('✅ Profile seeders (Tentang Kami) berhasil dijalankan!');
    }

    private function seedSejarah(): void
    {
        Setting::set('profile_sejarah', <<<'HTML'
<h3>Awal Mula Berdirinya</h3>
<p>
    Masjid Agung Al Azhar bermula dari sebuah mushola kecil yang dibangun pada tahun 1952 di kawasan Kebayoran Baru, Jakarta Selatan.
    Mushola ini didirikan atas prakarsa masyarakat setempat yang menginginkan tempat ibadah yang memadai di lingkungan pemukiman baru tersebut.
</p>

<h3>Peresmian dan Pemberian Nama</h3>
<p>
    Pada tahun 1958, mushola tersebut berkembang menjadi masjid yang lebih besar dan diresmikan dengan nama <strong>"Masjid Agung Kebayoran"</strong>.
    Dua tahun kemudian, pada tahun 1960, setelah kunjungan bersejarah Grand Syeikh Al Azhar dari Mesir, <strong>Mahmoud Shaltout</strong>,
    masjid ini resmi berganti nama menjadi <strong>"Masjid Agung Al Azhar"</strong> sebagai simbol persaudaraan dan penghormatan.
</p>

<h3>Pusat Pendidikan dan Dakwah</h3>
<p>
    Sejak dekade 1970-an, Masjid Agung Al Azhar tidak hanya berfungsi sebagai tempat ibadah. Di bawah naungan
    <strong>Yayasan Pesantren Islam (YPI) Al Azhar</strong>, masjid ini menjadi pusat pendidikan Islam terkemuka
    yang menaungi sekolah-sekolah mulai dari jenjang TK hingga perguruan tinggi. Ribuan alumni telah dihasilkan
    dan tersebar di seluruh Indonesia.
</p>

<h3>Renovasi dan Modernisasi</h3>
<p>
    Memasuki tahun 2000-an, Masjid Al Azhar mengalami renovasi besar-besaran untuk meningkatkan kapasitas
    dan fasilitas. Renovasi ini mencakup perluasan area sholat, perbaikan sistem pendingin udara,
    pembaruan sound system, dan penataan ulang area wudhu yang lebih modern dan higienis.
</p>

<h3>Era Modern</h3>
<p>
    Saat ini, Masjid Agung Al Azhar telah menjadi salah satu ikon masjid modern di Indonesia. Dengan kapasitas
    lebih dari 5.000 jamaah, masjid ini menjadi pusat kegiatan ibadah, pendidikan, dakwah, dan sosial kemasyarakatan
    yang terus berkembang mengikuti perkembangan zaman namun tetap berpegang teguh pada nilai-nilai keislaman.
</p>
HTML);

        $this->command->info('  → Sejarah Masjid berhasil di-seed.');
    }

    private function seedVisiMisi(): void
    {
        Setting::set('profile_visi_misi', <<<'HTML'
<h3>🔭 Visi</h3>
<p>
    Menjadi masjid yang unggul dalam pelayanan ibadah, pendidikan, dan dakwah Islam serta menjadi
    pusat peradaban Islam yang modern, inklusif, dan bermanfaat bagi umat dan bangsa Indonesia.
</p>

<hr style="border: none; border-top: 2px solid #e5e7eb; margin: 30px 0;">

<h3>🎯 Misi</h3>
<ol>
    <li><strong>Ibadah Berkualitas</strong> — Menyelenggarakan kegiatan ibadah dan dakwah yang berkualitas untuk meningkatkan keimanan dan ketaqwaan umat.</li>
    <li><strong>Pendidikan Modern</strong> — Mengembangkan pendidikan Islam yang modern, berkarakter, dan berdaya saing tinggi.</li>
    <li><strong>Ukhuwah Islamiyah</strong> — Membangun persaudaraan dan kebersamaan antar jamaah serta masyarakat luas.</li>
    <li><strong>Pengelolaan Profesional</strong> — Mengelola masjid secara profesional, transparan, dan akuntabel dengan standar tata kelola yang baik.</li>
    <li><strong>Pemberdayaan Umat</strong> — Meningkatkan pemberdayaan sosial ekonomi umat melalui program-program yang berkelanjutan.</li>
    <li><strong>Layanan Prima</strong> — Memberikan pelayanan terbaik kepada jamaah dan masyarakat dengan fasilitas yang nyaman dan modern.</li>
</ol>

<hr style="border: none; border-top: 2px solid #e5e7eb; margin: 30px 0;">

<h3>💎 Nilai-Nilai Inti</h3>
<ul>
    <li><strong>Keikhlasan</strong> — Beramal dan bekerja semata-mata mengharap ridha Allah SWT</li>
    <li><strong>Amanah</strong> — Menjaga kepercayaan umat dengan pengelolaan yang transparan</li>
    <li><strong>Inovasi</strong> — Terus berinovasi dalam pelayanan dan pengembangan dakwah</li>
    <li><strong>Ukhuwah</strong> — Membangun persaudaraan dan kebersamaan antar sesama muslim</li>
    <li><strong>Profesionalisme</strong> — Menjalankan tugas dengan standar profesional yang tinggi</li>
</ul>
HTML);

        $this->command->info('  → Visi & Misi berhasil di-seed.');
    }

    private function seedStrukturOrganisasi(): void
    {
        Setting::set('profile_struktur_organisasi', <<<'HTML'
<h3 style="text-align: center; margin-bottom: 30px;">Struktur Kepengurusan DKM<br><small style="font-weight: normal; color: #6b7280;">Masjid Agung Al Azhar — Periode 2024-2027</small></h3>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
    <thead>
        <tr style="background: linear-gradient(135deg, #0053C5, #003d91); color: white;">
            <th style="padding: 14px 16px; text-align: left; border-radius: 8px 0 0 0;">Jabatan</th>
            <th style="padding: 14px 16px; text-align: left;">Nama</th>
            <th style="padding: 14px 16px; text-align: left; border-radius: 0 8px 0 0;">Bidang</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background: #f0f7ff;">
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">Ketua Umum DKM</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">H. Ahmad Fauzi, S.Ag., M.A.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Pimpinan Umum</td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">Wakil Ketua I</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Dr. H. Muhammad Ridwan</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Ibadah & Dakwah</td>
        </tr>
        <tr style="background: #f0f7ff;">
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">Wakil Ketua II</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Ustadz Hasan Basri, Lc.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Pendidikan & Pengajaran</td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">Sekretaris</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Ir. Bambang Sutrisno, M.T.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Administrasi & Kesekretariatan</td>
        </tr>
        <tr style="background: #f0f7ff;">
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">Bendahara</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">H. Surya Permana, S.E., M.M.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Keuangan</td>
        </tr>
    </tbody>
</table>

<h4 style="margin-top: 30px; margin-bottom: 16px; color: #0053C5;">Divisi-Divisi</h4>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: #10b981; color: white;">
            <th style="padding: 12px 16px; text-align: left; border-radius: 8px 0 0 0;">Divisi</th>
            <th style="padding: 12px 16px; text-align: left;">Kepala Divisi</th>
            <th style="padding: 12px 16px; text-align: left; border-radius: 0 8px 0 0;">Tugas Utama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">🕌 Divisi Ibadah</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Ustadz Syamsul Arifin</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Pelaksanaan sholat berjamaah, Jumat, dan hari besar</td>
        </tr>
        <tr style="background: #f0fdf4;">
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">📚 Divisi Dakwah</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Ustadz Abdul Malik, Lc.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Kajian rutin, ceramah, dan program keagamaan</td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">🤝 Divisi Sosial</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Hj. Siti Aminah, S.Pd.</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Zakat, infaq, sedekah, dan bantuan sosial</td>
        </tr>
        <tr style="background: #f0fdf4;">
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">🛠️ Divisi Sarana</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">H. Wahyu Prabowo</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Pemeliharaan gedung, kebersihan, dan fasilitas</td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600;">👨‍💼 Divisi Humas</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Drs. Agus Salim</td>
            <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">Komunikasi publik, media sosial, dan kerjasama</td>
        </tr>
    </tbody>
</table>
HTML);

        $this->command->info('  → Struktur Organisasi berhasil di-seed.');
    }

    private function seedFasilitas(): void
    {
        Setting::set('profile_fasilitas', <<<'HTML'
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">

    <div style="background: #f0f7ff; border-radius: 14px; padding: 24px; border-left: 4px solid #0053C5;">
        <h4 style="margin-top: 0; color: #0053C5;">🕌 Ruang Sholat Utama</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Kapasitas lebih dari 5.000 jamaah dengan pendingin udara (AC) sentral, karpet premium, dan sound system berkualitas tinggi. Tersedia area sholat terpisah untuk pria dan wanita.</p>
    </div>

    <div style="background: #f0fdf4; border-radius: 14px; padding: 24px; border-left: 4px solid #10b981;">
        <h4 style="margin-top: 0; color: #059669;">💧 Tempat Wudhu</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Tempat wudhu terpisah untuk pria dan wanita yang selalu dijaga kebersihannya. Dilengkapi dengan kran otomatis dan lantai anti-slip untuk kenyamanan jamaah.</p>
    </div>

    <div style="background: #fef3c7; border-radius: 14px; padding: 24px; border-left: 4px solid #f59e0b;">
        <h4 style="margin-top: 0; color: #d97706;">📚 Perpustakaan Islam</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Koleksi lengkap kitab-kitab keislaman, tafsir Al-Quran, hadits, dan buku-buku pengetahuan umum. Ruang baca yang nyaman dengan akses Wi-Fi gratis.</p>
    </div>

    <div style="background: #ede9fe; border-radius: 14px; padding: 24px; border-left: 4px solid #7c3aed;">
        <h4 style="margin-top: 0; color: #6d28d9;">🏫 Ruang Kelas & Kajian</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Beberapa ruang kelas ber-AC untuk kegiatan kajian, tahsin Al-Quran, kursus bahasa Arab, dan program pendidikan lainnya. Dilengkapi proyektor dan whiteboard.</p>
    </div>

    <div style="background: #fce7f3; border-radius: 14px; padding: 24px; border-left: 4px solid #ec4899;">
        <h4 style="margin-top: 0; color: #db2777;">🏢 Aula Serbaguna</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Aula berkapasitas besar untuk acara pernikahan, seminar, workshop, dan kegiatan besar lainnya. Tersedia meja, kursi, dan perlengkapan acara lengkap.</p>
    </div>

    <div style="background: #e0f2fe; border-radius: 14px; padding: 24px; border-left: 4px solid #0284c7;">
        <h4 style="margin-top: 0; color: #0369a1;">🅿️ Area Parkir Luas</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Parkir luas untuk mobil dan sepeda motor dengan petugas keamanan 24 jam. Akses mudah dari jalan utama dengan area drop-off yang nyaman.</p>
    </div>

    <div style="background: #f0f7ff; border-radius: 14px; padding: 24px; border-left: 4px solid #0053C5;">
        <h4 style="margin-top: 0; color: #0053C5;">🍽️ Kantin & Area Makan</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Area kantin bersih dan nyaman yang menyediakan makanan dan minuman halal dengan harga terjangkau bagi jamaah dan pengunjung masjid.</p>
    </div>

    <div style="background: #f0fdf4; border-radius: 14px; padding: 24px; border-left: 4px solid #10b981;">
        <h4 style="margin-top: 0; color: #059669;">🏥 Klinik Kesehatan</h4>
        <p style="margin-bottom: 0; color: #4b5563;">Klinik kesehatan yang melayani pemeriksaan dasar, P3K, dan konsultasi kesehatan gratis untuk jamaah, khususnya saat kegiatan besar di masjid.</p>
    </div>

</div>

<h3 style="text-align: center; margin-top: 40px; margin-bottom: 20px;">📊 Masjid Dalam Angka</h3>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
    <div style="background: white; padding: 28px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0,83,197,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #0053C5; margin-bottom: 6px;">60+</div>
        <div style="font-size: 0.9rem; color: #6b7280;">Tahun Berdiri</div>
    </div>
    <div style="background: white; padding: 28px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0,83,197,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #0053C5; margin-bottom: 6px;">5K+</div>
        <div style="font-size: 0.9rem; color: #6b7280;">Kapasitas Jamaah</div>
    </div>
    <div style="background: white; padding: 28px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0,83,197,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #0053C5; margin-bottom: 6px;">50+</div>
        <div style="font-size: 0.9rem; color: #6b7280;">Program Rutin</div>
    </div>
    <div style="background: white; padding: 28px 20px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0,83,197,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #0053C5; margin-bottom: 6px;">10K+</div>
        <div style="font-size: 0.9rem; color: #6b7280;">Alumni Pendidikan</div>
    </div>
</div>
HTML);

        $this->command->info('  → Fasilitas berhasil di-seed.');
    }
}
