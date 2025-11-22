<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Masjid Agung Al Azhar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="https://siap.al-azhar.id/upload/favicon.ico" type="image/x-icon" />

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
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            color: var(--dark);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .sidebar-logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .sidebar-title {
            flex: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-title h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 2px;
            white-space: nowrap;
        }

        .sidebar-title p {
            font-size: 0.8rem;
            opacity: 0.8;
            white-space: nowrap;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: white;
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar-toggle i {
            font-size: 0.8rem;
            color: var(--primary);
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover i {
            color: white;
        }

        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        /* Menu Section with Accordion */
        .menu-section {
            margin-bottom: 5px;
        }

        .menu-section-header {
            padding: 12px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            user-select: none;
        }

        .menu-section-header:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .menu-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .menu-section-title {
            font-size: 0;
        }

        .sidebar.collapsed .menu-section-title i {
            font-size: 1.2rem;
            margin: 0 auto;
        }

        .menu-section-icon {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed .menu-section-icon {
            display: none;
        }

        .menu-section.collapsed .menu-section-icon {
            transform: rotate(-90deg);
        }

        .menu-section-content {
            max-height: 1000px;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.3s ease;
            opacity: 1;
        }

        .menu-section.collapsed .menu-section-content {
            max-height: 0;
            opacity: 0;
        }

        .sidebar.collapsed .menu-section-content {
            display: none;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px 12px 35px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar.collapsed .menu-item {
            padding: 12px 20px;
            justify-content: center;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 40px;
        }

        .sidebar.collapsed .menu-item:hover {
            padding-left: 20px;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
        }

        .menu-item i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .menu-item span {
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .menu-badge {
            margin-left: auto;
            background: var(--danger);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .sidebar.collapsed .menu-badge {
            display: none;
        }

        /* Dashboard Menu (tidak ada accordion) */
        .menu-dashboard {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .sidebar.collapsed .menu-dashboard {
            justify-content: center;
        }

        .menu-dashboard:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }

        .sidebar.collapsed .menu-dashboard:hover {
            padding-left: 20px;
        }

        .menu-dashboard.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
        }

        .menu-dashboard i {
            width: 25px;
            margin-right: 12px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar.collapsed .menu-dashboard i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .menu-dashboard span {
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-dashboard span {
            display: none;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 10px;
            background: var(--light);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .hamburger:hover {
            background: var(--primary);
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: var(--dark);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger:hover span {
            background: white;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Header */
        .header {
            background: white;
            height: var(--header-height);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-search {
            position: relative;
        }

        .header-search input {
            padding: 10px 40px 10px 15px;
            border: 1px solid var(--border);
            border-radius: 10px;
            width: 300px;
            font-size: 0.95rem;
        }

        .header-search i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .header-notification {
            position: relative;
            width: 40px;
            height: 40px;
            background: var(--light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-notification:hover {
            background: var(--primary);
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .header-profile:hover {
            background: var(--light);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .profile-info {
            text-align: left;
        }

        .profile-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--dark);
        }

        .profile-role {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb span {
            color: #9ca3af;
        }

        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tooltip for collapsed sidebar */
        .menu-item-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--dark);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            margin-left: 10px;
            z-index: 1002;
        }

        .sidebar.collapsed .menu-item:hover .menu-item-tooltip,
        .sidebar.collapsed .menu-dashboard:hover .menu-item-tooltip {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .header-search {
                display: none;
            }

            .profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                width: var(--sidebar-width) !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .hamburger {
                display: flex;
            }

            .header {
                padding: 0 15px;
            }

            .header-title {
                font-size: 1.2rem;
            }

            .content {
                padding: 20px 15px;
            }

            .header-notification {
                width: 35px;
                height: 35px;
            }

            .sidebar-toggle {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="sidebar-title">
                <h3>Al Azhar</h3>
                <p>Admin Panel</p>
            </div>
            <div class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-chevron-left"></i>
            </div>
        </div>

        <nav class="sidebar-menu">
            <!-- Dashboard (No Accordion) -->
            <a href="{{ route('admin.dashboard') }}"
                class="menu-dashboard {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
                <span class="menu-item-tooltip">Beranda</span>
            </a>

            <!-- Content Section -->
            <div class="menu-section" data-section="content">
                <div class="menu-section-header">
                    <div class="menu-section-title">
                        <i class="fas fa-newspaper"></i>
                        <span>Konten</span>
                    </div>
                    <i class="fas fa-chevron-down menu-section-icon"></i>
                </div>
                <div class="menu-section-content">
                    <a href="{{ route('admin.posts.index') }}"
                        class="menu-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Artikel & Berita</span>
                        <span class="menu-item-tooltip">Artikel & Berita</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span>Kategori</span>
                        <span class="menu-item-tooltip">Kategori</span>
                    </a>
                    <a href="{{ route('admin.tags.index') }}"
                        class="menu-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Label</span>
                        <span class="menu-item-tooltip">Label</span>
                    </a>
                    <a href="{{ route('admin.comments.index') }}"
                        class="menu-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        <span>Komentar</span>
                        @if (App\Models\Comment::pending()->count() > 0)
                            <span class="menu-badge">{{ App\Models\Comment::pending()->count() }}</span>
                        @endif
                        <span class="menu-item-tooltip">Komentar</span>
                    </a>
                </div>
            </div>

            <!-- Landing Page Section -->
            <div class="menu-section" data-section="landing">
                <div class="menu-section-header">
                    <div class="menu-section-title">
                        <i class="fas fa-globe"></i>
                        <span>Halaman Utama</span>
                    </div>
                    <i class="fas fa-chevron-down menu-section-icon"></i>
                </div>
                <div class="menu-section-content">
                    <a href="{{ route('admin.sliders.index') }}"
                        class="menu-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>Banner Slider</span>
                        <span class="menu-item-tooltip">Banner Slider</span>
                    </a>
                    <a href="{{ route('admin.pages.index') }}"
                        class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Halaman</span>
                        <span class="menu-item-tooltip">Halaman</span>
                    </a>
                    <a href="{{ route('admin.programs.index') }}"
                        class="menu-item {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Program Masjid</span>
                        <span class="menu-item-tooltip">Program Masjid</span>
                    </a>
                    <a href="{{ route('admin.gallery.albums.index') }}"
                        class="menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <i class="fas fa-photo-video"></i>
                        <span>Galeri</span>
                        <span class="menu-item-tooltip">Galeri</span>
                    </a>
                    <a href="{{ route('admin.schedules.index') }}"
                        class="menu-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        <span>Jadwal Kegiatan</span>
                        <span class="menu-item-tooltip">Jadwal Kegiatan</span>
                    </a>
                    <a href="{{ route('admin.announcements.index') }}"
                        class="menu-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i>
                        <span>Pengumuman</span>
                        <span class="menu-item-tooltip">Pengumuman</span>
                    </a>
                </div>
            </div>

            <!-- People Section -->
            <div class="menu-section" data-section="people">
                <div class="menu-section-header">
                    <div class="menu-section-title">
                        <i class="fas fa-users"></i>
                        <span>Personalia</span>
                    </div>
                    <i class="fas fa-chevron-down menu-section-icon"></i>
                </div>
                <div class="menu-section-content">
                    <a href="{{ route('admin.staff.index') }}"
                        class="menu-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>Pengurus & Staf</span>
                        <span class="menu-item-tooltip">Pengurus & Staf</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <span>Testimoni</span>
                        <span class="menu-item-tooltip">Testimoni</span>
                    </a>
                </div>
            </div>

            <!-- Donations Section -->
            <div class="menu-section" data-section="donations">
                <div class="menu-section-header">
                    <div class="menu-section-title">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Donasi</span>
                    </div>
                    <i class="fas fa-chevron-down menu-section-icon"></i>
                </div>
                <div class="menu-section-content">
                    <a href="{{ route('admin.donations.index') }}"
                        class="menu-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i>
                        <span>Program Donasi</span>
                        <span class="menu-item-tooltip">Program Donasi</span>
                    </a>
                    <a href="{{ route('admin.donation-transactions.index') }}"
                        class="menu-item {{ request()->routeIs('admin.donation-transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Transaksi</span>
                        @if (App\Models\DonationTransaction::pending()->count() > 0)
                            <span class="menu-badge">{{ App\Models\DonationTransaction::pending()->count() }}</span>
                        @endif
                        <span class="menu-item-tooltip">Transaksi</span>
                    </a>
                </div>
            </div>

            <!-- Others Section -->
            <div class="menu-section" data-section="others">
                <div class="menu-section-header">
                    <div class="menu-section-title">
                        <i class="fas fa-ellipsis-h"></i>
                        <span>Lainnya</span>
                    </div>
                    <i class="fas fa-chevron-down menu-section-icon"></i>
                </div>
                <div class="menu-section-content">
                    <a href="{{ route('admin.contacts.index') }}"
                        class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan Masuk</span>
                        @if (App\Models\Contact::where('status', 'new')->count() > 0)
                            <span class="menu-badge">{{ App\Models\Contact::where('status', 'new')->count() }}</span>
                        @endif
                        <span class="menu-item-tooltip">Pesan Masuk</span>
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}"
                        class="menu-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Log Aktivitas</span>
                        <span class="menu-item-tooltip">Log Aktivitas</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <h1 class="header-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="header-right">
                <div class="header-search">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>

                <div class="header-notification">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">5</span>
                </div>

                <div class="header-profile">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                    <i class="fas fa-chevron-down" style="color: #9ca3af; font-size: 0.8rem;"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; cursor: pointer; color: var(--danger); font-size: 1.2rem; padding: 8px;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Sidebar Toggle (Desktop)
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        // Load saved state
        const isSidebarCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isSidebarCollapsed) {
            sidebar.classList.add('collapsed');
        }

        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('collapsed');

            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });

        // Accordion Menu with Auto-close other sections
        document.querySelectorAll('.menu-section-header').forEach(header => {
            header.addEventListener('click', function() {
                const section = this.parentElement;
                const isCollapsed = section.classList.contains('collapsed');

                // Jika sidebar dalam mode collapsed di desktop, jangan buka accordion
                if (window.innerWidth > 768 && sidebar.classList.contains('collapsed')) {
                    return;
                }

                // Close all other sections (auto-close)
                document.querySelectorAll('.menu-section').forEach(otherSection => {
                    if (otherSection !== section) {
                        otherSection.classList.add('collapsed');
                        const sectionName = otherSection.dataset.section;
                        localStorage.setItem('menu-collapsed-' + sectionName, 'true');
                    }
                });

                // Toggle current section
                section.classList.toggle('collapsed');

                // Save state to localStorage
                const sectionName = section.dataset.section;
                if (isCollapsed) {
                    localStorage.removeItem('menu-collapsed-' + sectionName);
                } else {
                    localStorage.setItem('menu-collapsed-' + sectionName, 'true');
                }
            });
        });

        // Restore accordion state from localStorage
        document.querySelectorAll('.menu-section').forEach(section => {
            const sectionName = section.dataset.section;
            const isCollapsed = localStorage.getItem('menu-collapsed-' + sectionName);
            if (isCollapsed === 'true') {
                section.classList.add('collapsed');
            }
        });

        // Mobile Hamburger Menu
        const hamburger = document.getElementById('hamburger');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            hamburger.classList.remove('active');
            sidebar.classList.remove('active');
            this.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Close sidebar when clicking menu item on mobile
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.menu-item, .menu-dashboard').forEach(item => {
                item.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                // Reset mobile styles on desktop
                hamburger.classList.remove('active');
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
