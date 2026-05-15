@extends('landing.layouts.app')

@section('title', 'Galeri Kegiatan - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Compact Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content" data-aos="fade-up">
                <h1>Galeri Kegiatan</h1>
                <p>Dokumentasi berbagai kegiatan yang telah kami laksanakan</p>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            @if ($albums->count() > 0)
                <!-- Albums Grid -->
                <div class="albums-grid">
                    @foreach ($albums as $album)
                        <article class="album-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <a href="{{ route('gallery.album', $album->slug) }}" class="album-link">
                                <!-- Album Cover -->
                                <div class="album-cover-wrapper">
                                    <img src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ $album->name }}" class="album-cover" loading="lazy">

                                    <!-- Hover Overlay -->
                                    <div class="album-overlay">
                                        <div class="overlay-content">
                                            <div class="photo-count-badge">
                                                <i class="fas fa-images"></i>
                                                <span>{{ $album->galleries_count }}</span>
                                            </div>
                                            <div class="view-album-btn">
                                                <span>Lihat Album</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date Badge -->
                                    @if ($album->event_date)
                                        <div class="date-badge">
                                            <div class="date-day">{{ $album->event_date->format('d') }}</div>
                                            <div class="date-month">{{ $album->event_date->format('M Y') }}</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Album Info -->
                                <div class="album-body">
                                    <h3 class="album-title">{{ $album->name }}</h3>

                                    @if ($album->description)
                                        <p class="album-description">{{ Str::limit($album->description, 90) }}</p>
                                    @endif

                                    <div class="album-footer">
                                        <div class="album-meta">
                                            <span class="meta-item">
                                                <i class="far fa-images"></i>
                                                {{ $album->galleries_count }} Foto
                                            </span>
                                            @if ($album->event_date)
                                                <span class="meta-item">
                                                    <i class="far fa-calendar"></i>
                                                    {{ $album->event_date->format('M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="arrow-icon">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <!-- Modern Pagination -->
                @if ($albums->hasPages())
                    <div class="pagination-wrapper">
                        {{ $albums->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="far fa-images"></i>
                    </div>
                    <h3>Belum Ada Album</h3>
                    <p>Album galeri akan segera ditambahkan</p>
                </div>
            @endif
        </div>
    </section>

    <style>
        :root {
            --primary: #0053C5;
            --primary-dark: #003d94;
            --primary-light: #e6f0ff;
            --dark: #1a1a1a;
            --gray-900: #2d3748;
            --gray-700: #4a5568;
            --gray-500: #718096;
            --gray-300: #cbd5e0;
            --gray-100: #f7fafc;
            --white: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Compact Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 80px 0 50px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .header-content p {
            font-size: 1.1rem;
            opacity: 0.95;
            font-weight: 400;
        }

        /* Gallery Section */
        .gallery-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        /* Albums Grid */
        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        /* Album Card */
        .album-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .album-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .album-link {
            text-decoration: none;
            display: block;
            color: inherit;
        }

        /* Album Cover */
        .album-cover-wrapper {
            position: relative;
            width: 100%;
            height: 240px;
            overflow: hidden;
            background: var(--gray-100);
        }

        .album-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .album-card:hover .album-cover {
            transform: scale(1.1);
        }

        /* Hover Overlay */
        .album-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 50%, transparent 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .album-card:hover .album-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
            color: var(--white);
            transform: translateY(20px);
            transition: var(--transition);
        }

        .album-card:hover .overlay-content {
            transform: translateY(0);
        }

        .photo-count-badge {
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .photo-count-badge i {
            font-size: 1.1rem;
        }

        .view-album-btn {
            background: var(--primary);
            color: var(--white);
            padding: 12px 30px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.4);
            transition: var(--transition);
        }

        .album-card:hover .view-album-btn {
            gap: 15px;
            box-shadow: 0 6px 20px rgba(0, 83, 197, 0.5);
        }

        /* Date Badge */
        .date-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .date-day {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .date-month {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Album Body */
        .album-body {
            padding: 24px;
        }

        .album-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: var(--transition);
        }

        .album-card:hover .album-title {
            color: var(--primary);
        }

        .album-description {
            color: var(--gray-700);
            line-height: 1.6;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        /* Album Footer */
        .album-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid var(--gray-100);
        }

        .album-meta {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .meta-item i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .arrow-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            transition: var(--transition);
        }

        .album-card:hover .arrow-icon {
            background: var(--primary);
            color: var(--white);
            transform: translateX(5px);
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 12px;
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .pagination .page-item .page-link:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .pagination .page-item.disabled .page-link {
            background: var(--gray-100);
            color: var(--gray-300);
            border-color: var(--gray-300);
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 20px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #cfe2ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .empty-icon i {
            font-size: 3.5rem;
            color: var(--primary);
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: var(--gray-500);
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .skeleton {
            animation: shimmer 2s infinite;
            background: linear-gradient(to right, #f0f0f0 4%, #e0e0e0 25%, #f0f0f0 36%);
            background-size: 1000px 100%;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .albums-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 60px 0 40px;
            }

            .header-content h1 {
                font-size: 2rem;
            }

            .header-content p {
                font-size: 1rem;
            }

            .gallery-section {
                padding: 40px 0;
            }

            .albums-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .album-cover-wrapper {
                height: 220px;
            }

            .album-body {
                padding: 20px;
            }

            .photo-count-badge {
                padding: 8px 16px;
                font-size: 0.9rem;
            }

            .view-album-btn {
                padding: 10px 24px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .album-cover-wrapper {
                height: 200px;
            }

            .album-meta {
                flex-direction: column;
                gap: 8px;
            }

            .arrow-icon {
                width: 28px;
                height: 28px;
            }

            .date-badge {
                top: 12px;
                right: 12px;
                padding: 8px;
            }

            .date-day {
                font-size: 1.2rem;
            }

            .date-month {
                font-size: 0.65rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .album-card {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Hover Image Zoom Effect */
        @media (hover: hover) {
            .album-cover-wrapper::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
                opacity: 0;
                transition: var(--transition);
            }

            .album-card:hover .album-cover-wrapper::after {
                opacity: 1;
            }
        }

        /* Focus Styles for Accessibility */
        .album-link:focus {
            outline: 3px solid var(--primary);
            outline-offset: 4px;
            border-radius: var(--radius-lg);
        }

        .album-link:focus-visible {
            outline: 3px solid var(--primary);
            outline-offset: 4px;
        }
    </style>
@endsection
