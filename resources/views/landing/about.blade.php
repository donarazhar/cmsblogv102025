@extends('landing.layouts.app')

@section('title', 'Tentang Kami - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Tentang Kami</h1>
                <p class="page-subtitle">Mengenal lebih dekat Masjid Agung Al Azhar</p>
            </div>
        </div>
    </header>

    <!-- History Section -->
    @include('landing.partials.sejarah')

    <!-- Vision & Mission Section -->
    @include('landing.partials.visi-misi')

    <!-- Values Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Nilai-Nilai</span>
                <h2 class="section-title">Nilai & Prinsip Kami</h2>
            </div>

            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-quran"></i>
                    </div>
                    <h4 class="value-title">Islamiyah</h4>
                    <p class="value-text">Berpegang teguh pada Al-Quran dan As-Sunnah</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h4 class="value-title">Ukhuwah</h4>
                    <p class="value-text">Membangun persaudaraan yang kuat sesama muslim</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="value-title">Ilmiyah</h4>
                    <p class="value-text">Mengedepankan ilmu dan pendidikan berkualitas</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4 class="value-title">Inovatif</h4>
                    <p class="value-text">Berinovasi dalam dakwah dan pelayanan umat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Fasilitas</span>
                <h2 class="section-title">Fasilitas Masjid</h2>
            </div>

            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h4 class="facility-title">Ruang Sholat Utama</h4>
                    <p class="facility-text">Kapasitas 5000 jamaah dengan AC</p>
                </div>

                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h4 class="facility-title">Tempat Wudhu</h4>
                    <p class="facility-text">Terpisah pria & wanita, bersih</p>
                </div>

                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h4 class="facility-title">Perpustakaan</h4>
                    <p class="facility-text">Koleksi lengkap buku keislaman</p>
                </div>

                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4 class="facility-title">Ruang Kelas</h4>
                    <p class="facility-text">Untuk kajian dan pendidikan</p>
                </div>

                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4 class="facility-title">Aula Serbaguna</h4>
                    <p class="facility-text">Untuk acara dan kegiatan besar</p>
                </div>

                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="fas fa-parking"></i>
                    </div>
                    <h4 class="facility-title">Area Parkir</h4>
                    <p class="facility-text">Parkir luas mobil dan motor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Staff Section -->
    @include('landing.partials.struktur-organisasi')

    <!-- Statistics Section -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Statistik</span>
                <h2 class="section-title">Dalam Angka</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                <div
                    style="background: var(--white); padding: 32px 24px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary); margin-bottom: 8px;">60+</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Tahun Berdiri</div>
                </div>

                <div
                    style="background: var(--white); padding: 32px 24px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary); margin-bottom: 8px;">5K+</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Kapasitas Jamaah</div>
                </div>

                <div
                    style="background: var(--white); padding: 32px 24px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary); margin-bottom: 8px;">50+</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Program Rutin</div>
                </div>

                <div
                    style="background: var(--white); padding: 32px 24px; border-radius: 14px; text-align: center; box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary); margin-bottom: 8px;">10K+</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Alumni Pendidikan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Bergabunglah Bersama Kami</h2>
                <p class="cta-text">
                    Mari bersama-sama membangun umat yang lebih baik melalui kegiatan ibadah, pendidikan, dan dakwah.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('programs') }}" class="btn-cta btn-cta-primary">
                        <i class="fas fa-calendar-check"></i>
                        Lihat Program
                    </a>
                    <a href="{{ route('contact') }}" class="btn-cta btn-cta-outline">
                        <i class="fas fa-envelope"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // AOS Animation (optional - if you want to add animations)
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.value-card, .facility-card, .staff-card, .vm-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endpush
