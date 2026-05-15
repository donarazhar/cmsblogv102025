@extends('landing.layouts.app')

@section('title', 'Visi & Misi - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Visi & Misi</h1>
                <div class="breadcrumb justify-content-center text-white-50"
                    style="color: rgba(255,255,255,0.8); display:flex; gap:10px; justify-content: center;">
                    <a href="{{ route('home') }}" style="color: white; text-decoration: none;">Beranda</a>
                    <span>/</span>
                    <span>Profil</span>
                    <span>/</span>
                    <span>Visi & Misi</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Visi Misi Content (Dynamic from Admin) -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Visi & Misi</span>
                <h2 class="section-title">Arah & Tujuan Kami</h2>
                <p class="section-desc">Landasan yang menjadi pedoman dalam setiap langkah pengembangan Masjid Agung Al Azhar</p>
            </div>

            <div style="background: var(--white); padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,83,197,0.08); max-width: 900px; margin: 0 auto;">
                <div class="content-wrapper">
                    @if(\App\Models\Setting::get('profile_visi_misi'))
                        {!! \App\Models\Setting::get('profile_visi_misi') !!}
                    @else
                        <h3 style="color: var(--primary); margin-top: 0;"><i class="fas fa-eye"></i> Visi</h3>
                        <p>
                            Menjadi masjid yang unggul dalam pelayanan ibadah, pendidikan, dan dakwah Islam
                            serta menjadi pusat peradaban Islam yang modern, inklusif, dan bermanfaat bagi
                            umat dan bangsa Indonesia.
                        </p>

                        <h3 style="color: #10b981;"><i class="fas fa-bullseye"></i> Misi</h3>
                        <ol>
                            <li>Menyelenggarakan kegiatan ibadah dan dakwah yang berkualitas untuk meningkatkan keimanan dan ketaqwaan umat.</li>
                            <li>Mengembangkan pendidikan Islam yang modern dan berdaya saing tinggi.</li>
                            <li>Membangun ukhuwah Islamiyah dan kebersamaan antar jamaah dan masyarakat.</li>
                            <li>Mengelola masjid secara profesional, transparan, dan akuntabel.</li>
                            <li>Meningkatkan pemberdayaan sosial ekonomi umat melalui program-program yang berkelanjutan.</li>
                        </ol>

                        <p style="color: var(--text-light); font-style: italic; font-size: 0.85rem;">
                            <i class="fas fa-info-circle"></i> Konten ini dapat diperbarui melalui menu
                            <strong>Tentang Kami → Visi & Misi</strong> di halaman Admin.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Wujudkan Visi Bersama</h2>
                <p class="cta-text">Mari bergabung dalam misi kami membangun umat yang lebih baik melalui ibadah,
                    pendidikan, dan pemberdayaan sosial.</p>
                <div class="cta-buttons">
                    <a href="{{ route('programs') }}" class="btn-cta btn-cta-primary">
                        <i class="fas fa-calendar-check"></i> Lihat Program
                    </a>
                    <a href="{{ route('contact') }}" class="btn-cta btn-cta-outline">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
