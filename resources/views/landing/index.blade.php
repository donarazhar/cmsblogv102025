@extends('landing.layouts.app')

@section('title', 'Masjid Agung Al Azhar')

@push('styles')
    <style>
        :root {
            --primary: #0053C5;
            --primary-dark: #003d94;
            --primary-light: #e8f0fc;
            --secondary: #1e293b;
            --accent: #f59e0b;
            --text: #334155;
            --text-light: #64748b;
            --bg: #f8fafc;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
            --shadow-lg: 0 10px 40px rgba(0, 83, 197, 0.12);
            --radius: 12px;
            --radius-lg: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            position: relative;
            height: 85vh;
            min-height: 500px;
            max-height: 800px;
            overflow: hidden;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.8s ease;
            background-size: cover;
            background-position: center;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Text Position */
        .hero-content.text-left {
            justify-content: flex-start;
        }

        .hero-content.text-center {
            justify-content: center;
            text-align: center;
        }

        .hero-content.text-right {
            justify-content: flex-end;
            text-align: right;
        }

        .hero-text {
            max-width: 650px;
        }

        .hero-content.text-center .hero-text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-content.text-center .hero-buttons {
            justify-content: center;
        }

        .hero-content.text-right .hero-buttons {
            justify-content: flex-end;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .hero-description {
            font-size: clamp(0.8rem, 1.5vw, 0.9rem);
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.75rem;
            line-height: 1.6;
            max-width: 550px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: var(--radius);
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--white);
            color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--white);
        }

        /* Hero Controls */
        .hero-controls {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .hero-dot.active {
            background: var(--white);
            transform: scale(1.2);
        }

        /* ===== ANNOUNCEMENT BAR ===== */
        .announcement-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 0.75rem 0;
            overflow: hidden;
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
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: var(--white);
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
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
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: 5rem 1rem;
        }

        .section-alt {
            background: var(--bg);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 0.75rem;
        }

        .section-desc {
            color: var(--text-light);
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
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
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: var(--transition);
        }

        .program-news-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }

        .program-news-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            background: var(--bg);
        }

        .program-news-featured .program-news-img {
            height: 220px;
        }

        .program-news-body {
            padding: 0.85rem 1rem;
        }

        .program-news-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--secondary);
            line-height: 1.4;
            margin-bottom: 0.3rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            grid-column: 3;
            grid-row: 1 / 3;
        }

        .program-sidebar-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 0.85rem 1.1rem;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .program-sidebar-list {
            padding: 0.4rem;
        }

        .program-sidebar-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            border-bottom: 1px solid #f1f5f9;
        }

        .program-sidebar-item:last-child {
            border-bottom: none;
        }

        .program-sidebar-item:hover {
            background: var(--primary-light);
        }

        .program-sidebar-icon {
            width: 38px;
            height: 38px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--white);
            font-size: 0.85rem;
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
            padding: 0.65rem 1rem;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }

        .program-sidebar-footer a {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.82rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: var(--transition);
        }

        .program-sidebar-footer a:hover {
            gap: 0.6rem;
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
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .post-img {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .post-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--primary);
            color: var(--white);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .post-featured-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--accent);
            color: var(--white);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .post-body {
            padding: 1.25rem;
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
            gap: 0.75rem;
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
            background: var(--white);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-decoration: none;
        }

        .post-compact:hover {
            transform: translateX(5px);
            box-shadow: var(--shadow-lg);
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
            padding: 1.5rem;
            box-shadow: var(--shadow);
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
            overflow: hidden;
        }

        .testimonials-track {
            display: flex;
            gap: 1.5rem;
            transition: transform 0.5s ease;
        }

        .testimonial-card {
            flex: 0 0 calc(33.333% - 1rem);
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow);
            position: relative;
        }

        .testimonial-quote {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 2rem;
            color: var(--primary-light);
        }

        .testimonial-rating {
            display: flex;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .testimonial-rating i {
            color: #e5e7eb;
            font-size: 0.9rem;
        }

        .testimonial-rating i.active {
            color: var(--accent);
        }

        .testimonial-content {
            color: var(--text);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .testimonial-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            overflow: hidden;
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
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .donation-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .donation-img {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .donation-urgent {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: #dc2626;
            color: var(--white);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            animation: pulse-urgent 2s infinite;
        }

        @keyframes pulse-urgent {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .donation-body {
            padding: 1.25rem;
        }

        .donation-category {
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .donation-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .donation-desc {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
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
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50px;
            transition: width 1s ease;
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
            padding: 0.875rem;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-donate:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 5rem 1rem;
            text-align: center;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1rem;
        }

        .cta-desc {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
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
            padding: 1rem 2rem;
            border-radius: var(--radius);
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-cta-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .btn-cta-outline {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.4);
            padding: 1rem 2rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-cta-outline:hover {
            border-color: var(--white);
            background: rgba(255, 255, 255, 0.1);
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

        /* ===== UTILITIES ===== */
        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 2.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .testimonial-card {
                flex: 0 0 calc(50% - 0.75rem);
            }
        }

        @media (max-width: 768px) {
            .section {
                padding: 3.5rem 1rem;
            }

            .hero {
                height: 60vh;
                min-height: 380px;
                max-height: 550px;
            }

            .hero-content {
                padding: 0 1.25rem;
                align-items: flex-end;
                padding-bottom: 3.5rem;
            }

            .hero-text {
                max-width: 100%;
            }

            .hero-title {
                font-size: 1.5rem;
                line-height: 1.25;
                margin-bottom: 0.5rem;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            .hero-subtitle {
                font-size: 0.9rem;
                line-height: 1.4;
                margin-bottom: 0.5rem;
            }

            .hero-description {
                font-size: 0.78rem;
                line-height: 1.5;
                margin-bottom: 1rem;
                max-width: 100%;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .hero-buttons {
                flex-direction: row;
                gap: 0.5rem;
            }

            .hero-buttons .btn {
                padding: 0.65rem 1.1rem;
                font-size: 0.8rem;
            }

            .hero-content.text-right {
                text-align: left;
                justify-content: flex-start;
            }

            .hero-content.text-right .hero-buttons {
                justify-content: flex-start;
            }

            .announcement-badge span {
                display: none;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }

            .testimonial-card {
                flex: 0 0 100%;
            }

            .cta-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .hero {
                height: 55vh;
                min-height: 320px;
                max-height: 450px;
            }

            .hero-content {
                padding: 0 1rem;
                padding-bottom: 3rem;
            }

            .hero-title {
                font-size: 1.25rem;
            }

            .hero-subtitle {
                font-size: 0.82rem;
            }

            .hero-description {
                font-size: 0.75rem;
                -webkit-line-clamp: 2;
            }

            .hero-buttons .btn {
                padding: 0.55rem 0.9rem;
                font-size: 0.75rem;
            }

            .hero-controls {
                bottom: 1rem;
            }

            .hero-dot {
                width: 8px;
                height: 8px;
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
                transform: translateY(20px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }

            .fade-up.visible {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        @foreach ($sliders as $index => $slider)
            @php
                $overlayOpacity = ($slider->overlay_opacity ?? 50) / 100;
                $textPos = $slider->text_position ?? 'left';
            @endphp
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }} lazy-bg"
                data-bg="{{ asset('storage/' . $slider->image) }}">
                {{-- Dynamic Overlay (primary blue, opacity from admin) --}}
                <div class="hero-overlay" style="background: linear-gradient(135deg, rgba(0,53,197,{{ $overlayOpacity }}) 0%, rgba(0,61,148,{{ $overlayOpacity * 0.5 }}) 100%);"></div>
                <div class="hero-content text-{{ $textPos }}">
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $slider->title }}</h1>
                        @if ($slider->subtitle)
                            <p class="hero-subtitle">{{ $slider->subtitle }}</p>
                        @endif
                        @if ($slider->description)
                            <p class="hero-description">{{ Str::limit($slider->description, 200) }}</p>
                        @endif
                        <div class="hero-buttons">
                            @if ($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn btn-primary">
                                    {{ $slider->button_text }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                            @if ($slider->button_text_2 && $slider->button_link_2)
                                <a href="{{ $slider->button_link_2 }}" class="btn btn-outline">
                                    {{ $slider->button_text_2 }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($sliders->count() > 1)
            <div class="hero-controls">
                @foreach ($sliders as $index => $slider)
                    <button class="hero-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </section>
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
                            <span class="announcement-item">{{ $item->title }}</span>
                        @endforeach
                        @foreach ($announcements as $item)
                            <span class="announcement-item">{{ $item->title }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Posts Section -->
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <h2 class="section-title">Berita & Artikel</h2>
            </div>
            @if ($featuredPosts->count() > 0)
                <div class="posts-featured">
                    @foreach ($featuredPosts as $post)
                        <article class="post-card fade-up">
                            <div class="post-img lazy-bg"
                                data-bg="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}">
                                <span class="post-category">{{ $post->category->name }}</span>
                                <span class="post-featured-badge">Featured</span>
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
                <a href="{{ route('blog') }}" class="btn btn-primary"
                    style="background: var(--primary); color: var(--white);">
                    Lihat Semua Berita <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Programs Section - News Layout -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-header fade-up">
                <h2 class="section-title">Program Kami</h2>
            </div>

            <!-- Row 1: 2 Featured Cards -->
            <div class="programs-featured fade-up">
                @foreach ($programs->take(2) as $program)
                    <a href="{{ route('program.detail', $program->slug) }}" class="program-news-card program-news-featured">
                        <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('storage/img/placeholder.jpg') }}"
                            alt="{{ $program->name }}" class="program-news-img" loading="lazy"
                            onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                        <div class="program-news-body">
                            <h3 class="program-news-title">{{ $program->name }}</h3>
                            <div class="program-news-meta">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $program->frequency }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Row 2: Grid 2x2 + Sidebar -->
            <div class="programs-layout fade-up">
                @foreach ($programs->skip(2)->take(4) as $program)
                    <a href="{{ route('program.detail', $program->slug) }}" class="program-news-card">
                        <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('storage/img/placeholder.jpg') }}"
                            alt="{{ $program->name }}" class="program-news-img" loading="lazy"
                            onerror="this.src='{{ asset('storage/img/placeholder.jpg') }}'">
                        <div class="program-news-body">
                            <h3 class="program-news-title">{{ $program->name }}</h3>
                            <div class="program-news-meta">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $program->frequency }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                <!-- Right: Sidebar - Sisa Program -->
                <div class="program-sidebar">
                    <div class="program-sidebar-header">
                        <i class="fas fa-list-ul"></i>
                        Program Kegiatan
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
                    <div class="program-sidebar-footer">
                        <a href="{{ route('programs') }}">
                            Lihat Semua Program <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Instagram Feed Section -->
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <h2 class="section-title">Instagram @masjidagungalazhar</h2>
            </div>
            
            <div class="text-center fade-up" style="margin-bottom: 2rem;">
                <p>Ikuti kegiatan terbaru kami di Instagram <a href="https://instagram.com/masjidagungalazhar" target="_blank" style="color: var(--primary); font-weight: bold; text-decoration: none;">@masjidagungalazhar</a></p>
            </div>

            <div class="fade-up" style="width: 100%; border-radius: var(--radius); overflow: hidden;">
                <!-- Elfsight Instagram Feed Widget -->
                <script src="https://elfsightcdn.com/platform.js" async></script>
                <div class="elfsight-app-2edc714a-36ba-4433-b2f5-40632f906ae2" data-elfsight-app-lazy></div>
            </div>

            <div class="text-center mt-4 fade-up">
                <a href="https://instagram.com/masjidagungalazhar" target="_blank" class="btn btn-primary"
                    style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: var(--white); border: none;">
                    <i class="fab fa-instagram"></i> Kunjungi Instagram Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if ($testimonials->count() > 0)
        <section class="section">
            <div class="container">
                <div class="section-header fade-up">
                    <h2 class="section-title">Testimonial</h2>
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
    <!-- Donations Section -->
    @if ($donations->count() > 0)
        <section class="section section-alt">
            <div class="container">
                <div class="section-header fade-up">
                    <h2 class="section-title">Salurkan Donasi Anda</h2>
                </div>
                <div class="donations-grid">
                    @foreach ($donations as $donation)
                        <div class="donation-card fade-up">
                            @if ($donation->is_urgent ?? false)
                                <div class="donation-urgent"><i class="fas fa-exclamation-circle"></i> URGENT</div>
                            @endif
                            <div class="donation-img lazy-bg"
                                data-bg="{{ $donation->image ? asset('storage/' . $donation->image) : '' }}"></div>
                            <div class="donation-body">
                                <span
                                    class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}</span>
                                <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                                <p class="donation-desc">{{ Str::limit($donation->description, 80) }}</p>

                                @if ($donation->target_amount)
                                    Coba lagiUntuk menjalankan kode, aktifkan eksekusi kode dan pembuatan file di Pengaturan
                                    > Kemampuan.ZLanjutkan <div class="donation-progress">
                                        <div class="donation-progress-bar">
                                            <div class="donation-progress-fill"
                                                style="width: {{ min($donation->percentage ?? 0, 100) }}%;"></div>
                                        </div>
                                        <div class="donation-stats">
                                            <span class="donation-raised">Rp
                                                {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                            <span class="donation-target">dari Rp
                                                {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="donation-meta">
                                    <span><i class="fas fa-users"></i> {{ number_format($donation->donor_count) }}
                                        Donatur</span>
                                    @if ($donation->days_left ?? false)
                                        <span><i class="fas fa-clock"></i> {{ $donation->days_left }} hari lagi</span>
                                    @endif
                                </div>

                                <a href="{{ route('donations.show', $donation->slug) }}" class="btn-donate">
                                    Donasi Sekarang <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4 fade-up">
                    <a href="{{ route('donations') }}" class="btn btn-outline"
                        style="border: 2px solid var(--primary); color: var(--primary);">
                        Lihat Semua Program Donasi <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content fade-up">
            <h2 class="cta-title">Mari Bergabung Bersama Kami</h2>
            <p class="cta-desc">Ikuti berbagai program kegiatan dan dakwah Islam di Masjid Agung Al Azhar. Bersama kita
                membangun umat yang lebih baik.</p>
            <div class="cta-buttons">
                <a href="{{ route('programs') }}" class="btn-cta-primary">
                    <i class="fas fa-calendar-check"></i> Lihat Program
                </a>
                <a href="{{ route('contact') }}" class="btn-cta-outline">
                    <i class="fas fa-envelope"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>

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

        // Fade Up Animation
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        document.querySelectorAll('.fade-up').forEach(el => fadeObserver.observe(el));

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


        document.addEventListener('keydown', (e) => {
            if (!document.getElementById('lightbox').classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changeLightbox(-1);
            if (e.key === 'ArrowRight') changeLightbox(1);
        });
    </script>
@endpush
