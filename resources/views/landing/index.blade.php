@extends('landing.layouts.app')

@section('title', $settings['site_name'] ?? 'Masjid Agung Al Azhar')

@section('content')
    <!-- Hero Slider -->
    <section class="hero-slider">
        @foreach ($sliders as $index => $slider)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                <div class="hero-overlay"
                    style="background-color: {{ $slider->overlay_color }}; opacity: {{ $slider->overlay_opacity / 100 }};">
                </div>
                <div class="hero-content" style="text-align: {{ $slider->text_position }};">
                    <div class="container">
                        <h1 class="hero-title" data-aos="fade-up">{{ $slider->title }}</h1>
                        @if ($slider->subtitle)
                            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $slider->subtitle }}</p>
                        @endif
                        @if ($slider->description)
                            <p class="hero-description" data-aos="fade-up" data-aos-delay="200">{{ $slider->description }}
                            </p>
                        @endif
                        <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
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
            <!-- Slider Controls -->
            <div class="slider-controls">
                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="slider-indicators">
                @foreach ($sliders as $index => $slider)
                    <span class="indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                @endforeach
            </div>
        @endif
    </section>

    <style>
        .hero-slider {
            position: relative;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 1s ease, visibility 1s ease;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            height: 100%;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
            text-shadow: 0 3px 15px rgba(0, 0, 0, 0.3);
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 30px rgba(0, 83, 197, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 83, 197, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }

        .slider-controls button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .slider-controls button:hover {
            background: var(--primary);
        }

        .slider-prev {
            left: 30px;
            border-radius: 0 50px 50px 0;
        }

        .slider-next {
            right: 30px;
            border-radius: 50px 0 0 50px;
        }

        .slider-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .indicator {
            width: 40px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: white;
            width: 60px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .slider-controls button {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(ind => ind.classList.remove('active'));

            if (index >= totalSlides) currentSlide = 0;
            if (index < 0) currentSlide = totalSlides - 1;

            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');
        }

        function nextSlide() {
            currentSlide++;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide--;
            showSlide(currentSlide);
        }

        // Auto slide
        let autoSlide = setInterval(nextSlide, 5000);

        // Manual controls
        document.querySelector('.slider-next')?.addEventListener('click', () => {
            nextSlide();
            clearInterval(autoSlide);
            autoSlide = setInterval(nextSlide, 5000);
        });

        document.querySelector('.slider-prev')?.addEventListener('click', () => {
            prevSlide();
            clearInterval(autoSlide);
            autoSlide = setInterval(nextSlide, 5000);
        });

        // Indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
                clearInterval(autoSlide);
                autoSlide = setInterval(nextSlide, 5000);
            });
        });
    </script>

    <!-- Announcements with Running Text Animation -->
    @if ($announcements->count() > 0)
        <section class="announcement-bar">
            <div class="container">
                <div class="announcement-wrapper">
                    <!-- Icon -->
                    <div class="announcement-icon">
                        <i class="fas fa-bullhorn"></i>
                        <span class="announcement-label">Pengumuman</span>
                    </div>

                    <!-- Running Text Container -->
                    <div class="announcement-content">
                        <div class="announcement-marquee">
                            <div class="announcement-track">
                                @foreach ($announcements as $announcement)
                                    <span class="announcement-item">
                                        <i class="fas fa-circle" style="font-size: 6px; margin: 0 15px;"></i>
                                        {{ $announcement->title }}
                                    </span>
                                @endforeach
                                <!-- Duplicate untuk seamless loop -->
                                @foreach ($announcements as $announcement)
                                    <span class="announcement-item">
                                        <i class="fas fa-circle" style="font-size: 6px; margin: 0 15px;"></i>
                                        {{ $announcement->title }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .announcement-bar {
                background: linear-gradient(135deg, #0053C5 0%,rgb(33, 120, 241) 100%);
                padding: 0;
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
                z-index: 100;
            }

            .announcement-bar::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                animation: shine 3s infinite;
            }

            @keyframes shine {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
                }
            }

            .announcement-wrapper {
                display: flex;
                align-items: center;
                gap: 20px;
                padding: 15px 0;
                position: relative;
            }

            .announcement-icon {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-shrink: 0;
                color: white;
                background: rgba(255, 255, 255, 0.2);
                padding: 12px 20px;
                border-radius: 50px;
                backdrop-filter: blur(10px);
            }

            .announcement-icon i {
                font-size: 1.3rem;
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.1);
                }
            }

            .announcement-label {
                font-weight: 700;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .announcement-content {
                flex: 1;
                overflow: hidden;
                position: relative;
                mask-image: linear-gradient(to right,
                        transparent 0%,
                        black 5%,
                        black 95%,
                        transparent 100%);
                -webkit-mask-image: linear-gradient(to right,
                        transparent 0%,
                        black 5%,
                        black 95%,
                        transparent 100%);
            }

            .announcement-marquee {
                display: flex;
                overflow: hidden;
            }

            .announcement-track {
                display: flex;
                animation: scroll 30s linear infinite;
                will-change: transform;
            }

            .announcement-track:hover {
                animation-play-state: paused;
            }

            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .announcement-item {
                color: white;
                font-weight: 600;
                font-size: 1rem;
                white-space: nowrap;
                display: inline-flex;
                align-items: center;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .announcement-wrapper {
                    gap: 10px;
                    padding: 12px 0;
                }

                .announcement-icon {
                    padding: 10px 15px;
                    gap: 8px;
                }

                .announcement-icon i {
                    font-size: 1.1rem;
                }

                .announcement-label {
                    display: none;
                }

                .announcement-item {
                    font-size: 0.9rem;
                }

                .announcement-track {
                    animation-duration: 20s;
                }

                .announcement-close {
                    width: 30px;
                    height: 30px;
                }
            }

            /* Hidden state */
            .announcement-bar.hidden {
                display: none;
            }
        </style>
    @endif

    <!-- Statistics -->
    <section class="section" style="background: var(--light);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                <div class="stat-box" data-aos="fade-up">
                    <div class="stat-icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['total_programs'] }}">0</div>
                    <div class="stat-label">Program Aktif</div>
                </div>
                <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['total_posts'] }}">0</div>
                    <div class="stat-label">Artikel Tersedia</div>
                </div>
                <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="stat-number">Rp {{ number_format($stats['total_donations'] / 1000000, 1) }}M</div>
                    <div class="stat-label">Total Donasi</div>
                </div>
                <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['total_testimonials'] }}">0</div>
                    <div class="stat-label">Testimoni Positif</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .stat-box {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
        }
    </style>

    <script>
        // Animated Counter
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const increment = target / speed;
            let count = 0;

            const updateCount = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        };

        // Trigger animation when in viewport
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target.querySelector('.stat-number');
                    if (counter.hasAttribute('data-target') && !counter.classList.contains('counted')) {
                        animateCounter(counter);
                        counter.classList.add('counted');
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-box').forEach(box => observer.observe(box));
    </script>

    <!-- Programs Section -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Program Kami</div>
                <h2 class="section-title">Program & Kegiatan</h2>
                <p class="section-description">
                    Ikuti berbagai program kegiatan keagamaan yang kami selenggarakan
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                @foreach ($programs as $program)
                    <div class="program-card" data-aos="fade-up">
                        @if ($program->image)
                            <div class="program-image"
                                style="background-image: url('{{ asset('storage/' . $program->image) }}');"></div>
                        @endif
                        <div class="program-content">
                            @if ($program->icon)
                                <div class="program-icon">
                                    <i class="{{ $program->icon }}"></i>
                                </div>
                            @endif
                            <h3 class="program-title">{{ $program->name }}</h3>
                            <p class="program-description">{{ Str::limit($program->description, 100) }}</p>
                            <div class="program-meta">
                                <span><i class="fas fa-calendar"></i> {{ $program->frequency }}</span>
                                @if ($program->location)
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $program->location }}</span>
                                @endif
                            </div>
                            <a href="{{ route('program.detail', $program->slug) }}" class="program-link">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 40px;" data-aos="fade-up">
                <a href="{{ route('programs') }}" class="btn btn-primary">
                    Lihat Semua Program
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        .program-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .program-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .program-content {
            padding: 25px;
        }

        .program-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
        }

        .program-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .program-description {
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .program-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .program-meta i {
            margin-right: 5px;
        }

        .program-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .program-link:hover {
            gap: 12px;
        }
    </style>

    <!-- Latest Posts/News Section -->
    <section class="section" style="background: var(--light);">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Berita & Artikel</div>
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="section-description">
                    Ikuti perkembangan dan kegiatan terbaru dari Masjid Al Azhar
                </p>
            </div>

            <!-- Featured Posts -->
            @if ($featuredPosts->count() > 0)
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 50px;">
                    @foreach ($featuredPosts as $post)
                        <article class="post-card featured" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="post-image"
                                style="background-image: url('{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/800x500' }}');">
                                <div class="post-badge">Featured</div>
                                <div class="post-category">{{ $post->category->name }}</div>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span><i class="fas fa-user"></i> {{ $post->author->name }}</span>
                                    <span><i class="fas fa-calendar"></i>
                                        {{ $post->published_at->format('d M Y') }}</span>
                                    <span><i class="fas fa-eye"></i> {{ number_format($post->views_count) }}</span>
                                </div>
                                <h3 class="post-title">{{ $post->title }}</h3>
                                <p class="post-excerpt">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
                                <a href="{{ route('blog.detail', $post->slug) }}" class="post-link">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <!-- Latest Posts Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
                @foreach ($latestPosts->take(6) as $post)
                    <article class="post-card-small" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="post-image-small"
                            style="background-image: url('{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/400x300' }}');">
                        </div>
                        <div class="post-content-small">
                            <div class="post-category-small">{{ $post->category->name }}</div>
                            <h4 class="post-title-small">{{ Str::limit($post->title, 60) }}</h4>
                            <div class="post-meta-small">
                                <span><i class="fas fa-calendar"></i> {{ $post->published_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 40px;" data-aos="fade-up">
                <a href="{{ route('blog') }}" class="btn btn-primary">
                    Lihat Semua Berita
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        .post-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .post-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .post-card.featured {
            grid-column: span 1;
        }

        .post-image {
            width: 100%;
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .post-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--warning);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .post-category {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .post-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .post-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #9ca3af;
            flex-wrap: wrap;
        }

        .post-meta i {
            margin-right: 5px;
        }

        .post-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
            line-height: 1.4;
        }

        .post-excerpt {
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
            flex: 1;
        }

        .post-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .post-link:hover {
            gap: 12px;
        }

        /* Small Post Card */
        .post-card-small {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .post-card-small:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .post-image-small {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
        }

        .post-content-small {
            padding: 20px;
        }

        .post-category-small {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .post-title-small {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .post-meta-small {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .post-meta-small i {
            margin-right: 5px;
        }
    </style>

    <!-- Gallery Section -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Galeri</div>
                <h2 class="section-title">Dokumentasi Kegiatan</h2>
                <p class="section-description">
                    Lihat dokumentasi berbagai kegiatan yang telah kami laksanakan
                </p>
            </div>

            <div class="gallery-grid">
                @foreach ($galleries as $index => $gallery)
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}"
                        onclick="openLightbox({{ $index }})">
                        <img src="{{ $gallery->image ? asset('storage/' . $gallery->image) : 'https://via.placeholder.com/600x400' }}"
                            alt="{{ $gallery->title }}" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>{{ $gallery->title }}</h4>
                                <p>{{ $gallery->description }}</p>
                            </div>
                            <div class="gallery-icon">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Gallery Albums -->
            @if ($albums->count() > 0)
                <div style="margin-top: 60px;">
                    <h3 style="font-size: 2rem; font-weight: 700; text-align: center; margin-bottom: 40px;"
                        data-aos="fade-up">Album Kegiatan</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                        @foreach ($albums as $album)
                            <a href="{{ route('gallery.album', $album->slug) }}" class="album-card" data-aos="fade-up"
                                data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="album-cover"
                                    style="background-image: url('{{ $album->cover_image ? asset('storage/' . $album->cover_image) : 'https://via.placeholder.com/600x400' }}');">
                                </div>
                                <div class="album-info">
                                    <h4 class="album-title">{{ $album->name }}</h4>
                                    <div class="album-meta">
                                        <span><i class="fas fa-images"></i> {{ $album->galleries_count }} Foto</span>
                                        <span><i class="fas fa-calendar"></i>
                                            {{ $album->event_date ? $album->event_date->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div style="text-align: center; margin-top: 40px;" data-aos="fade-up">
                <a href="{{ route('gallery') }}" class="btn btn-primary">
                    Lihat Semua Galeri
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-content" id="lightbox-img">
        <div class="lightbox-caption" id="lightbox-caption"></div>
        <button class="lightbox-prev" onclick="event.stopPropagation(); changeLightboxImage(-1)">&#10094;</button>
        <button class="lightbox-next" onclick="event.stopPropagation(); changeLightboxImage(1)">&#10095;</button>
    </div>

    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px;
            color: white;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-info h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .gallery-info p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .gallery-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Album Cards */
        .album-card {
            text-decoration: none;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .album-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .album-cover {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .album-info {
            padding: 20px;
        }

        .album-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .album-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .album-meta i {
            margin-right: 5px;
        }

        /* Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.95);
            animation: fadeIn 0.3s;
        }

        .lightbox.show {
            display: block;
        }

        .lightbox-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80%;
            animation: zoomIn 0.3s;
        }

        .lightbox-caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 20px;
            font-size: 1.1rem;
        }

        .lightbox-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .lightbox-close:hover {
            color: #bbb;
        }

        .lightbox-prev,
        .lightbox-next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 30px;
            transition: 0.6s ease;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .lightbox-prev {
            left: 20px;
            border-radius: 0 5px 5px 0;
        }

        .lightbox-next {
            right: 20px;
            border-radius: 5px 0 0 5px;
        }

        .lightbox-prev:hover,
        .lightbox-next:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }
    </style>

    <script>
        // Gallery Lightbox
        const galleryImages = {!! json_encode(
            $galleries->map(function ($gallery) {
                    return [
                        'src' => $gallery->image ? asset('storage/' . $gallery->image) : 'https://via.placeholder.com/600x400',
                        'title' => $gallery->title,
                        'description' => $gallery->description ?? '',
                    ];
                })->values(),
        ) !!};

        let currentImageIndex = 0;

        function openLightbox(index) {
            currentImageIndex = index;
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            const caption = document.getElementById('lightbox-caption');

            lightbox.classList.add('show');
            img.src = galleryImages[index].src;
            caption.innerHTML = `<strong>${galleryImages[index].title}</strong><br>${galleryImages[index].description}`;
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function changeLightboxImage(direction) {
            currentImageIndex += direction;
            if (currentImageIndex >= galleryImages.length) {
                currentImageIndex = 0;
            }
            if (currentImageIndex < 0) {
                currentImageIndex = galleryImages.length - 1;
            }

            const img = document.getElementById('lightbox-img');
            const caption = document.getElementById('lightbox-caption');

            img.src = galleryImages[currentImageIndex].src;
            caption.innerHTML =
                `<strong>${galleryImages[currentImageIndex].title}</strong><br>${galleryImages[currentImageIndex].description}`;
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').classList.contains('show')) {
                if (e.key === 'ArrowLeft') changeLightboxImage(-1);
                if (e.key === 'ArrowRight') changeLightboxImage(1);
                if (e.key === 'Escape') closeLightbox();
            }
        });
    </script>

    <!-- Schedules Section -->
    <section class="section" style="background: var(--light);">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Jadwal</div>
                <h2 class="section-title">Jadwal Kegiatan</h2>
                <p class="section-description">
                    Ikuti jadwal kegiatan dan kajian rutin di Masjid Al Azhar
                </p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Today's Schedule -->
                <div class="schedule-box" data-aos="fade-right">
                    <h3
                        style="font-size: 1.5rem; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-calendar-day" style="color: var(--primary);"></i>
                        Jadwal Hari Ini
                    </h3>
                    @if ($todaySchedules->count() > 0)
                        <div class="schedule-list">
                            @foreach ($todaySchedules as $schedule)
                                <div class="schedule-item">
                                    <div class="schedule-time">{{ $schedule->formatted_time }}</div>
                                    <div class="schedule-details">
                                        <h4>{{ $schedule->title }}</h4>
                                        @if ($schedule->location)
                                            <p><i class="fas fa-map-marker-alt"></i> {{ $schedule->location }}</p>
                                        @endif
                                        @if ($schedule->imam || $schedule->speaker)
                                            <p><i class="fas fa-user"></i> {{ $schedule->imam ?? $schedule->speaker }}</p>
                                        @endif
                                    </div>
                                    <div class="schedule-badge" style="background: {{ $schedule->color }};">
                                        {{ ucfirst($schedule->type) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="text-align: center; color: #9ca3af; padding: 40px;">Tidak ada jadwal untuk hari ini</p>
                    @endif
                </div>

                <!-- Upcoming Events -->
                <div class="schedule-box" data-aos="fade-left">
                    <h3
                        style="font-size: 1.5rem; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-calendar-alt" style="color: var(--primary);"></i>
                        Event Mendatang
                    </h3>
                    @if ($upcomingEvents->count() > 0)
                        <div class="schedule-list">
                            @foreach ($upcomingEvents as $event)
                                <div class="schedule-item">
                                    <div class="schedule-date">
                                        <div class="date-day">{{ $event->date->format('d') }}</div>
                                        <div class="date-month">{{ $event->date->format('M') }}</div>
                                    </div>
                                    <div class="schedule-details">
                                        <h4>{{ $event->title }}</h4>
                                        <p><i class="fas fa-clock"></i> {{ $event->formatted_time }}</p>
                                        @if ($event->location)
                                            <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="text-align: center; color: #9ca3af; padding: 40px;">Belum ada event mendatang</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .schedule-box {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .schedule-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: var(--light);
            border-radius: 15px;
            align-items: center;
            transition: all 0.3s ease;
        }

        .schedule-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .schedule-time {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            min-width: 100px;
        }

        .schedule-date {
            min-width: 60px;
            text-align: center;
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
        }

        .date-day {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .date-month {
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .schedule-details {
            flex: 1;
        }

        .schedule-details h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .schedule-details p {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .schedule-details i {
            margin-right: 5px;
            opacity: 0.7;
        }

        .schedule-badge {
            padding: 6px 15px;
            border-radius: 50px;
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .schedule-box {
                grid-column: span 2;
            }
        }
    </style>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Testimonial</div>
                <h2 class="section-title">Apa Kata Mereka</h2>
                <p class="section-description">
                    Testimoni dari jamaah dan peserta program Masjid Al Azhar
                </p>
            </div>

            <div class="testimonial-slider" data-aos="fade-up">
                <div class="testimonial-track">
                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                            <p class="testimonial-content">"{{ $testimonial->content }}"</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    @if ($testimonial->photo)
                                        <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                            alt="{{ $testimonial->name }}" loading="lazy">
                                    @else
                                        <div class="avatar-placeholder">{{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="author-info">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->role }}{{ $testimonial->company ? ' - ' . $testimonial->company : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($testimonials->count() > 1)
                    <div class="testimonial-controls">
                        <button class="testimonial-prev"><i class="fas fa-chevron-left"></i></button>
                        <button class="testimonial-next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .testimonial-slider {
            position: relative;
            overflow: hidden;
            padding: 20px 60px;
        }

        .testimonial-track {
            display: flex;
            gap: 30px;
            transition: transform 0.5s ease;
        }

        .testimonial-card {
            min-width: calc(33.333% - 20px);
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .testimonial-rating {
            margin-bottom: 20px;
        }

        .testimonial-rating i {
            color: #d1d5db;
            font-size: 1.2rem;
            margin-right: 5px;
        }

        .testimonial-rating i.active {
            color: #fbbf24;
        }

        .testimonial-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #4b5563;
            margin-bottom: 25px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .author-info h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .author-info p {
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .testimonial-quote {
            position: absolute;
            bottom: 20px;
            right: 30px;
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.1;
        }

        .testimonial-controls button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            color: var(--dark);
            font-size: 1.2rem;
        }

        .testimonial-controls button:hover {
            background: var(--primary);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 83, 197, 0.3);
        }

        .testimonial-prev {
            left: 0;
        }

        .testimonial-next {
            right: 0;
        }

        @media (max-width: 1024px) {
            .testimonial-card {
                min-width: calc(50% - 15px);
            }
        }

        @media (max-width: 768px) {
            .testimonial-card {
                min-width: calc(100% - 40px);
            }

            .testimonial-slider {
                padding: 20px 10px;
            }
        }
    </style>

    <script>
        // Testimonial Slider
        const testimonialTrack = document.querySelector('.testimonial-track');
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        const testimonialPrev = document.querySelector('.testimonial-prev');
        const testimonialNext = document.querySelector('.testimonial-next');

        let testimonialIndex = 0;
        const testimonialCardsToShow = window.innerWidth > 1024 ? 3 : (window.innerWidth > 768 ? 2 : 1);
        const maxTestimonialIndex = testimonialCards.length - testimonialCardsToShow;

        function updateTestimonialSlider() {
            const cardWidth = testimonialCards[0].offsetWidth;
            const gap = 30;
            testimonialTrack.style.transform = `translateX(-${testimonialIndex * (cardWidth + gap)}px)`;
        }

        testimonialNext?.addEventListener('click', () => {
            if (testimonialIndex < maxTestimonialIndex) {
                testimonialIndex++;
                updateTestimonialSlider();
            }
        });

        testimonialPrev?.addEventListener('click', () => {
            if (testimonialIndex > 0) {
                testimonialIndex--;
                updateTestimonialSlider();
            }
        });

        // Auto slide testimonials
        setInterval(() => {
            if (testimonialIndex >= maxTestimonialIndex) {
                testimonialIndex = 0;
            } else {
                testimonialIndex++;
            }
            updateTestimonialSlider();
        }, 5000);
    </script>

    <!-- Staff Section -->
    <section class="section" style="background: var(--light);">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Tim Kami</div>
                <h2 class="section-title">Pengurus & Ustadz</h2>
                <p class="section-description">
                    Kenali pengurus dan ustadz yang mengabdi di Masjid Al Azhar
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px;">
                @foreach ($staff as $person)
                    <div class="staff-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="staff-photo">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                    loading="lazy">
                            @else
                                <div class="photo-placeholder">{{ strtoupper(substr($person->name, 0, 1)) }}</div>
                            @endif
                            @if ($person->social_media)
                                <div class="staff-social">
                                    @if (isset($person->social_media['facebook']))
                                        <a href="{{ $person->social_media['facebook'] }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if (isset($person->social_media['instagram']))
                                        <a href="{{ $person->social_media['instagram'] }}" target="_blank"><i
                                                class="fab fa-instagram"></i></a>
                                    @endif
                                    @if (isset($person->social_media['twitter']))
                                        <a href="{{ $person->social_media['twitter'] }}" target="_blank"><i
                                                class="fab fa-twitter"></i></a>
                                    @endif
                                    @if (isset($person->social_media['youtube']))
                                        <a href="{{ $person->social_media['youtube'] }}" target="_blank"><i
                                                class="fab fa-youtube"></i></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="staff-info">
                            <h4 class="staff-name">{{ $person->name }}</h4>
                            <p class="staff-position">{{ $person->position }}</p>
                            @if ($person->specialization)
                                <p class="staff-specialization">{{ $person->specialization }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .staff-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .staff-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .staff-photo {
            width: 100%;
            height: 280px;
            background: var(--light);
            position: relative;
            overflow: hidden;
        }

        .staff-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .staff-card:hover .staff-photo img {
            transform: scale(1.1);
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
            font-weight: 700;
        }

        .staff-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            transition: bottom 0.3s ease;
        }

        .staff-card:hover .staff-social {
            bottom: 0;
        }

        .staff-social a {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .staff-social a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
        }

        .staff-info {
            padding: 25px;
        }

        .staff-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .staff-position {
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .staff-specialization {
            font-size: 0.85rem;
            color: #9ca3af;
        }
    </style>

    <!-- Donations Section -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-subtitle">Donasi</div>
                <h2 class="section-title">Salurkan Donasi Anda</h2>
                <p class="section-description">
                    Ikut berpartisipasi dalam kegiatan dakwah dan sosial melalui donasi Anda
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px;">
                @foreach ($donations as $donation)
                    <div class="donation-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        @if ($donation->is_urgent)
                            <div class="donation-urgent">
                                <i class="fas fa-exclamation-circle"></i> URGENT
                            </div>
                        @endif

                        <div class="donation-image"
                            style="background-image: url('{{ $donation->image ? asset('storage/' . $donation->image) : 'https://via.placeholder.com/600x400' }}');">
                        </div>

                        <div class="donation-content">
                            <div class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}</div>
                            <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                            <p class="donation-description">{{ Str::limit($donation->description, 100) }}</p>

                            @if ($donation->target_amount)
                                <div class="donation-progress">
                                    <div class="progress-info">
                                        <span class="progress-label">Terkumpul</span>
                                        <span
                                            class="progress-percentage">{{ number_format($donation->percentage, 1) }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width: {{ min($donation->percentage, 100) }}%;"></div>
                                    </div>
                                    <div class="progress-stats">
                                        <span class="amount-raised">Rp
                                            {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                        <span class="amount-target">dari Rp
                                            {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="donation-amount">
                                    <span class="amount-label">Terkumpul</span>
                                    <span class="amount-value">Rp
                                        {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <div class="donation-meta">
                                <span><i class="fas fa-users"></i> {{ number_format($donation->donor_count) }}
                                    Donatur</span>
                                @if ($donation->days_left)
                                    <span><i class="fas fa-clock"></i> {{ $donation->days_left }} hari lagi</span>
                                @endif
                            </div>

                            <a href="{{ route('donations.show', $donation->slug) }}" class="btn btn-primary"
                                style="width: 100%; justify-content: center;">
                                Donasi Sekarang
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 40px;" data-aos="fade-up">
                <a href="{{ route('donations') }}" class="btn btn-outline"
                    style="border: 2px solid var(--primary); color: var(--primary);">
                    Lihat Semua Program Donasi
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        .donation-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }

        .donation-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .donation-urgent {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--danger);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            z-index: 10;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .donation-image {
            width: 100%;
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .donation-content {
            padding: 30px;
        }

        .donation-category {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .donation-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .donation-description {
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .donation-progress {
            margin-bottom: 20px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
        }

        .progress-percentage {
            font-size: 1.1rem;
            color: var(--primary);
            font-weight: 700;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: #e5e7eb;
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50px;
            transition: width 1s ease;
        }

        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .amount-raised {
            font-weight: 700;
            color: var(--dark);
        }

        .amount-target {
            color: #9ca3af;
        }

        .donation-amount {
            background: var(--light);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-label {
            display: block;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .amount-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .donation-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .donation-meta i {
            margin-right: 5px;
        }
    </style>

    <!-- CTA Section -->
    <section class="section"
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;" data-aos="zoom-in">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">
                    Mari Bergabung Bersama Kami
                </h2>
                <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.95;">
                    Ikuti berbagai program kegiatan dan dakwah Islam di Masjid Agung Al Azhar.
                    Bersama kita membangun umat yang lebih baik.
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('programs') }}" class="btn" style="background: white; color: var(--primary);">
                        <i class="fas fa-calendar-check"></i>
                        Lihat Program
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">
                        <i class="fas fa-envelope"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
