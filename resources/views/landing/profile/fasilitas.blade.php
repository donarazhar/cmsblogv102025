@extends('landing.layouts.app')

@section('title', 'Fasilitas - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Fasilitas Content (Dynamic from Admin) -->
    <section class="section section-light" style="padding-top: 80px;">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Fasilitas</span>
                <h2 class="section-title">Fasilitas Masjid</h2>
            </div>

            <div style="background: var(--white); padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,83,197,0.08); max-width: 900px; margin: 0 auto;">
                <div class="content-wrapper">
                    @if(\App\Models\Setting::get('profile_fasilitas'))
                        {!! \App\Models\Setting::get('profile_fasilitas') !!}
                    @else
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

                        <p style="color: var(--text-light); font-style: italic; font-size: 0.85rem; margin-top: 24px; text-align: center;">
                            <i class="fas fa-info-circle"></i> Konten ini dapat diperbarui melalui menu
                            <strong>Tentang Kami → Fasilitas</strong> di halaman Admin.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
