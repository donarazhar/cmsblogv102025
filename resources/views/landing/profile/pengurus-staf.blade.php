@extends('landing.layouts.app')

@section('title', 'Pengurus & Staf - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    @include('landing.partials.about-styles')
@endpush

@section('content')
    <div style="padding-top: 120px;">
        @include('landing.partials.struktur-organisasi', ['staff' => $staff])
    </div>
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
