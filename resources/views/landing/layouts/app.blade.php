<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', setting('seo_description', 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('seo_keywords', 'masjid al azhar, masjid jakarta, kajian islam'))">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0053C5">
    <title>@yield('title', setting('site_name', 'Masjid Agung Al Azhar'))</title>

    <!-- Preload & Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="https://siap.al-azhar.id/upload/favicon.ico" type="image/x-icon" />

    <!-- SEO -->
    <x-seo :title="$pageTitle ?? 'Home'" :description="$pageDescription ?? setting('seo_description')" :keywords="$pageKeywords ?? setting('seo_keywords')" :image="$pageImage ?? null" :breadcrumb="$breadcrumb ?? []" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===== CSS RESET & VARIABLES ===== */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0053C5;
            --primary-dark: #003d91;
            --primary-light: #e8f1fc;

            --secondary: #1e293b;
            --accent: #f59e0b;

            --text: #334155;
            --text-light: #64748b;
            --text-dark: #0f172a;

            --bg: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;

            --shadow: 0 4px 15px rgba(0, 83, 197, 0.08);
            --shadow-lg: 0 10px 40px rgba(0, 83, 197, 0.12);
            --shadow-xl: 0 20px 50px rgba(0, 83, 197, 0.15);

            --radius: 10px;
            --radius-lg: 16px;

            --transition: all 0.3s ease;

            --navbar-height: 80px;
            --container-max: 1200px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            background: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
        }

        ul,
        ol {
            list-style: none;
        }

        /* ===== CONTAINER ===== */
        .container {
            width: 100%;
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== LOADING SCREEN ===== */
        .page-loader {
            position: fixed;
            inset: 0;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .page-loader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: var(--white);
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.scrolled {
            box-shadow: var(--shadow);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 20px;
            max-width: var(--container-max);
            margin: 0 auto;
        }

        /* Brand */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .navbar-brand:hover {
            color: var(--primary);
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            object-fit: cover;
            background: var(--primary-light);
            transition: var(--transition);
        }

        .navbar-brand:hover .brand-logo {
            transform: scale(1.05);
            box-shadow: var(--shadow);
        }

        .brand-text {
            display: none;
        }

        @media (min-width: 480px) {
            .brand-text {
                display: block;
            }
        }

        /* Nav Menu - Desktop */
        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text);
            border-radius: var(--radius);
            transition: var(--transition);
            white-space: nowrap;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-link.active {
            color: var(--white);
            background: var(--primary);
        }

        .nav-link .dropdown-icon {
            font-size: 0.65rem;
            transition: var(--transition);
            margin-left: 2px;
        }

        /* Dropdown - Desktop */
        .nav-dropdown .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 100;
            border: 1px solid var(--border);
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown:hover .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            font-size: 0.875rem;
            color: var(--text);
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .dropdown-item:hover {
            color: var(--primary);
            background: var(--primary-light);
            padding-left: 20px;
        }

        .dropdown-item i {
            font-size: 0.8rem;
            width: 16px;
            color: var(--text-light);
        }

        /* Mobile Toggle */
        .navbar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            background: var(--bg);
            border-radius: var(--radius);
            color: var(--text-dark);
            font-size: 1.25rem;
            transition: var(--transition);
        }

        .navbar-toggle:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* ===== MOBILE MENU HEADER (Hidden on Desktop) ===== */
        .mobile-menu-header {
            display: none;
        }

        .navbar-menu-wrapper {
            display: contents;
        }

        /* ===== MOBILE MENU - SLIDE FROM LEFT ===== */
        @media (max-width: 991px) {
            :root {
                --navbar-height: 70px;
            }

            .navbar-toggle {
                display: flex;
            }

            /* Mobile Menu Wrapper */
            .navbar-menu-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 300px;
                max-width: 85vw;
                background: var(--white);
                transform: translateX(-100%);
                transition: transform 0.35s ease;
                z-index: 1001;
                box-shadow: var(--shadow-xl);
                display: flex;
                flex-direction: column;
            }

            .navbar-menu-wrapper.active {
                transform: translateX(0);
            }

            /* Mobile Menu Header - Show on Mobile */
            .mobile-menu-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 20px;
                height: 70px;
                border-bottom: 1px solid var(--border);
                background: var(--white);
                flex-shrink: 0;
            }

            .mobile-menu-title {
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--text-dark);
            }

            .mobile-menu-close {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background: var(--bg);
                border-radius: var(--radius);
                color: var(--text-dark);
                font-size: 1.1rem;
                transition: var(--transition);
                cursor: pointer;
                border: none;
            }

            .mobile-menu-close:hover {
                background: var(--primary-light);
                color: var(--primary);
            }

            /* Menu List */
            .navbar-menu {
                flex: 1;
                flex-direction: column;
                align-items: stretch;
                gap: 5px;
                padding: 20px;
                overflow-y: auto;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                padding: 14px 16px;
                font-size: 1rem;
                border-radius: var(--radius);
                width: 100%;
                justify-content: space-between;
            }

            /* Mobile Dropdown */
            .nav-dropdown .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                border: none;
                padding: 0;
                padding-left: 16px;
                margin-top: 5px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.35s ease;
                background: transparent;
            }

            .nav-dropdown.open .dropdown-menu {
                max-height: 500px;
            }

            .nav-dropdown.open .dropdown-icon {
                transform: rotate(180deg);
            }

            .dropdown-item {
                padding: 12px 16px;
                background: var(--bg);
                margin-bottom: 4px;
                border-radius: var(--radius);
            }
        }

        /* ===== OVERLAY ===== */
        .menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            min-height: calc(100vh - var(--navbar-height));
            padding-top: var(--navbar-height);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .footer-main {
            position: relative;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 40px;
        }

        .footer-brand {
            max-width: 300px;
        }

        .footer-brand-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .footer-brand-desc {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        /* Social Links */
        .social-links {
            display: flex;
            gap: 10px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius);
            color: var(--white);
            font-size: 1rem;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Footer Widget */
        .footer-widget-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.15);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--white);
            transform: translateX(5px);
        }

        .footer-link i {
            font-size: 0.7rem;
            width: 14px;
        }

        /* Contact Info */
        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .contact-item {
            display: flex;
            gap: 12px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        .contact-item i {
            width: 16px;
            margin-top: 4px;
            color: rgba(255, 255, 255, 0.6);
            flex-shrink: 0;
        }

        /* Footer Bottom */
        .footer-bottom {
            position: relative;
            padding: 25px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .footer-copyright {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.75);
        }

        .footer-copyright a {
            color: var(--white);
            font-weight: 500;
        }

        .footer-copyright .heart {
            color: #ef4444;
            animation: heartbeat 1.5s ease infinite;
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        /* ===== SCROLL TO TOP ===== */
        .scroll-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 48px;
            height: 48px;
            background: var(--primary);
            color: var(--white);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: var(--transition);
            z-index: 997;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            background: var(--primary-dark);
            transform: translateY(-4px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .footer-main {
                padding: 50px 0 25px;
            }

            .footer-grid {
                gap: 35px;
            }

            .scroll-top {
                bottom: 20px;
                right: 20px;
                width: 44px;
                height: 44px;
            }
        }

        @media (max-width: 480px) {
            .footer-brand {
                max-width: 100%;
            }

            .container {
                padding: 0 16px;
            }
        }
    </style>

    @stack('styles')
    <x-analytics />
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="navbar-brand">
                @if (setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}"
                        alt="{{ setting('site_name', 'Al Azhar') }}" class="brand-logo" width="48" height="48">
                @else
                    <img src="{{ asset('assets/img/ypia.png') }}" alt="{{ setting('site_name', 'Al Azhar') }}"
                        class="brand-logo" width="48" height="48">
                @endif
                <span class="brand-text">{{ setting('site_name', 'Al Azhar') }}</span>
            </a>

            <!-- Menu -->
            <div class="navbar-menu-wrapper">
                <!-- Mobile Menu Header - PINDAHKAN KE SINI -->
                <div class="mobile-menu-header">
                    <span class="mobile-menu-title">Menu</span>
                    <button class="mobile-menu-close" id="mobileMenuClose" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Menu List -->
                <ul class="navbar-menu" id="navbarMenu">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="javascript:void(0)"
                            class="nav-link {{ request()->routeIs('frontend.profile.*') ? 'active' : '' }}">
                            Tentang Kami
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('frontend.profile.sejarah') }}"
                                    class="dropdown-item {{ request()->routeIs('frontend.profile.sejarah') ? 'active' : '' }}">
                                    Sejarah Masjid
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.profile.visi-misi') }}"
                                    class="dropdown-item {{ request()->routeIs('frontend.profile.visi-misi') ? 'active' : '' }}">
                                    Visi & Misi
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.profile.struktur-organisasi') }}"
                                    class="dropdown-item {{ request()->routeIs('frontend.profile.struktur-organisasi') ? 'active' : '' }}">
                                    Struktur Organisasi
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.profile.pengurus-staf') }}"
                                    class="dropdown-item {{ request()->routeIs('frontend.profile.pengurus-staf') ? 'active' : '' }}">
                                    Pengurus & Staf
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.profile.fasilitas') }}"
                                    class="dropdown-item {{ request()->routeIs('frontend.profile.fasilitas') ? 'active' : '' }}">
                                    Fasilitas
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('programs') }}" class="nav-link {{ request()->routeIs('programs') || request()->routeIs('program.*') ? 'active' : '' }}">
                            Program
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('gallery') }}"
                            class="nav-link {{ request()->routeIs('gallery') || request()->routeIs('gallery.*') ? 'active' : '' }}">
                            Galeri
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('blog') }}"
                            class="nav-link {{ request()->routeIs('blog') || request()->routeIs('blog.*') ? 'active' : '' }}">
                            Berita/Artikel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('contact') }}"
                            class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Toggle -->
            <button class="navbar-toggle" id="navbarToggle" type="button">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-main">
                <div class="footer-grid">
                    <!-- Brand -->
                    <div class="footer-brand">
                        <h3 class="footer-brand-name">{{ setting('site_name', 'Masjid Agung Al Azhar') }}</h3>
                        <p class="footer-brand-desc">
                            {{ setting('site_description', 'Pusat kegiatan keagamaan, pendidikan, dan dakwah Islam di Jakarta.') }}
                        </p>
                        <div class="social-links">
                            @if (setting('social_facebook'))
                                <a href="{{ setting('social_facebook') }}" target="_blank" rel="noopener"
                                    class="social-link" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if (setting('social_instagram'))
                                <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener"
                                    class="social-link" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if (setting('social_twitter'))
                                <a href="{{ setting('social_twitter') }}" target="_blank" rel="noopener"
                                    class="social-link" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if (setting('social_youtube'))
                                <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener"
                                    class="social-link" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                            @if (setting('social_tiktok'))
                                <a href="{{ setting('social_tiktok') }}" target="_blank" rel="noopener"
                                    class="social-link" title="TikTok">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">Menu Cepat</h4>
                        <nav class="footer-links">
                            <a href="{{ route('programs') }}" class="footer-link">
                                <i class="fas fa-chevron-right"></i>
                                Program
                            </a>
                            <a href="{{ route('blog') }}" class="footer-link">
                                <i class="fas fa-chevron-right"></i>
                                Berita
                            </a>
                            <a href="{{ route('gallery') }}" class="footer-link">
                                <i class="fas fa-chevron-right"></i>
                                Galeri
                            </a>
                            <a href="{{ route('contact') }}" class="footer-link">
                                <i class="fas fa-chevron-right"></i>
                                Hubungi Kami
                            </a>
                        </nav>
                    </div>

                    <!-- Contact -->
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">Kontak</h4>
                        <address class="contact-list" style="font-style: normal;">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ setting('contact_address', 'Jakarta, Indonesia') }}</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ setting('contact_phone', '(+62) 217397267') }}</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ setting('contact_email', 'masjidagungalazhar@gmail.com') }}</span>
                            </div>
                            <div class="contact-item">
                                <i class="fab fa-whatsapp"></i>
                                <span>{{ setting('contact_whatsapp', '0882-1211-4771') }}</span>
                            </div>
                        </address>
                    </div>

                    <!-- Hours -->
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">Jam Operasional</h4>
                        <div class="contact-list">
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <span>Senin - Sabtu: 08:00 - 15:00</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <span>Ahad: Janji Temu</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-mosque"></i>
                                <span>Jumat: 11:30 - 12:30 (Sholat Jumat)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-copyright">
                    &copy; {{ date('Y') }} {{ setting('site_name', 'Masjid Agung Al Azhar') }}. All rights
                    reserved.
                    | Developed with <i class="fas fa-heart heart"></i> by
                    <a href="#">DAL ARMY</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTop" type="button">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const loader = document.getElementById('pageLoader');
            const navbar = document.getElementById('navbar');
            const navbarToggle = document.getElementById('navbarToggle');
            const navbarMenu = document.getElementById('navbarMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const scrollTopBtn = document.getElementById('scrollTop');
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            // Hide loader
            window.addEventListener('load', function() {
                loader.classList.add('loaded');
            });

            // Fallback
            setTimeout(function() {
                loader.classList.add('loaded');
            }, 3000);

            // Scroll handler
            function handleScroll() {
                const scrollY = window.scrollY;

                if (scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                if (scrollY > 300) {
                    scrollTopBtn.classList.add('visible');
                } else {
                    scrollTopBtn.classList.remove('visible');
                }
            }

            window.addEventListener('scroll', handleScroll);
            handleScroll();

            // Open menu
            function openMenu() {
                document.querySelector('.navbar-menu-wrapper').classList.add('active');
                menuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Close menu
            function closeMenu() {
                document.querySelector('.navbar-menu-wrapper').classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';

                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('open');
                });
            }

            // Toggle button click
            navbarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                openMenu();
            });

            // Close button click
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });

            // Overlay click
            menuOverlay.addEventListener('click', closeMenu);

            // Mobile dropdown toggle
            dropdowns.forEach(function(dropdown) {
                const link = dropdown.querySelector('.nav-link');

                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 991) {
                        e.preventDefault();

                        dropdowns.forEach(function(other) {
                            if (other !== dropdown) {
                                other.classList.remove('open');
                            }
                        });

                        dropdown.classList.toggle('open');
                    }
                });
            });

            // Close menu on link click
            const navLinks = document.querySelectorAll(
                '.navbar-menu > .nav-item > .nav-link:not(.nav-dropdown > .nav-link)');
            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 991) {
                        closeMenu();
                    }
                });
            });

            // Close menu on dropdown item click
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 991) {
                        closeMenu();
                    }
                });
            });

            // Scroll to top
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && navbarMenu.classList.contains('active')) {
                    closeMenu();
                }
            });

            // Resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991 && document.querySelector('.navbar-menu-wrapper').classList
                    .contains('active')) {
                    closeMenu();
                }
            });
        });
    </script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7NW9G4G7HM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-7NW9G4G7HM');
    </script>

    @stack('scripts')
</body>

</html>
