@extends('landing.layouts.app')

@section('title', 'Pengurus & Staf - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Pengurus & Staf</h1>
                <div class="breadcrumb justify-content-center text-white-50" style="color: rgba(255,255,255,0.8); display:flex; gap:10px; justify-content: center;">
                    <a href="{{ route('home') }}" style="color: white; text-decoration: none;">Beranda</a>
                    <span>/</span>
                    <span>Profil</span>
                    <span>/</span>
                    <span>Pengurus & Staf</span>
                </div>
            </div>
        </div>
    </header>

    @include('landing.partials.struktur-organisasi', ['staff' => $staff])
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

            document.querySelectorAll('.staff-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endpush
