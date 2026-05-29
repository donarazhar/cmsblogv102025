@extends('landing.layouts.app')

@section('title', 'Sejarah Masjid - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- History Content (Dynamic from Admin) -->
    <section class="section section-light" style="padding-top: 40px;">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Sejarah</span>
                <h2 class="section-title">Sejarah Masjid Agung Al Azhar</h2>
            </div>

            <div class="history-grid">
                <div class="history-image">
                    <img src="{{ asset('storage/img/maa.jpg') }}" alt="Masjid Agung Al Azhar" loading="lazy"
                        onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                </div>
                <div class="history-content">
                    <div class="history-text content-wrapper">
                        @if(\App\Models\Setting::get('profile_sejarah'))
                            {!! \App\Models\Setting::get('profile_sejarah') !!}
                        @else
                            <p>
                                Masjid Agung Al Azhar merupakan salah satu masjid terbesar dan tertua di Jakarta yang telah
                                berdiri sejak tahun 1960-an. Masjid ini didirikan oleh Yayasan Pendidikan Islam (YPI) Al Azhar
                                dengan tujuan menyediakan tempat ibadah yang layak bagi umat Islam di Jakarta.
                            </p>
                            <p>
                                Sejak awal berdirinya, Masjid Al Azhar tidak hanya berfungsi sebagai tempat ibadah, tetapi juga
                                sebagai pusat pendidikan dan dakwah Islam. Berbagai kegiatan keagamaan, pendidikan, dan sosial
                                telah diselenggarakan untuk membangun umat yang lebih baik.
                            </p>
                            <p>
                                Hingga saat ini, Masjid Al Azhar terus berkembang dan menjadi salah satu ikon masjid modern di
                                Indonesia yang tetap menjaga nilai-nilai keislaman yang kuat.
                            </p>
                            <p style="color: var(--text-light); font-style: italic; font-size: 0.85rem;">
                                <i class="fas fa-info-circle"></i> Konten ini dapat diperbarui melalui menu
                                <strong>Tentang Kami → Sejarah Masjid</strong> di halaman Admin.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
