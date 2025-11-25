@extends('landing.layouts.app')

@section('title', 'Program Kegiatan - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Compact Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content" data-aos="fade-up">
                <h1>Program & Kegiatan</h1>
                <p>Ikuti berbagai program kegiatan keagamaan yang kami selenggarakan</p>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section">
        <div class="container">
            <!-- Modern Filter Tabs -->
            <div class="filter-wrapper" data-aos="fade-up">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        <i class="fas fa-th"></i>
                        <span>Semua</span>
                    </button>
                    <button class="filter-tab" data-filter="regular">
                        <i class="fas fa-calendar-day"></i>
                        <span>Regular</span>
                    </button>
                    <button class="filter-tab" data-filter="event">
                        <i class="fas fa-calendar-star"></i>
                        <span>Event</span>
                    </button>
                    <button class="filter-tab" data-filter="course">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Kursus</span>
                    </button>
                    <button class="filter-tab" data-filter="charity">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Sosial</span>
                    </button>
                </div>
            </div>

            <!-- Programs Grid -->
            <div class="programs-grid">
                @foreach ($programs as $program)
                    <article class="program-card" data-type="{{ $program->type }}" data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 50 }}">
                        <!-- Program Image -->
                        <div class="program-image-wrapper">
                            @if ($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}"
                                    class="program-image" loading="lazy">
                            @else
                                <div class="program-image-placeholder">
                                    <i class="{{ $program->icon ?? 'fas fa-mosque' }}"></i>
                                </div>
                            @endif
                            <div class="program-badge">
                                {{ ucfirst($program->type) }}
                            </div>
                        </div>

                        <!-- Program Content -->
                        <div class="program-body">
                            @if ($program->icon)
                                <div class="program-icon">
                                    <i class="{{ $program->icon }}"></i>
                                </div>
                            @endif

                            <h3 class="program-title">
                                <a href="{{ route('program.detail', $program->slug) }}">
                                    {{ $program->name }}
                                </a>
                            </h3>

                            <p class="program-description">
                                {{ Str::limit($program->description, 100) }}
                            </p>

                            <!-- Program Info -->
                            <div class="program-info">
                                @if ($program->start_time)
                                    <div class="info-item">
                                        <i class="far fa-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($program->start_time)->format('H:i') }}</span>
                                    </div>
                                @endif

                                @if ($program->frequency)
                                    <div class="info-item">
                                        <i class="far fa-calendar"></i>
                                        <span>{{ ucfirst($program->frequency) }}</span>
                                    </div>
                                @endif

                                @if ($program->location)
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ Str::limit($program->location, 20) }}</span>
                                    </div>
                                @endif

                                @if ($program->max_participants)
                                    <div class="info-item">
                                        <i class="far fa-user"></i>
                                        <span>{{ $program->current_participants }}/{{ $program->max_participants }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Program Footer -->
                            <div class="program-footer">
                                @if ($program->registration_fee > 0)
                                    <div class="program-price">
                                        <span class="price-label">Biaya</span>
                                        <span class="price-amount">Rp
                                            {{ number_format($program->registration_fee, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="program-price">
                                        <span class="price-free">Gratis</span>
                                    </div>
                                @endif

                                <a href="{{ route('program.detail', $program->slug) }}" class="btn-detail">
                                    Detail <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Modern Pagination -->
            @if ($programs->hasPages())
                <div class="pagination-wrapper">
                    {{ $programs->links() }}
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
            --success: #10b981;
            --warning: #f59e0b;
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

        /* Programs Section */
        .programs-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        /* Modern Filter Tabs */
        .filter-wrapper {
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
        }

        .filter-tabs {
            display: inline-flex;
            background: var(--white);
            padding: 6px;
            border-radius: 50px;
            box-shadow: var(--shadow-md);
            gap: 6px;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .filter-tab {
            padding: 12px 24px;
            background: transparent;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-700);
            white-space: nowrap;
        }

        .filter-tab:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .filter-tab.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .filter-tab i {
            font-size: 1rem;
        }

        /* Programs Grid */
        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        /* Program Card */
        .program-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
            opacity: 1;
            transform: scale(1);
        }

        .program-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        /* Program Image */
        .program-image-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: var(--gray-100);
        }

        .program-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .program-card:hover .program-image {
            transform: scale(1.08);
        }

        .program-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .program-image-placeholder i {
            font-size: 3.5rem;
            color: var(--white);
            opacity: 0.4;
        }

        .program-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: var(--white);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Program Body */
        .program-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .program-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #cfe2ff 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .program-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .program-title a {
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .program-title a:hover {
            color: var(--primary);
        }

        .program-description {
            color: var(--gray-700);
            line-height: 1.6;
            font-size: 0.9rem;
            margin-bottom: 20px;
            flex: 1;
        }

        /* Program Info */
        .program-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
            padding: 16px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--gray-700);
        }

        .info-item i {
            width: 16px;
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Program Footer */
        .program-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 2px solid var(--gray-100);
            gap: 15px;
        }

        .program-price {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .price-amount {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .price-free {
            font-size: 1rem;
            font-weight: 700;
            color: var(--success);
            background: #d1fae5;
            padding: 6px 16px;
            border-radius: 50px;
        }

        .btn-detail {
            padding: 10px 20px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: var(--primary-dark);
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
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

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .program-card {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .programs-grid {
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

            .programs-section {
                padding: 40px 0;
            }

            .filter-tabs {
                padding: 4px;
                gap: 4px;
                border-radius: 12px;
            }

            .filter-tab {
                padding: 10px 16px;
                font-size: 0.85rem;
            }

            .filter-tab span {
                display: none;
            }

            .filter-tab i {
                margin: 0;
            }

            .programs-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .program-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .program-image-wrapper {
                height: 180px;
            }

            .program-body {
                padding: 20px;
            }

            .program-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-detail {
                width: 100%;
                justify-content: center;
            }

            .filter-tabs {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Smooth Filter Transitions */
        .program-card {
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
        }

        .program-card[style*="display: none"] {
            visibility: hidden;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const programCards = document.querySelectorAll('.program-card');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');

                    // Update active tab
                    filterTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Filter cards with smooth animation
                    programCards.forEach((card, index) => {
                        const type = card.getAttribute('data-type');
                        const shouldShow = filter === 'all' || type === filter;

                        if (shouldShow) {
                            // Show card
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'scale(1)';
                            }, index * 30); // Stagger animation
                        } else {
                            // Hide card
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });

                    // Scroll to programs grid smoothly
                    const programsGrid = document.querySelector('.programs-grid');
                    const headerHeight = 100;
                    const targetPosition = programsGrid.getBoundingClientRect().top + window
                        .pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                });
            });

            // Initialize: ensure all cards are visible on page load
            programCards.forEach(card => {
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            });
        });
    </script>
@endsection
