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
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
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
        }

        .sidebar-title h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .sidebar-title p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-section-title {
            padding: 0 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
        }

        .menu-item i {
            width: 25px;
            margin-right: 12px;
            text-align: center;
        }

        .menu-badge {
            float: right;
            background: var(--danger);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
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

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .header-search {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="sidebar-title">
                <h3>Al Azhar</h3>
                <p>Admin Panel</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main Menu</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Content</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Posts</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-tags"></i>
                    <span>Tags</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-comments"></i>
                    <span>Comments</span>
                    <span class="menu-badge">5</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Landing Page</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-images"></i>
                    <span>Sliders</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Pages</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Programs</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-photo-video"></i>
                    <span>Gallery</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-clock"></i>
                    <span>Schedules</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">People</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Staff</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-star"></i>
                    <span>Testimonials</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Donations</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span>Campaigns</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-receipt"></i>
                    <span>Transactions</span>
                    <span class="menu-badge">3</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Others</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-envelope"></i>
                    <span>Contacts</span>
                    <span class="menu-badge">2</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
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

    @stack('scripts')
</body>

</html>
