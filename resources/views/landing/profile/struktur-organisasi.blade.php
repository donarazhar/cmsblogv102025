@extends('landing.layouts.app')

@section('title', 'Struktur Organisasi - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Struktur Organisasi Content (Dynamic from Admin) -->
    <section class="section section-light" style="padding-top: 120px;">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Organisasi</span>
                <h2 class="section-title">Struktur Kepengurusan</h2>
                <p class="section-desc">Susunan pengurus Masjid Agung Al Azhar periode saat ini</p>
            </div>

            <div style="background: var(--white); padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,83,197,0.08); max-width: 900px; margin: 0 auto;">
                <div class="content-wrapper">
                    @if(\App\Models\Setting::get('profile_struktur_organisasi'))
                        {!! \App\Models\Setting::get('profile_struktur_organisasi') !!}
                    @else
                        <div style="text-align: center; padding: 40px 20px;">
                            <div style="font-size: 4rem; color: var(--primary-light); margin-bottom: 16px;">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <h3 style="color: var(--text-dark); margin-bottom: 10px;">Struktur Organisasi</h3>
                            <p style="color: var(--text-light); max-width: 500px; margin: 0 auto 20px; line-height: 1.6;">
                                Konten struktur organisasi belum diisi. Silakan buka halaman Admin untuk menambahkan
                                struktur organisasi masjid.
                            </p>
                            <p style="color: var(--text-light); font-style: italic; font-size: 0.85rem;">
                                <i class="fas fa-info-circle"></i> Update melalui menu
                                <strong>Tentang Kami → Struktur Organisasi</strong> di halaman Admin.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Bergabung dengan Tim Kami</h2>
                <p class="cta-text">Kami selalu terbuka untuk menerima relawan dan kontribusi dari jamaah yang ingin
                    berpartisipasi dalam kemakmuran masjid.</p>
                <div class="cta-buttons">
                    <a href="{{ route('contact') }}" class="btn-cta btn-cta-primary">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </a>
                    <a href="{{ route('frontend.profile.pengurus-staf') }}" class="btn-cta btn-cta-outline">
                        <i class="fas fa-users"></i> Lihat Pengurus
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
