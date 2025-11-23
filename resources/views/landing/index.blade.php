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
                background: linear-gradient(135deg, #0053C5 0%, rgb(33, 120, 241) 100%);
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
                        <article class="post-card featured" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
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

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;" data-aos="zoom-in">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px; color: white;">
                    Mari Bergabung Bersama Kami
                </h2>
                <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.95; color: white;">
                    Ikuti berbagai program kegiatan dan dakwah Islam di Masjid Agung Al Azhar.
                    Bersama kita membangun umat yang lebih baik.
                </p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('programs') }}" class="btn cta-btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        Lihat Program
                    </a>
                    <a href="{{ route('contact') }}" class="btn cta-btn-outline">
                        <i class="fas fa-envelope"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Include all CSS styles from original file --}}
    @include('landing.layouts.index-styles')

    {{-- Include all JavaScript from original file --}}
    @include('landing.layouts.index-scripts')

@endsection
