<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', $settings['seo_description'] ?? 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['seo_keywords'] ?? 'masjid al azhar, masjid jakarta, kajian islam')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings['site_name'] ?? 'Masjid Agung Al Azhar')</title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="shortcut icon" href="https://siap.al-azhar.id/upload/favicon.ico" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animation - Load async -->
    <link rel="preload" href="https://unpkg.com/aos@next/dist/aos.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    </noscript>

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0053C5;
            --primary-dark: #003d91;
            --primary-light: #3374d1;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --info: #3b82f6;
            --dark: #1f2937;
            --light: #f9fafb;
            --border: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 20px rgba(0, 83, 197, 0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 5px 30px rgba(0, 83, 197, 0.2);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 700;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary);
        }

        .navbar-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0053C5 0%, #003d91 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover .navbar-logo {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 83, 197, 0.4);
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 10px;
        }

        .navbar-menu a {
            text-decoration: none;
            color: var(--dark);
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .navbar-menu a::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: #0053C5;
            transition: width 0.3s ease;
        }

        .navbar-menu a:hover::after {
            width: calc(100% - 40px);
        }

        .navbar-menu a:hover {
            color: #0053C5;
        }

        .navbar-menu a.active {
            background: #0053C5;
            color: white;
        }

        .navbar-menu a.active::after {
            width: 0;
        }

        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #0053C5;
            transition: all 0.3s ease;
        }

        .navbar-toggle:hover {
            transform: scale(1.1);
        }

        /* Mobile Menu */
        @media (max-width: 768px) {
            .navbar-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: white;
                flex-direction: column;
                padding: 20px;
                transition: left 0.3s ease;
                box-shadow: 0 5px 20px rgba(0, 83, 197, 0.1);
            }

            .navbar-menu.active {
                left: 0;
            }

            .navbar-toggle {
                display: block;
            }

            .navbar-menu a::after {
                display: none;
            }
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Section */
        .section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-subtitle {
            color: #0053C5;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-description {
            color: #6b7280;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0053C5 0%, #003d91 100%);
            color: white;
            padding: 60px 0 30px;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .footer-top {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .footer-widget h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
            color: white;
        }

        .footer-widget p,
        .footer-widget li {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 10px;
            line-height: 1.8;
        }

        .footer-widget ul {
            list-style: none;
        }

        .footer-widget a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-widget a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
            /* Reduced size */
            position: relative;
            /* Added */
        }

        .social-icon i {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Perfect centering for font awesome icons */
            line-height: 1;
            width: 100%;
            height: 100%;
        }

        /* Specific adjustments for each icon */
        .social-icon .fa-facebook-f {
            font-size: 1rem;
        }

        .social-icon .fa-instagram {
            font-size: 1.1rem;
        }

        .social-icon .fa-twitter {
            font-size: 1rem;
        }

        .social-icon .fa-youtube {
            font-size: 1rem;
        }

        .social-icon:hover {
            background: white;
            color: #0053C5;
            border-color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            position: relative;
            z-index: 1;
        }

        /* Scroll to Top Button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0053C5 0%, #003d91 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 83, 197, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 83, 197, 0.6);
        }

        /* Loading */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loading.hide {
            opacity: 0;
            pointer-events: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e5e7eb;
            border-top-color: #0053C5;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .navbar-container {
                height: 70px;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-logo {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .footer {
                padding: 40px 0 20px;
            }

            .footer-top {
                gap: 30px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Loading -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="navbar-logo">
                    <i class="fas fa-mosque"></i>
                </div>
                <span>{{ $settings['site_name'] ?? 'Al Azhar' }}</span>
            </a>

            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                </li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a>
                </li>
                <li><a href="{{ route('programs') }}"
                        class="{{ request()->routeIs('programs') ? 'active' : '' }}">Program</a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">Berita</a>
                </li>
                <li><a href="{{ route('gallery') }}"
                        class="{{ request()->routeIs('gallery*') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a></li>
            </ul>

            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-widget">
                    <h3>{{ $settings['site_name'] ?? 'Masjid Agung Al Azhar' }}</h3>
                    <p>{{ $settings['site_description'] ?? 'Pusat kegiatan keagamaan, pendidikan, dan dakwah Islam di Jakarta.' }}
                    </p>
                    <div class="footer-social">
                        @if (isset($settings['social_facebook']))
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="social-icon"
                                title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if (isset($settings['social_instagram']))
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="social-icon"
                                title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if (isset($settings['social_twitter']))
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="social-icon"
                                title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if (isset($settings['social_youtube']))
                            <a href="{{ $settings['social_youtube'] }}" target="_blank" class="social-icon"
                                title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="footer-widget">
                    <h3>Menu Cepat</h3>
                    <ul>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"
                                    style="font-size: 0.8rem; margin-right: 8px;"></i>Tentang Kami</a></li>
                        <li><a href="{{ route('programs') }}"><i class="fas fa-chevron-right"
                                    style="font-size: 0.8rem; margin-right: 8px;"></i>Program</a></li>
                        <li><a href="{{ route('blog') }}"><i class="fas fa-chevron-right"
                                    style="font-size: 0.8rem; margin-right: 8px;"></i>Berita</a></li>
                        <li><a href="{{ route('gallery') }}"><i class="fas fa-chevron-right"
                                    style="font-size: 0.8rem; margin-right: 8px;"></i>Galeri</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"
                                    style="font-size: 0.8rem; margin-right: 8px;"></i>Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h3>Kontak</h3>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt" style="margin-right: 10px; color: white;"></i>
                            {{ $settings['contact_address'] ?? 'Jakarta, Indonesia' }}
                        </li>
                        <li>
                            <i class="fas fa-phone" style="margin-right: 10px; color: white;"></i>
                            {{ $settings['contact_phone'] ?? '(+62) 217397267' }}
                        </li>
                        <li>
                            <i class="fas fa-envelope" style="margin-right: 10px; color: white;"></i>
                            {{ $settings['contact_email'] ?? 'masjidagungalazhar@gmail.com' }}
                        </li>
                        <li>
                            <i class="fab fa-whatsapp" style="margin-right: 10px; color: white;"></i>
                            {{ $settings['contact_whatsapp'] ?? '0882-1211-4771' }}
                        </li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h3>Jam Operasional</h3>
                    <ul>
                        <li><i class="fas fa-clock" style="margin-right: 10px; color: white;"></i>Senin - Sabtu: 08:00
                            - 15:00</li>
                        <li><i class="fas fa-clock" style="margin-right: 10px; color: white;"></i>Ahad :
                            Janji Temu</li>
                        <li><i class="fas fa-mosque" style="margin-right: 10px; color: white;"></i>Jumat: 11:30 -
                            12:30 (Sholat Jumat)</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Masjid Agung Al Azhar' }}. All rights
                    reserved. | Developed with <i class="fas fa-heart" style="color: #ef4444;"></i>by DAL ARMY</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- AOS Animation - Load async -->
    <script src="https://unpkg.com/aos@next/dist/aos.js" defer></script>

    <script>
        // Wait for AOS to load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    offset: 100,
                    disable: 'mobile' // Disable on mobile for better performance
                });
            }
        });
    </script>

    <!-- Custom JS -->
    <script>
        // Loading
        window.addEventListener('load', () => {
            document.getElementById('loading').classList.add('hide');
        });

        // Navbar Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const navbarToggle = document.getElementById('navbarToggle');
        const navbarMenu = document.getElementById('navbarMenu');

        navbarToggle.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
            const icon = navbarToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Scroll to Top
        const scrollTop = document.getElementById('scrollTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTop.classList.add('show');
            } else {
                scrollTop.classList.remove('show');
            }
        });

        scrollTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.navbar')) {
                navbarMenu.classList.remove('active');
                const icon = navbarToggle.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
