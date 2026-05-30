@extends('landing.layouts.app')

@section('title', 'Masjid Agung Al Azhar')

@push('styles')
    <style>
        :root {
            --primary: #0053C5;
            --primary-dark: #003a8c;
            --primary-deeper: #002766;
            --primary-light: #e6f0ff;
            --primary-lighter: #f0f6ff;
            --primary-glow: rgba(0, 83, 197, 0.15);
            --primary-vivid: #1a6dff;
            --secondary: #0f172a;
            --accent: #f59e0b;
            --accent-light: #fef3c7;
            --accent-warm: #ff8c00;
            --text: #334155;
            --text-light: #64748b;
            --text-dark: #0f172a;
            --bg: #f8fafc;
            --bg-alt: #f1f5f9;
            --white: #ffffff;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-xs: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow: 0 4px 24px rgba(0, 53, 140, 0.07);
            --shadow-md: 0 8px 30px rgba(0, 53, 140, 0.10);
            --shadow-lg: 0 16px 48px rgba(0, 53, 140, 0.12);
            --shadow-xl: 0 24px 64px rgba(0, 53, 140, 0.16);
            --shadow-glow: 0 0 30px rgba(0, 83, 197, 0.15);
            --shadow-card: 0 2px 12px rgba(0, 53, 140, 0.06), 0 0 0 1px rgba(0, 53, 140, 0.03);
            --shadow-card-hover: 0 20px 50px rgba(0, 53, 140, 0.14), 0 0 0 1px rgba(0, 83, 197, 0.08);
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-spring: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * {
            box-sizing: border-box;
        }

        /* ===== NOISE TEXTURE OVERLAY ===== */
        .main-content::before {
            content: '';
            position: fixed;
            inset: 0;
            opacity: 0.018;
            z-index: 0;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 256px 256px;
        }

        /* ===== SECTION WAVE DIVIDERS ===== */
        .wave-divider {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            margin-top: -1px;
        }

        .wave-divider svg {
            display: block;
            width: 100%;
            height: 50px;
        }

        .wave-divider.flip {
            transform: rotate(180deg);
            margin-top: 0;
            margin-bottom: -1px;
        }

        /* ===== WELCOME SECTION ===== */
        .welcome-section {
            padding: 0 1rem;
            text-align: center;
            background: var(--white);
            position: relative;
            z-index: 1;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .welcome-section .container {
            margin-top: -5rem; /* Adjust slightly upwards to visually balance the layout */
        }

        .welcome-section::before {
            content: none; /* Remove subtle gradient overlay */
        }

        .welcome-title {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            color: #1e293b;
            line-height: 1.15;
            margin-bottom: 2rem;
            letter-spacing: -0.03em;
            animation: welcomeFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
            z-index: 1;
        }

        .welcome-highlight {
            display: inline-block;
            background: linear-gradient(270deg, #003a8c, #9333ea, #003a8c);
            background-size: 300% 300%;
            color: var(--white);
            padding: 0.1em 0.5em;
            border-radius: 50px; /* Pill shape */
            position: relative;
            box-shadow: 0 4px 16px rgba(217, 70, 239, 0.25);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            animation: gradientShift 6s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .welcome-subtitle {
            font-size: clamp(0.95rem, 1.5vw, 1.15rem);
            color: var(--text-light);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.7;
            animation: welcomeFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
            position: relative;
            z-index: 1;
        }

        @keyframes welcomeFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
                filter: blur(3px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        /* ===== TOP INFO SECTION ===== */
        .top-info-section {
            padding: 0 1rem 3rem;
            background: var(--white);
            position: relative;
            z-index: 1;
        }

        .top-info-header {
            text-align: center;
            margin-bottom: 2.25rem;
        }

        .top-info-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--secondary);
            position: relative;
            display: inline-block;
            letter-spacing: 0.01em;
            padding-bottom: 0.5rem;
        }

        .top-info-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-vivid));
            border-radius: 50px;
        }

        /* ===== TOP INFO GRID ===== */
        .top-info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
            align-items: stretch;
        }

        .top-info-card {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: block;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: var(--shadow-card);
        }

        .top-info-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
        }

        .top-info-card-img {
            width: 100%;
            height: 100%;
            min-height: 280px;
            object-fit: cover;
            display: block;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .top-info-card:hover .top-info-card-img {
            transform: scale(1.04);
        }

        /* Center card is taller */
        .top-info-card.featured .top-info-card-img {
            min-height: 360px;
        }

        /* Gradient overlay at bottom */
        .top-info-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0) 100%);
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .top-info-card-categories {
            display: flex;
            gap: 0.4rem;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
        }

        .top-info-card-cat {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            background: var(--primary);
            color: var(--white);
        }

        .top-info-card-cat.alt {
            background: #ef4444;
        }

        .top-info-card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.4;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .top-info-card.featured .top-info-card-title {
            font-size: 1.15rem;
            -webkit-line-clamp: 3;
        }

        .top-info-card-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .top-info-card-meta i {
            color: var(--primary-vivid, #1a6dff);
            font-size: 0.7rem;
        }

        .top-info-card-meta .author-verified {
            color: #1da1f2;
        }

        .top-info-card-meta .dot-sep {
            opacity: 0.5;
        }

        .top-info-card-meta .dot-sep {
            opacity: 0.5;
        }

        /* Limit desktop/tablet to 3 items */
        @media (min-width: 769px) {
            .top-info-card:nth-child(n+4) {
                display: none !important;
            }
        }

        .top-info-btn {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--dark);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .top-info-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,83,197,0.2);
        }

        /* ===== TOP INFO RESPONSIVE ===== */
        @media (max-width: 900px) {
            .top-info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .top-info-card.featured {
                grid-column: 1 / -1;
            }

            .top-info-card-img {
                min-height: 220px;
            }

            .top-info-card.featured .top-info-card-img {
                min-height: 300px;
            }
        }

        @media (max-width: 768px) {
            .welcome-section {
                padding: 2rem 1rem 1rem; /* Reduced top padding significantly */
                min-height: auto;
            }

            .welcome-section .container {
                margin-top: 0;
            }

            .welcome-title {
                font-size: 1.5rem;
                margin-bottom: 0.5rem; /* Tighter margin */
            }

            .welcome-subtitle {
                font-size: 0.9rem;
                line-height: 1.4; /* Tighter line height */
            }

            .top-info-section {
                padding: 0 0 2rem;
            }

            /* Horizontal Slider on Mobile */
            .top-info-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                gap: 0.75rem;
                padding: 0 1rem;
                scrollbar-width: none; /* Firefox */
                scroll-padding-left: 1rem;
            }

            .top-info-grid::-webkit-scrollbar {
                display: none; /* Chrome, Safari */
            }

            .top-info-card {
                flex: 0 0 82%;
                scroll-snap-align: start;
                min-width: 0;
            }

            .top-info-card.featured {
                flex: 0 0 82%;
            }

            .top-info-card-img {
                min-height: 220px;
            }

            .top-info-card.featured .top-info-card-img {
                min-height: 220px;
            }

            /* Scroll Indicator Dots */
            .top-info-dots {
                display: flex !important;
                justify-content: center;
                gap: 6px;
                margin-top: 1rem;
                padding: 0 1rem;
            }

            .desktop-only {
                display: none !important;
            }

            .top-info-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: var(--border);
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .top-info-dot.active {
                background: var(--primary);
                width: 24px;
                border-radius: 4px;
            }

            .announcement-badge span {
                display: none;
            }
        }

        /* Default: Hide dots on desktop/tablet */
        .top-info-dots {
            display: none;
        }

        @media (max-width: 480px) {
            .welcome-section {
                padding: 1.5rem 1rem 0.5rem; /* Minimal padding */
                min-height: auto;
            }

            .welcome-section .container {
                margin-top: 0;
            }

            .welcome-title {
                font-size: 1.35rem;
                margin-bottom: 0.5rem;
            }

            .welcome-highlight {
                padding: 0.1em 0.45em;
                border-radius: 8px;
                font-size: 0.95em;
            }

            .top-info-card-img {
                min-height: 180px;
            }

            .top-info-card.featured .top-info-card-img {
                min-height: 200px;
            }

            .top-info-card-title {
                font-size: 0.88rem;
            }

            .top-info-card.featured .top-info-card-title {
                font-size: 1rem;
            }
        }
        .announcement-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 0.75rem 0;
            overflow: hidden;
            position: relative;
        }

        .announcement-bar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.04) 0%, transparent 30%, transparent 70%, rgba(255,255,255,0.04) 100%);
            pointer-events: none;
        }

        .announcement-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .announcement-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 0.55rem 1.1rem;
            border-radius: 50px;
            color: var(--white);
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .announcement-badge i {
            animation: announcePulse 2s ease-in-out infinite;
        }

        @keyframes announcePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .announcement-scroll {
            flex: 1;
            overflow: hidden;
            mask-image: linear-gradient(90deg, transparent, black 5%, black 95%, transparent);
        }

        .announcement-track {
            display: flex;
            animation: marquee 25s linear infinite;
            white-space: nowrap;
        }

        .announcement-track:hover {
            animation-play-state: paused;
        }

        .announcement-item {
            color: var(--white);
            font-size: 0.9rem;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .announcement-item::before {
            content: '•';
            opacity: 0.5;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }


        /* ===== SECTION STYLES ===== */
        .section {
            padding: 5.5rem 1rem;
            position: relative;
            z-index: 1;
        }

        .section-alt {
            background: var(--bg);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(0, 83, 197, 0.08) 100%);
            color: var(--primary);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.03em;
            border: 1px solid rgba(0, 83, 197, 0.08);
        }

        .section-title {
            font-size: clamp(1.85rem, 4vw, 2.6rem);
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 0.75rem;
            letter-spacing: -0.03em;
            position: relative;
            display: inline-block;
        }

        .section-header .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-vivid));
            border-radius: 50px;
        }

        .section-desc {
            color: var(--text-light);
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0.75rem auto 0;
            line-height: 1.7;
        }

        /* ===== PROGRAMS - NEWS LAYOUT ===== */

        /* Row 1: 2 Featured Cards */
        .programs-featured {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Row 2: 2x2 Grid + Sidebar */
        .programs-layout {
            display: grid;
            grid-template-columns: 1fr 1fr 340px;
            gap: 1.5rem;
            align-items: start;
        }

        /* Card Styles */
        .program-news-card {
            display: block;
            text-decoration: none;
            background: transparent;
            border-radius: 0;
            overflow: visible;
            border: none;
            transition: var(--transition);
            position: relative;
        }

        .program-news-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-vivid));
            opacity: 0;
            transition: var(--transition);
            z-index: 2;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .program-news-card:hover {
            transform: translateY(-6px);
        }

        .program-news-card:hover::before {
            opacity: 1;
        }

        .program-news-img-wrap {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-lg);
        }

        .program-news-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            background: var(--bg);
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .program-news-card:hover .program-news-img {
            transform: scale(1.05);
        }

        .program-news-featured .program-news-img {
            height: 230px;
        }

        .program-news-body {
            padding: 1rem 0;
        }

        .program-news-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--secondary);
            line-height: 1.4;
            margin-bottom: 0.35rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: var(--transition-fast);
        }

        .program-news-card:hover .program-news-title {
            color: var(--primary);
        }

        .program-news-featured .program-news-title {
            font-size: 1.05rem;
        }

        .program-news-meta {
            font-size: 0.78rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .program-news-meta i {
            color: var(--primary);
            font-size: 0.7rem;
        }

        /* Sidebar */
        .program-sidebar {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            grid-column: 3;
            grid-row: 1 / 3;
            box-shadow: var(--shadow-card);
        }

        .program-sidebar-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 1rem 1.15rem;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .program-sidebar-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .program-sidebar-list {
            padding: 0.5rem;
        }

        .program-sidebar-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: var(--radius);
            transition: var(--transition);
            text-decoration: none;
            border-bottom: 1px solid var(--border-light);
        }

        .program-sidebar-item:last-child {
            border-bottom: none;
        }

        .program-sidebar-item:hover {
            background: var(--primary-light);
            transform: translateX(3px);
        }

        .program-sidebar-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-vivid) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--white);
            font-size: 0.85rem;
            transition: var(--transition-spring);
        }

        .program-sidebar-item:hover .program-sidebar-icon {
            transform: scale(1.1);
        }

        .program-sidebar-info {
            flex: 1;
            min-width: 0;
        }

        .program-sidebar-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--secondary);
            line-height: 1.35;
            margin-bottom: 0.15rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .program-sidebar-date {
            font-size: 0.72rem;
            color: var(--text-light);
        }

        .program-sidebar-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.15rem 0.45rem;
            border-radius: 50px;
            font-size: 0.62rem;
            font-weight: 600;
            margin-top: 0.2rem;
        }

        .program-sidebar-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--border-light);
            text-align: center;
        }



        /* Responsive */
        @media (max-width: 1024px) {
            .programs-layout {
                grid-template-columns: 1fr 1fr;
            }

            .program-sidebar {
                grid-column: 1 / -1;
                grid-row: auto;
            }
        }

        @media (max-width: 640px) {
            .programs-featured {
                grid-template-columns: 1fr;
            }

            .programs-layout {
                grid-template-columns: 1fr;
            }

            .program-news-featured .program-news-img,
            .program-news-img {
                height: 180px;
            }
        }

        /* ===== POSTS GRID ===== */
        .posts-featured {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .post-card {
            background: transparent;
            border-radius: 0;
            overflow: visible;
            box-shadow: none;
            transition: var(--transition);
            border: none;
            position: relative;
        }

        .post-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-vivid), var(--primary));
            background-size: 200% 100%;
            opacity: 0;
            transition: var(--transition);
            z-index: 2;
        }

        .post-card:hover {
            transform: translateY(-8px);
        }

        .post-card:hover::before {
            opacity: 1;
        }

        .post-img-wrap {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-lg);
        }

        .post-img {
            height: 210px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .post-card:hover .post-img {
            transform: scale(1.04);
        }

        .post-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--primary);
            color: var(--white);
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
            z-index: 2;
            letter-spacing: 0.02em;
            box-shadow: 0 2px 8px rgba(0, 53, 140, 0.3);
        }

        .post-featured-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-warm));
            color: var(--white);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
        }

        .post-body {
            padding: 1.35rem 0;
        }

        .post-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }

        .post-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .post-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: var(--transition-fast);
        }

        .post-card:hover .post-title {
            color: var(--primary);
        }

        .post-excerpt {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .post-link:hover {
            gap: 0.8rem;
        }

        /* Latest Posts - Compact Grid */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .post-compact {
            display: flex;
            gap: 1rem;
            background: transparent;
            border-radius: 0;
            padding: 1rem 0;
            box-shadow: none;
            border: none;
            transition: var(--transition);
            text-decoration: none;
        }

        .post-compact:hover {
            transform: translateX(5px);
        }

        .post-compact-img {
            width: 90px;
            height: 90px;
            border-radius: var(--radius);
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        .post-compact-body {
            flex: 1;
            min-width: 0;
        }

        .post-compact-cat {
            font-size: 0.7rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
            letter-spacing: 0.04em;
        }

        .post-compact-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--secondary);
            line-height: 1.4;
            margin-bottom: 0.35rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-compact-date {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* ===== GALLERY GRID ===== */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: var(--radius);
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 53, 197, 0.9) 0%, transparent 100%);
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-title {
            color: var(--white);
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Albums */
        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .album-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-decoration: none;
        }

        .album-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .album-cover {
            height: 180px;
            background-size: cover;
            background-position: center;
        }

        .album-body {
            padding: 1.25rem;
        }

        .album-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .album-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .album-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* ===== SCHEDULE SECTION ===== */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .schedule-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: var(--transition);
        }

        .schedule-card:hover {
            box-shadow: var(--shadow-md);
        }

        .schedule-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .schedule-header i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .schedule-header h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .schedule-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg);
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .schedule-item:hover {
            background: var(--primary-light);
        }

        .schedule-time {
            background: var(--primary);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius);
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .schedule-date {
            text-align: center;
            background: var(--primary);
            color: var(--white);
            padding: 0.5rem;
            border-radius: var(--radius);
            min-width: 55px;
        }

        .schedule-date-day {
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1;
        }

        .schedule-date-month {
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .schedule-info {
            flex: 1;
        }

        .schedule-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.35rem;
        }

        .schedule-detail {
            font-size: 0.8rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .schedule-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--white);
        }

        .schedule-empty {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials-slider {
            position: relative;
        }

        .testimonials-track {
            display: flex;
            gap: 1.5rem;
            transition: transform 0.5s ease;
            flex-wrap: wrap;
        }

        .testimonial-card {
            flex: 0 0 calc(33.333% - 1rem);
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-card);
            position: relative;
            border: 1px solid var(--border);
            transition: var(--transition);
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-vivid));
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
        }

        .testimonial-quote {
            position: absolute;
            top: 1.2rem;
            right: 1.5rem;
            font-size: 2.5rem;
            color: var(--primary-light);
            opacity: 0.6;
        }

        .testimonial-rating {
            display: flex;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .testimonial-rating i {
            color: #e5e7eb;
            font-size: 0.9rem;
            transition: var(--transition-fast);
        }

        .testimonial-rating i.active {
            color: var(--accent);
            filter: drop-shadow(0 0 3px rgba(245, 158, 11, 0.4));
        }

        .testimonial-content {
            color: var(--text);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), rgba(0, 83, 197, 0.08));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            overflow: hidden;
            border: 3px solid var(--white);
            box-shadow: 0 0 0 2px var(--primary-light), var(--shadow);
        }

        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .testimonial-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .testimonial-role {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* ===== DONATIONS ===== */
        .donations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .donation-card {
            background: transparent;
            border-radius: 0;
            overflow: visible;
            box-shadow: none;
            transition: var(--transition);
            border: none;
            position: relative;
        }

        .donation-card:hover {
            transform: translateY(-8px);
        }

        .donation-img-wrap {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-lg);
        }

        .donation-img {
            height: 190px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .donation-card:hover .donation-img {
            transform: scale(1.04);
        }

        .donation-urgent {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: var(--white);
            padding: 0.4rem 0.85rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            animation: pulse-urgent 2s infinite;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(220, 38, 38, 0.4);
        }

        @keyframes pulse-urgent {
            0%, 100% { opacity: 1; box-shadow: 0 2px 10px rgba(220, 38, 38, 0.4); }
            50% { opacity: 0.85; box-shadow: 0 2px 20px rgba(220, 38, 38, 0.6); }
        }

        .donation-body {
            padding: 1.35rem 0;
        }

        .donation-category {
            font-size: 0.72rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }

        .donation-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .donation-desc {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .donation-progress {
            margin-bottom: 1rem;
        }

        .donation-progress-bar {
            height: 8px;
            background: var(--bg);
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .donation-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-vivid) 50%, var(--primary-dark) 100%);
            background-size: 200% 100%;
            border-radius: 50px;
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            animation: progressShine 2.5s ease infinite;
            position: relative;
        }

        .donation-progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 6px;
            height: 100%;
            background: rgba(255,255,255,0.6);
            border-radius: 50px;
            filter: blur(2px);
        }

        @keyframes progressShine {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        .donation-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .donation-raised {
            font-weight: 700;
            color: var(--primary);
        }

        .donation-target {
            color: var(--text-light);
        }

        .donation-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .donation-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-donate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, #003a8c 0%, #0284c7 100%);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-donate::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }

        .btn-donate:hover {
            background: linear-gradient(135deg, #0284c7 0%, #003a8c 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 83, 197, 0.35);
        }

        .btn-donate:hover::before {
            opacity: 1;
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            background: linear-gradient(135deg, #003a8c 0%, #0284c7 100%);
            padding: 6.5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("{{ asset('storage/img/background.svg') }}"); background-size: cover; background-position: center;
            pointer-events: none;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cta-decoration {
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cta-content {
            max-width: 720px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-size: clamp(1.85rem, 4.5vw, 2.8rem);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .cta-desc {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 2.25rem;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            background: var(--white);
            color: var(--primary);
            padding: 1.05rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            letter-spacing: 0.01em;
        }

        .btn-cta-primary:hover {
            background: var(--primary-light);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        }

        .btn-cta-outline {
            background: rgba(255, 255, 255, 0.06);
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 1.05rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .btn-cta-outline:hover {
            border-color: var(--white);
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-4px);
        }

        /* ===== LIGHTBOX ===== */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-img {
            max-width: 90%;
            max-height: 85vh;
            border-radius: var(--radius);
        }

        .lightbox-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: var(--white);
            font-size: 2rem;
            cursor: pointer;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: var(--transition);
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: var(--transition);
            border: none;
        }

        .lightbox-nav:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .lightbox-prev {
            left: 1rem;
        }

        .lightbox-next {
            right: 1rem;
        }

        /* ===== SOCIAL EMBED WRAPPERS ===== */
        .social-embed-wrapper {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border);
        }

        /* ===== UTILITIES ===== */
        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 2.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .quick-stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ===== MOBILE/TABLET HORIZONTAL CARD LAYOUT (like tarkambanyumas.com) ===== */
        @media (max-width: 991px) {
            /* --- POSTS: Featured Articles --- */
            .posts-featured {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            /* --- POSTS: Compact Grid --- */
            .posts-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .post-compact {
                padding: 1rem 0;
                border-bottom: 1px solid var(--border);
                flex-direction: row;
            }

            .post-compact:hover {
                transform: none;
            }

            .post-compact-img {
                width: 110px;
                height: 80px;
                order: 2;
                border-radius: var(--radius);
            }

            .post-compact-body {
                order: 1;
            }

            /* --- PROGRAMS: Featured + Grid --- */
            .programs-featured {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .programs-layout {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .program-news-card {
                display: flex;
                flex-direction: row;
                gap: 1rem;
                padding: 1.25rem 0;
                border-bottom: 1px solid var(--border);
                border-radius: 0;
            }

            .program-news-card:hover {
                transform: none;
            }

            .program-news-card::before {
                display: none;
            }

            .program-news-card .program-news-img-wrap {
                flex-shrink: 0;
                width: 130px;
                order: 2; /* Image on the right */
            }

            .program-news-card .program-news-img,
            .program-news-card.program-news-featured .program-news-img {
                height: 100%;
                min-height: 90px;
                max-height: 110px;
                border-radius: var(--radius);
            }

            .program-news-card .program-news-body {
                flex: 1;
                padding: 0;
                order: 1; /* Text on the left */
                min-width: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .program-news-card .program-news-title,
            .program-news-card.program-news-featured .program-news-title {
                font-size: 0.95rem;
            }

            /* --- PROGRAM SIDEBAR on mobile --- */
            .program-sidebar {
                grid-column: auto;
                grid-row: auto;
                border-radius: var(--radius-lg);
            }

            /* --- DONATIONS --- */
            .donations-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .donation-card {
                display: flex;
                flex-direction: row;
                gap: 1rem;
                padding: 1.25rem 0;
                border-bottom: 1px solid var(--border);
                border-radius: 0;
            }

            .donation-card:hover {
                transform: none;
            }

            .donation-card .donation-img-wrap {
                flex-shrink: 0;
                width: 130px;
                order: 2; /* Image on the right */
            }

            .donation-card .donation-img {
                height: 100%;
                min-height: 100px;
                border-radius: var(--radius);
            }

            .donation-card .donation-urgent {
                font-size: 0.55rem;
                padding: 0.2rem 0.5rem;
                top: 0.5rem;
                left: 0.5rem;
            }

            .donation-card .donation-body {
                flex: 1;
                padding: 0;
                order: 1; /* Text on the left */
                min-width: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .donation-card .donation-title {
                font-size: 0.95rem;
                margin-bottom: 0.3rem;
            }

            .donation-card .donation-desc {
                font-size: 0.82rem;
                margin-bottom: 0.5rem;
                -webkit-line-clamp: 2;
            }

            .donation-card .donation-progress,
            .donation-card .donation-meta {
                display: none; /* Hide progress bar on mobile for cleaner look */
            }

            .donation-card .btn-donate {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
                border-radius: 8px;
                width: auto;
                display: inline-flex;
            }
        }

        @media (max-width: 768px) {
            .section {
                padding: 3.5rem 1rem;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }

            .testimonials-slider {
                overflow: visible;
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .testimonials-track {
                flex-wrap: nowrap;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 1rem;
                scroll-padding-left: 1rem;
            }

            .testimonials-track::-webkit-scrollbar {
                display: none;
            }

            .testimonial-card {
                flex: 0 0 85%;
                scroll-snap-align: start;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .wave-divider svg {
                height: 30px;
            }

            /* Smaller thumbnails on phone */
            .program-news-card .program-news-img-wrap,
            .donation-card .donation-img-wrap {
                width: 110px;
            }

            .post-compact-img {
                width: 90px;
                height: 70px;
            }

            .program-news-card .program-news-title {
                font-size: 0.88rem;
            }

            .donation-card .donation-title {
                font-size: 0.88rem;
            }
        }

        @media (max-width: 480px) {
            .quick-stats-inner {
                grid-template-columns: repeat(2, 1fr);
                border-radius: var(--radius);
            }

            .quick-stat-icon {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }
        }

        /* ===== LAZY LOAD ===== */
        .lazy-bg {
            background-color: var(--bg);
            background-size: cover;
            background-position: center;
        }

        /* ===== ANIMATIONS ===== */
        @media (prefers-reduced-motion: no-preference) {
            .fade-up {
                opacity: 0;
                transform: translateY(35px);
                transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .fade-up.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* Staggered children animation */
            .fade-up:nth-child(2) { transition-delay: 0.08s; }
            .fade-up:nth-child(3) { transition-delay: 0.16s; }
            .fade-up:nth-child(4) { transition-delay: 0.24s; }
            .fade-up:nth-child(5) { transition-delay: 0.12s; }
            .fade-up:nth-child(6) { transition-delay: 0.2s; }

            /* Scale in */
            .scale-in {
                opacity: 0;
                transform: scale(0.92);
                transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .scale-in.visible {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
@endpush
@section('content')
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <h1 class="welcome-title">
                Selamat Datang<br>
                di Official Website<br>
                <span class="welcome-highlight">{{ setting('site_name', 'Tarkam Banyumas') }}</span>
            </h1>
            <p class="welcome-subtitle">
                {{ setting('site_description', 'Update Informasi Sepak Bola Tarkam Wilayah Banyumas dan Sekitarnya') }}
            </p>
        </div>
    </section>

    <!-- Top Info -->
    @if ($sliders->count() > 0)
        <section class="top-info-section">
            <div class="top-info-header">
                <h2 class="top-info-title">Banner Informasi</h2>
            </div>
            
            <div class="top-info-slider-wrapper" style="position: relative; max-width: 1200px; margin: 0 auto;">
                <div class="top-info-nav desktop-only">
                    <button class="top-info-btn prev-btn" style="position: absolute; left: -22px; top: 50%; transform: translateY(-50%); z-index: 10;"><i class="fas fa-chevron-left"></i></button>
                    <button class="top-info-btn next-btn" style="position: absolute; right: -22px; top: 50%; transform: translateY(-50%); z-index: 10;"><i class="fas fa-chevron-right"></i></button>
                </div>

                <div class="top-info-grid" id="topInfoGrid">
                @foreach ($sliders as $index => $slider)
                    <a href="{{ $slider->button_link ?? '#' }}"
                       class="top-info-card {{ $index === 1 ? 'featured' : '' }} fade-up">
                        <img src="{{ $slider->image ? asset('storage/' . $slider->image) : asset('storage/img/placeholder.jpg') }}"
                             alt="{{ $slider->title }}"
                             class="top-info-card-img"
                             loading="lazy"
                             onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                        <div class="top-info-card-overlay">
                            <div class="top-info-card-categories">
                                @if($slider->button_text)
                                    <span class="top-info-card-cat" style="background: #1d4ed8;">{{ $slider->button_text }}</span>
                                @endif
                                @if($slider->button_text_2)
                                    <span class="top-info-card-cat" style="background: #dc2626;">{{ $slider->button_text_2 }}</span>
                                @endif
                            </div>
                            <h3 class="top-info-card-title">{{ $slider->title }}</h3>
                            <div class="top-info-card-meta">
                                <i class="fas fa-check-circle author-verified" style="color: #3b82f6;"></i>
                                <span>Redaksi Masjid Agung Al Azhar</span>
                                <span class="dot-sep">•</span>
                                <span>{{ $slider->created_at ? $slider->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{-- Mobile Scroll Indicator Dots --}}
            <div class="top-info-dots" id="topInfoDots">
                @foreach ($sliders as $index => $slider)
                    <span class="top-info-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Announcements -->
    @if ($announcements->count() > 0)
        <div class="announcement-bar">
            <div class="announcement-inner">
                <div class="announcement-badge">
                    <i class="fas fa-bullhorn"></i>
                    <span>Pengumuman</span>
                </div>
                <div class="announcement-scroll">
                    <div class="announcement-track">
                        @foreach ($announcements as $item)
                            <span class="announcement-item">{{ $item->content }}</span>
                        @endforeach
                        @foreach ($announcements as $item)
                            <span class="announcement-item">{{ $item->content }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Targeted Ad Banner for Homepage -->
    @include('landing.partials.targeted-ad-banner')

    <!-- Ad Banner Section -->
    @if(isset($adBanners) && $adBanners->count() > 0)
        <section class="ad-banner-section" style="background: var(--white); padding: 2.5rem 1rem 0; text-align: center;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative;">
                <div class="ad-banner-carousel" id="adBannerCarousel" style="position: relative; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md);">
                    @foreach($adBanners as $index => $banner)
                        <a href="{{ $banner->url_link ?? '#' }}" {!! $banner->url_link ? 'target="_blank"' : 'style="pointer-events: none;"' !!} class="ad-banner-link" data-index="{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }}; transition: transform 0.3s ease; animation: fadeIn 0.5s ease-in-out;">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="width: 100%; height: auto; object-fit: cover; display: block;">
                        </a>
                    @endforeach

                    @if($adBanners->count() > 1)
                        <!-- Navigation Controls -->
                        <button class="ad-nav-btn ad-prev" aria-label="Previous Banner">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="ad-nav-btn ad-next" aria-label="Next Banner">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <!-- Progress Bar -->
                        <div class="ad-progress-bar">
                            <div class="ad-progress-fill"></div>
                        </div>
                    @endif
                </div>
                
                <style>
                    .ad-banner-carousel:hover .ad-banner-link {
                        transform: translateY(-2px);
                    }
                    .ad-nav-btn {
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                        background: rgba(255, 255, 255, 0.8);
                        color: var(--primary);
                        border: none;
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        font-size: 1.2rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        opacity: 0;
                        visibility: hidden;
                        transition: all 0.3s ease;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        z-index: 10;
                    }
                    .ad-banner-carousel:hover .ad-nav-btn {
                        opacity: 1;
                        visibility: visible;
                    }
                    .ad-nav-btn:hover {
                        background: var(--primary);
                        color: white;
                    }
                    .ad-prev { left: 15px; }
                    .ad-next { right: 15px; }
                    
                    .ad-progress-bar {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        width: 100%;
                        height: 4px;
                        background: rgba(255, 255, 255, 0.3);
                        z-index: 10;
                    }
                    .ad-progress-fill {
                        height: 100%;
                        width: 0%;
                        background: var(--primary);
                        transition: none; /* Controlled by JS/Animation */
                    }

                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                </style>
                @if($adBanners->count() > 1)
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const banners = document.querySelectorAll('#adBannerCarousel .ad-banner-link');
                        const progressFill = document.querySelector('.ad-progress-fill');
                        const btnPrev = document.querySelector('.ad-prev');
                        const btnNext = document.querySelector('.ad-next');
                        let currentIndex = 0;
                        const totalBanners = banners.length;
                        const slideDuration = 15000; // 15 seconds
                        let slideTimer;
                        let progressAnimation;

                        function resetProgress() {
                            progressFill.style.transition = 'none';
                            progressFill.style.width = '0%';
                            // Force reflow
                            void progressFill.offsetWidth;
                            progressFill.style.transition = `width ${slideDuration}ms linear`;
                            progressFill.style.width = '100%';
                        }

                        function showBanner(index) {
                            banners.forEach(b => b.style.display = 'none');
                            banners[index].style.display = 'block';
                            resetProgress();
                        }

                        function nextBanner() {
                            currentIndex = (currentIndex + 1) % totalBanners;
                            showBanner(currentIndex);
                            startTimer();
                        }

                        function prevBanner() {
                            currentIndex = (currentIndex - 1 + totalBanners) % totalBanners;
                            showBanner(currentIndex);
                            startTimer();
                        }

                        function startTimer() {
                            clearInterval(slideTimer);
                            slideTimer = setInterval(nextBanner, slideDuration);
                            resetProgress();
                        }

                        btnNext.addEventListener('click', (e) => {
                            e.preventDefault();
                            nextBanner();
                        });

                        btnPrev.addEventListener('click', (e) => {
                            e.preventDefault();
                            prevBanner();
                        });

                        // Start carousel
                        startTimer();
                    });
                </script>
                @endif
            </div>
        </section>
    @endif

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
            <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--bg)"/>
        </svg>
    </div>

    <!-- Posts Section -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-badge"><i class="fas fa-newspaper"></i> Terbaru</span>
                <h2 class="section-title">Berita & Artikel</h2>
                <p class="section-desc">Informasi terkini seputar kegiatan dan berita dari Masjid Agung Al-Azhar</p>
            </div>
            @if ($featuredPosts->count() > 0)
                <div class="posts-featured">
                    @foreach ($featuredPosts as $post)
                        <article class="post-card fade-up">
                            <div class="post-img-wrap">
                                <div class="post-img lazy-bg"
                                    data-bg="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}">
                                    <span class="post-category">{{ $post->category->name }}</span>
                                    <span class="post-featured-badge">Featured</span>
                                </div>
                            </div>
                            <div class="post-body">
                                <div class="post-meta">
                                    <span><i class="fas fa-user"></i> {{ $post->author->name }}</span>
                                    <span><i class="fas fa-calendar"></i> {{ $post->published_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="post-title">{{ $post->title }}</h3>
                                <p class="post-excerpt">{{ Str::limit(strip_tags($post->excerpt), 100) }}</p>
                                <a href="{{ route('blog.detail', $post->slug) }}" class="post-link">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="posts-grid">
                @foreach ($latestPosts as $post)
                    <a href="{{ route('blog.detail', $post->slug) }}" class="post-compact fade-up">
                        <div class="post-compact-img lazy-bg"
                            data-bg="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}"></div>
                        <div class="post-compact-body">
                            <span class="post-compact-cat">{{ $post->category->name }}</span>
                            <h4 class="post-compact-title">{{ Str::limit($post->title, 50) }}</h4>
                            <span class="post-compact-date">{{ $post->published_at->format('d M Y') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-4 fade-up">
                <style>
                    .btn-aesthetic {
                        display: inline-flex;
                        align-items: center;
                        gap: 0.75rem;
                        padding: 0.85rem 2.5rem;
                        background: linear-gradient(135deg, var(--primary) 0%, #9333ea 100%);
                        color: var(--white) !important;
                        border-radius: 50px;
                        font-weight: 600;
                        font-size: 1rem;
                        text-decoration: none;
                        box-shadow: 0 10px 20px rgba(147, 51, 234, 0.2);
                        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                        position: relative;
                        overflow: hidden;
                        z-index: 1;
                    }
                    .btn-aesthetic::before {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background: linear-gradient(135deg, #9333ea 0%, var(--primary) 100%);
                        z-index: -1;
                        transition: opacity 0.4s ease;
                        opacity: 0;
                    }
                    .btn-aesthetic:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 15px 30px rgba(147, 51, 234, 0.35);
                    }
                    .btn-aesthetic:hover::before {
                        opacity: 1;
                    }
                    .btn-aesthetic i {
                        transition: transform 0.3s ease;
                    }
                    .btn-aesthetic:hover i {
                        transform: translateX(6px);
                    }
                    
                    /* Social Buttons Aesthetic */
                    .btn-social {
                        display: inline-flex;
                        align-items: center;
                        gap: 0.75rem;
                        padding: 0.85rem 2.5rem;
                        color: var(--white) !important;
                        border-radius: 50px;
                        font-weight: 600;
                        font-size: 1rem;
                        text-decoration: none;
                        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                        position: relative;
                        overflow: hidden;
                        z-index: 1;
                        border: none;
                    }
                    .btn-social::before {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; right: 0; bottom: 0;
                        z-index: -1;
                        transition: opacity 0.4s ease;
                        opacity: 0;
                    }
                    .btn-social:hover {
                        transform: translateY(-4px);
                        color: var(--white);
                    }
                    .btn-social:hover::before {
                        opacity: 1;
                    }
                    .btn-social i {
                        font-size: 1.2rem;
                        transition: transform 0.4s ease;
                    }
                    .btn-social:hover i {
                        transform: scale(1.15) rotate(5deg);
                    }

                    .btn-ig {
                        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
                        box-shadow: 0 10px 20px rgba(220, 39, 67, 0.2);
                    }
                    .btn-ig::before {
                        background: linear-gradient(45deg, #bc1888 0%, #cc2366 25%, #dc2743 50%, #e6683c 75%, #f09433 100%);
                    }
                    .btn-ig:hover {
                        box-shadow: 0 15px 30px rgba(220, 39, 67, 0.35);
                    }

                    .btn-yt {
                        background: linear-gradient(45deg, #ff0000 0%, #cc0000 100%);
                        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.2);
                    }
                    .btn-yt::before {
                        background: linear-gradient(45deg, #cc0000 0%, #ff0000 100%);
                    }
                    .btn-yt:hover {
                        box-shadow: 0 15px 30px rgba(255, 0, 0, 0.35);
                    }
                </style>
                <a href="{{ route('blog') }}" class="btn-aesthetic">
                    Lihat Semua Berita <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider flip" style="background: var(--bg);">
        <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
            <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--white)"/>
        </svg>
    </div>

    <!-- Programs Section - News Layout -->
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-badge"><i class="fas fa-mosque"></i> Kegiatan</span>
                <h2 class="section-title">Layanan & Kegiatan</h2>
                <p class="section-desc">Program dakwah dan kegiatan rutin Masjid Agung Al-Azhar</p>
            </div>

            <!-- Row 1: 2 Featured Cards -->
            <div class="programs-featured fade-up">
                @foreach ($programs->take(2) as $program)
                    <a href="{{ route('program.detail', $program->slug) }}" class="program-news-card program-news-featured">
                        <div class="program-news-img-wrap">
                            <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('storage/img/placeholder.jpg') }}"
                                alt="{{ $program->name }}" class="program-news-img" loading="lazy"
                                onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                        </div>
                        <div class="program-news-body">
                            <h3 class="program-news-title">{{ $program->name }}</h3>
                            <div class="program-news-meta">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $program->frequency }}</span>
                            </div>
                            <p class="program-news-desc" style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">{{ Str::limit(strip_tags($program->description), 100) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Row 2: Grid 2x2 + Sidebar -->
            <div class="programs-layout fade-up">
                @foreach ($programs->skip(2)->take(4) as $program)
                    <a href="{{ route('program.detail', $program->slug) }}" class="program-news-card">
                        <div class="program-news-img-wrap">
                            <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('storage/img/placeholder.jpg') }}"
                                alt="{{ $program->name }}" class="program-news-img" loading="lazy"
                                onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                        </div>
                        <div class="program-news-body">
                            <h3 class="program-news-title">{{ $program->name }}</h3>
                            <div class="program-news-meta">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $program->frequency }}</span>
                            </div>
                            <p class="program-news-desc" style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">{{ Str::limit(strip_tags($program->description), 100) }}</p>
                        </div>
                    </a>
                @endforeach

                <!-- Right: Sidebar - Sisa Program -->
                <div class="program-sidebar">
                    <div class="program-sidebar-header">
                        <i class="fas fa-list-ul"></i>
                        Layanan & Kegiatan
                    </div>
                    <div class="program-sidebar-list">
                        @foreach ($programs->skip(6)->take(5) as $program)
                            <a href="{{ route('program.detail', $program->slug) }}" class="program-sidebar-item">
                                <div class="program-sidebar-icon">
                                    <i class="{{ $program->icon ?? 'fas fa-mosque' }}"></i>
                                </div>
                                <div class="program-sidebar-info">
                                    <div class="program-sidebar-title">{{ $program->name }}</div>
                                    <div class="program-sidebar-date">
                                        {{ $program->frequency }}
                                        @if ($program->location)
                                            · {{ $program->location }}
                                        @endif
                                    </div>
                                    @if ($program->speaker)
                                        <span class="program-sidebar-badge">{{ $program->speaker }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="program-sidebar-footer" style="padding-top: 1.5rem; border-top: none;">
                        <a href="{{ route('programs') }}" class="btn-aesthetic" style="width: 100%; justify-content: center; font-size: 0.9rem; padding: 0.75rem 1.5rem;">
                            Lihat Semua Layanan <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
            <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--bg)"/>
        </svg>
    </div>

    <!-- Instagram Feed Section -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-badge"><i class="fab fa-instagram"></i> Social Media</span>
                <h2 class="section-title">Instagram @masjidagungalazhar</h2>
            </div>
            
            <div class="text-center fade-up" style="margin-bottom: 2rem;">
                <p>Ikuti kegiatan terbaru kami di Instagram <a href="https://instagram.com/masjidagungalazhar" target="_blank" style="color: var(--primary); font-weight: bold; text-decoration: none;">@masjidagungalazhar</a></p>
            </div>

            <div class="fade-up">
                <style>
                    .instagram-grid {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        gap: 15px;
                        justify-items: center;
                    }
                    @media (max-width: 768px) {
                        .instagram-grid {
                            grid-template-columns: 1fr;
                        }
                    }
                    .instagram-item {
                        width: 100%;
                        display: flex;
                        justify-content: center;
                    }
                    /* Force Instagram embeds to fit container and prevent horizontal scroll */
                    .instagram-item iframe, 
                    .instagram-item .instagram-media {
                        min-width: 100% !important;
                        max-width: 100% !important;
                        width: 100% !important;
                    }
                </style>
                <div class="instagram-grid">
                    <!-- Instagram Post 1 -->
                    <div class="instagram-item">
                        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/{{ setting('ig_post_1', 'C-v1M-LykbU') }}/" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:12px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:100px; padding:0; width:100%;"></blockquote >
                    </div>
                    <!-- Instagram Post 2 -->
                    <div class="instagram-item">
                        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/{{ setting('ig_post_2', 'C-v0_Z_S2c7') }}/" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:12px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:100px; padding:0; width:100%;"></blockquote >
                    </div>
                    <!-- Instagram Post 3 -->
                    <div class="instagram-item">
                        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/{{ setting('ig_post_3', 'C-v01qNSsL4') }}/" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:12px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:100px; padding:0; width:100%;"></blockquote >
                    </div>
                </div>
                <!-- Script Resmi Instagram untuk render embed -->
                <script async src="//www.instagram.com/embed.js"></script>
            </div>

            <div class="text-center mt-4 fade-up">
                <a href="https://instagram.com/masjidagungalazhar" target="_blank" class="btn-social btn-ig">
                    <i class="fab fa-instagram"></i> Kunjungi Instagram Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider flip" style="background: var(--bg);">
        <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
            <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--white)"/>
        </svg>
    </div>

    <!-- YouTube Video Gallery Section -->
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-badge"><i class="fab fa-youtube"></i> Video</span>
                <h2 class="section-title">Video Gallery</h2>
                <p class="section-desc">Saksikan kajian, khutbah, dan kegiatan Masjid Agung Al-Azhar</p>
            </div>

            <div class="fade-up">
                <style>
                    .youtube-grid {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        gap: 15px;
                    }
                    @media (max-width: 768px) {
                        .youtube-grid {
                            grid-template-columns: 1fr;
                        }
                    }
                    .youtube-video-container {
                        position: relative;
                        padding-bottom: 56.25%; /* Aspek rasio 16:9 */
                        height: 0;
                        overflow: hidden;
                        border-radius: 12px;
                        box-shadow: var(--shadow-sm);
                    }
                    .youtube-video-container iframe {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        border: 0;
                    }
                </style>
                <div class="youtube-grid">
                    <!-- Video 1 -->
                    <div class="youtube-video-container">
                        <!-- Ganti src= dengan URL Embed YouTube Anda -->
                        <iframe src="https://www.youtube.com/embed/{{ setting('yt_video_1', 'LXb3EKWsInQ') }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <!-- Video 2 -->
                    <div class="youtube-video-container">
                        <iframe src="https://www.youtube.com/embed/{{ setting('yt_video_2', 'wXhTHyIgQ_U') }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <!-- Video 3 -->
                    <div class="youtube-video-container">
                        <iframe src="https://www.youtube.com/embed/{{ setting('yt_video_3', 'jfKfPfyJRdk') }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 fade-up">
                <a href="https://www.youtube.com/@MasjidAgungAlAzhar" target="_blank" class="btn-social btn-yt">
                    <i class="fab fa-youtube"></i> Kunjungi Channel YouTube Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Donations Section -->
    @if ($donations->count() > 0)
        <!-- Wave Divider -->
        <div class="wave-divider flip" style="background: var(--bg);">
            <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
                <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--white)"/>
            </svg>
        </div>
        <section class="section">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge"><i class="fas fa-heart"></i> Donasi</span>
                    <h2 class="section-title">Salurkan Donasi Anda</h2>
                    <p class="section-desc">Mari berpartisipasi dalam program kebaikan untuk umat</p>
                </div>
                <div class="donations-grid">
                    @foreach ($donations as $donation)
                        <div class="donation-card fade-up">
                            <div class="donation-img-wrap">
                                @if ($donation->is_urgent ?? false)
                                    <div class="donation-urgent"><i class="fas fa-exclamation-circle"></i> URGENT</div>
                                @endif
                                <div class="donation-img lazy-bg"
                                    data-bg="{{ $donation->image ? asset('storage/' . $donation->image) : '' }}"></div>
                            </div>
                            <div class="donation-body">
                                <span
                                    class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}</span>
                                <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                                <p class="donation-desc">{{ Str::limit($donation->description, 80) }}</p>



                                <a href="{{ route('donations.show', $donation->slug) }}" class="btn-donate">
                                    Donasi Sekarang <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4 fade-up">
                    <a href="{{ route('donations') }}" class="btn-aesthetic">
                        Lihat Semua Program Donasi <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials Section -->
    @if ($testimonials->count() > 0)
        <!-- Wave Divider -->
        <div class="wave-divider">
            <svg viewBox="0 0 1200 50" preserveAspectRatio="none">
                <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50 Z" fill="var(--bg)"/>
            </svg>
        </div>
        <section class="section section-alt">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge"><i class="fas fa-comments"></i> Ulasan</span>
                    <h2 class="section-title">Testimonial</h2>
                    <p class="section-desc">Apa kata jamaah tentang Masjid Agung Al-Azhar</p>
                </div>
                <div class="testimonials-slider fade-up">
                    <div class="testimonials-track" id="testimonialTrack">
                        @foreach ($testimonials as $testimonial)
                            <div class="testimonial-card">
                                <i class="fas fa-quote-right testimonial-quote"></i>
                                <div class="testimonial-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="testimonial-content">"{{ Str::limit($testimonial->content, 150) }}"</p>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar">
                                        @if ($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                alt="{{ $testimonial->name }}" loading="lazy">
                                        @else
                                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="testimonial-name">{{ $testimonial->name }}</h4>
                                        <p class="testimonial-role">{{ $testimonial->role }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif


@endsection
@push('scripts')
    <script>
        // Lazy Load Background Images
        document.addEventListener('DOMContentLoaded', () => {
            const lazyBgs = document.querySelectorAll('.lazy-bg[data-bg]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bg = entry.target.dataset.bg;
                        if (bg) entry.target.style.backgroundImage = `url('${bg}')`;
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '100px'
            });

            lazyBgs.forEach(el => observer.observe(el));
        });

        // Fade Up & Scale In Animation
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '50px'
        });

        document.querySelectorAll('.fade-up, .scale-in').forEach(el => fadeObserver.observe(el));

        // Hero Slider
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');
        let heroIndex = 0;
        let heroInterval;

        function showHeroSlide(index) {
            heroSlides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            heroDots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            heroIndex = index;
        }

        function nextHeroSlide() {
            showHeroSlide((heroIndex + 1) % heroSlides.length);
        }

        function startHeroSlider() {
            heroInterval = setInterval(nextHeroSlide, 5000);
        }

        heroDots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                clearInterval(heroInterval);
                showHeroSlide(i);
                startHeroSlider();
            });
        });

        if (heroSlides.length > 1) startHeroSlider();

        // Smooth scroll for hero scroll indicator
        document.querySelector('.hero-scroll-indicator')?.addEventListener('click', () => {
            const target = document.querySelector('.announcement-bar') || document.querySelector('.section');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });

        document.addEventListener('keydown', (e) => {
            if (!document.getElementById('lightbox')?.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changeLightbox(-1);
            if (e.key === 'ArrowRight') changeLightbox(1);
        });

        // ===== TOP INFO MOBILE SLIDER DOTS =====
        const topInfoGrid = document.getElementById('topInfoGrid');
        const topInfoDots = document.querySelectorAll('.top-info-dot');
        
        if (topInfoGrid && topInfoDots.length > 0) {
            // Update dots on scroll
            let scrollTimeout;
            topInfoGrid.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function() {
                    const cards = topInfoGrid.querySelectorAll('.top-info-card');
                    const gridLeft = topInfoGrid.scrollLeft;
                    const gridWidth = topInfoGrid.offsetWidth;
                    
                    let activeIndex = 0;
                    let minDistance = Infinity;
                    
                    cards.forEach(function(card, i) {
                        const cardCenter = card.offsetLeft + card.offsetWidth / 2 - gridLeft;
                        const distance = Math.abs(cardCenter - gridWidth / 2);
                        if (distance < minDistance) {
                            minDistance = distance;
                            activeIndex = i;
                        }
                    });
                    
                    topInfoDots.forEach(function(dot, i) {
                        dot.classList.toggle('active', i === activeIndex);
                    });
                }, 50);
            });
            
            // Click dot to scroll to card
            topInfoDots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const cards = topInfoGrid.querySelectorAll('.top-info-card');
                    if (cards[index]) {
                        cards[index].scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
                    }
                });
            });
        }

        // ===== TOP INFO DESKTOP SLIDER =====
        const desktopPrevBtn = document.querySelector('.top-info-nav .prev-btn');
        const desktopNextBtn = document.querySelector('.top-info-nav .next-btn');

        if (topInfoGrid && desktopPrevBtn && desktopNextBtn) {
            let isAnimating = false;

            function rotateTopInfo(direction) {
                if (window.innerWidth <= 768 || isAnimating) return;
                isAnimating = true;

                const cards = Array.from(topInfoGrid.querySelectorAll('.top-info-card'));
                if (cards.length < 4) {
                    isAnimating = false;
                    return;
                }

                // Fade out
                cards.forEach(card => card.style.opacity = '0');
                
                setTimeout(() => {
                    // Reorder DOM
                    if (direction === 'next') {
                        topInfoGrid.appendChild(cards[0]);
                    } else {
                        topInfoGrid.prepend(cards[cards.length - 1]);
                    }

                    // Update featured class
                    const newCards = Array.from(topInfoGrid.querySelectorAll('.top-info-card'));
                    newCards.forEach(card => card.classList.remove('featured'));
                    newCards[1].classList.add('featured');

                    // Small delay to allow DOM to recalculate before fading in
                    setTimeout(() => {
                        newCards.forEach(card => card.style.opacity = '1');
                        isAnimating = false;
                    }, 50);
                }, 400); // Wait for fade out (matches CSS transition)
            }

            desktopNextBtn.addEventListener('click', () => rotateTopInfo('next'));
            desktopPrevBtn.addEventListener('click', () => rotateTopInfo('prev'));
            
            // Auto-play
            let topInfoInterval = setInterval(() => {
                rotateTopInfo('next');
            }, 6000);

            // Pause on hover
            topInfoGrid.addEventListener('mouseenter', () => clearInterval(topInfoInterval));
            topInfoGrid.addEventListener('mouseleave', () => {
                topInfoInterval = setInterval(() => {
                    rotateTopInfo('next');
                }, 6000);
            });
        }

    </script>
@endpush
