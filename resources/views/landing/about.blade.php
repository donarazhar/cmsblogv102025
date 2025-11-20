@extends('landing.layouts.app')

@section('title', 'Tentang Kami - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Tentang Kami</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Mengenal lebih dekat Masjid Agung Al Azhar
                </p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; margin-bottom: 80px;">
                <div data-aos="fade-right">
                    <img src="https://via.placeholder.com/600x400" alt="Masjid Al Azhar"
                        style="width: 100%; border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);">
                </div>
                <div data-aos="fade-left">
                    <div class="section-subtitle">Sejarah</div>
                    <h2 class="section-title" style="text-align: left; margin-bottom: 20px;">Sejarah Masjid Agung Al Azhar
                    </h2>
                    <p style="color: #6b7280; line-height: 1.8; margin-bottom: 15px;">
                        Masjid Agung Al Azhar merupakan salah satu masjid terbesar dan tertua di Jakarta yang telah berdiri
                        sejak tahun 1960-an. Masjid ini didirikan oleh Yayasan Pendidikan Islam (YPI) Al Azhar dengan tujuan
                        menyediakan tempat ibadah yang layak bagi umat Islam di Jakarta.
                    </p>
                    <p style="color: #6b7280; line-height: 1.8; margin-bottom: 15px;">
                        Sejak awal berdirinya, Masjid Al Azhar tidak hanya berfungsi sebagai tempat ibadah, tetapi juga
                        sebagai pusat pendidikan dan dakwah Islam. Berbagai kegiatan keagamaan, pendidikan, dan sosial telah
                        diselenggarakan untuk membangun umat yang lebih baik.
                    </p>
                    <p style="color: #6b7280; line-height: 1.8;">
                        Hingga saat ini, Masjid Al Azhar terus berkembang dan menjadi salah satu ikon masjid modern di
                        Indonesia yang tetap menjaga nilai-nilai keislaman yang kuat.
                    </p>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 80px;">
                <div class="info-box" data-aos="fade-up">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div
                            style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 15px 40px rgba(0, 83, 197, 0.3);">
                            <i class="fas fa-eye" style="font-size: 2.5rem; color: white;"></i>
                        </div>
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; text-align: center;">Visi</h3>
                    <p style="color: #6b7280; line-height: 1.8; text-align: center;">
                        Menjadi pusat kegiatan keagamaan, pendidikan, dan dakwah Islam yang modern dan berperan aktif dalam
                        pembangunan masyarakat yang beriman, bertakwa, dan berakhlak mulia.
                    </p>
                </div>

                <div class="info-box" data-aos="fade-up" data-aos-delay="100">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div
                            style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-bullseye" style="font-size: 2.5rem; color: white;"></i>
                        </div>
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; text-align: center;">Misi</h3>
                    <ul style="color: #6b7280; line-height: 2; list-style: none;">
                        <li><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>
                            Menyelenggarakan kegiatan ibadah yang berkualitas</li>
                        <li><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>
                            Memberikan pendidikan Islam yang komprehensif</li>
                        <li><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>
                            Melaksanakan dakwah Islam rahmatan lil alamin</li>
                        <li><i class="fas fa-check-circle" style="color: var(--secondary); margin-right: 10px;"></i>
                            Memberdayakan masyarakat melalui program sosial</li>
                    </ul>
                </div>
            </div>

            <!-- Values -->
            <div style="margin-bottom: 80px;">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-subtitle">Nilai-Nilai Kami</div>
                    <h2 class="section-title">Nilai & Prinsip</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                    <div class="value-card" data-aos="fade-up">
                        <div class="value-icon">
                            <i class="fas fa-quran"></i>
                        </div>
                        <h4>Islamiyah</h4>
                        <p>Berpegang teguh pada Al-Quran dan As-Sunnah</p>
                    </div>

                    <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="value-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h4>Ukhuwah</h4>
                        <p>Membangun persaudaraan yang kuat sesama muslim</p>
                    </div>

                    <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="value-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>Ilmiyah</h4>
                        <p>Mengedepankan ilmu dan pendidikan berkualitas</p>
                    </div>

                    <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Inovatif</h4>
                        <p>Berinovasi dalam dakwah dan pelayanan</p>
                    </div>
                </div>
            </div>

            <!-- Facilities -->
            <div style="margin-bottom: 80px;">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-subtitle">Fasilitas</div>
                    <h2 class="section-title">Fasilitas Masjid</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                    <div class="facility-card" data-aos="fade-up">
                        <i class="fas fa-mosque"></i>
                        <h4>Ruang Sholat Utama</h4>
                        <p>Kapasitas 5000 jamaah dengan AC dan sound system</p>
                    </div>

                    <div class="facility-card" data-aos="fade-up" data-aos-delay="50">
                        <i class="fas fa-water"></i>
                        <h4>Tempat Wudhu</h4>
                        <p>Terpisah untuk pria dan wanita, bersih dan nyaman</p>
                    </div>

                    <div class="facility-card" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-book-reader"></i>
                        <h4>Perpustakaan Islam</h4>
                        <p>Koleksi lengkap buku-buku keislaman</p>
                    </div>

                    <div class="facility-card" data-aos="fade-up" data-aos-delay="150">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h4>Ruang Kelas</h4>
                        <p>Untuk kajian dan pendidikan Islam</p>
                    </div>

                    <div class="facility-card" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-building"></i>
                        <h4>Aula Serbaguna</h4>
                        <p>Untuk acara dan kegiatan besar</p>
                    </div>

                    <div class="facility-card" data-aos="fade-up" data-aos-delay="250">
                        <i class="fas fa-parking"></i>
                        <h4>Area Parkir Luas</h4>
                        <p>Parkir mobil dan motor yang memadai</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Staff Section -->
    @if ($staff->count() > 0)
        <section class="section" style="background: var(--light);">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-subtitle">Tim Kami</div>
                    <h2 class="section-title">Pengurus & Ustadz</h2>
                    <p class="section-description">
                        Kenali pengurus dan ustadz yang mengabdi di Masjid Al Azhar
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px;">
                    @foreach ($staff as $person)
                        <div class="staff-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="staff-photo">
                                @if ($person->photo)
                                    <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}">
                                @else
                                    <div class="photo-placeholder">{{ strtoupper(substr($person->name, 0, 1)) }}</div>
                                @endif
                            </div>
                            <div class="staff-info">
                                <h4 class="staff-name">{{ $person->name }}</h4>
                                <p class="staff-position">{{ $person->position }}</p>
                                @if ($person->department)
                                    <p class="staff-department">{{ $person->department }}</p>
                                @endif
                                @if ($person->specialization)
                                    <p class="staff-specialization">{{ $person->specialization }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="section"
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;" data-aos="zoom-in">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">
                    Bergabunglah Bersama Kami
                </h2>
                <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.95;">
                    Mari bersama-sama membangun umat yang lebih baik melalui kegiatan ibadah, pendidikan, dan dakwah.
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('programs') }}" class="btn" style="background: white; color: var(--primary);">
                        <i class="fas fa-calendar-check"></i>
                        Lihat Program
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">
                        <i class="fas fa-envelope"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .info-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .value-card {
            background: white;
            padding: 35px 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .value-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .value-card p {
            color: #6b7280;
            line-height: 1.6;
        }

        .facility-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .facility-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .facility-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .facility-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .facility-card p {
            color: #6b7280;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .staff-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .staff-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .staff-photo {
            width: 100%;
            height: 280px;
            background: var(--light);
            position: relative;
            overflow: hidden;
        }

        .staff-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .staff-card:hover .staff-photo img {
            transform: scale(1.1);
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
            font-weight: 700;
        }

        .staff-info {
            padding: 25px;
        }

        .staff-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .staff-position {
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .staff-department {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .staff-specialization {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .btn {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            section>div>div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
