@extends('landing.layouts.app')

@section('title', 'Fasilitas - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Fasilitas Masjid</h1>
                <div class="breadcrumb justify-content-center text-white-50" style="color: rgba(255,255,255,0.8); display:flex; gap:10px; justify-content: center;">
                    <a href="{{ route('home') }}" style="color: white; text-decoration: none;">Beranda</a>
                    <span>/</span>
                    <span>Profil</span>
                    <span>/</span>
                    <span>Fasilitas</span>
                </div>
            </div>
        </div>
    </header>

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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            document.querySelectorAll('.facility-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endpush
