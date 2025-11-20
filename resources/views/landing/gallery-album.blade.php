@extends('landing.layouts.app')

@section('title', $album->name . ' - Galeri - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('gallery') }}"
                        style="color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Galeri
                    </a>
                </div>
                <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px;">{{ $album->name }}</h1>
                @if ($album->description)
                    <p style="font-size: 1.1rem; opacity: 0.95; margin-bottom: 15px;">{{ $album->description }}</p>
                @endif
                <div style="display: flex; gap: 20px; flex-wrap: wrap; opacity: 0.95;">
                    @if ($album->event_date)
                        <span><i class="fas fa-calendar"></i> {{ $album->event_date->format('d F Y') }}</span>
                    @endif
                    <span><i class="fas fa-images"></i> {{ $galleries->count() }} Foto</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="section">
        <div class="container">
            @if ($galleries->count() > 0)
                <div class="masonry-grid">
                    @foreach ($galleries as $index => $gallery)
                        <div class="masonry-item" data-aos="zoom-in" data-aos-delay="{{ $index * 30 }}"
                            onclick="openLightbox({{ $index }})">
                            <img src="{{ $gallery->image ? asset('storage/' . $gallery->image) : 'https://via.placeholder.com/600x400' }}"
                                alt="{{ $gallery->title }}">
                            <div class="gallery-item-overlay">
                                <div class="overlay-content">
                                    <h4>{{ $gallery->title }}</h4>
                                    @if ($gallery->description)
                                        <p>{{ Str::limit($gallery->description, 60) }}</p>
                                    @endif
                                </div>
                                <div class="overlay-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 80px 20px;">
                    <i class="fas fa-image" style="font-size: 5rem; color: #e5e7eb; margin-bottom: 20px;"></i>
                    <h3 style="font-size: 1.8rem; color: #6b7280; margin-bottom: 10px;">Album Kosong</h3>
                    <p style="color: #9ca3af;">Belum ada foto di album ini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-content" id="lightbox-img">
        <div class="lightbox-caption" id="lightbox-caption"></div>
        <button class="lightbox-prev" onclick="event.stopPropagation(); changeLightboxImage(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="lightbox-next" onclick="event.stopPropagation(); changeLightboxImage(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="lightbox-counter" id="lightbox-counter"></div>
    </div>

    <style>
        .masonry-grid {
            column-count: 3;
            column-gap: 20px;
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .masonry-item:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .masonry-item img {
            width: 100%;
            display: block;
            transition: transform 0.5s ease;
        }

        .masonry-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item-overlay {
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

        .masonry-item:hover .gallery-item-overlay {
            opacity: 1;
        }

        .overlay-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .overlay-content p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .overlay-icon {
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
        }

        .lightbox.show {
            display: block;
            animation: fadeIn 0.3s;
        }

        .lightbox-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80vh;
            object-fit: contain;
            animation: zoomIn 0.3s;
        }

        .lightbox-caption {
            margin: 20px auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #f1f1f1;
            padding: 20px;
            font-size: 1.1rem;
        }

        .lightbox-caption strong {
            display: block;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 40px;
            color: #f1f1f1;
            font-size: 50px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
            z-index: 10000;
        }

        .lightbox-close:hover {
            color: #bbb;
        }

        .lightbox-prev,
        .lightbox-next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: 60px;
            height: 60px;
            margin-top: -30px;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            transition: 0.3s ease;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-prev {
            left: 30px;
            border-radius: 0 50px 50px 0;
        }

        .lightbox-next {
            right: 30px;
            border-radius: 50px 0 0 50px;
        }

        .lightbox-prev:hover,
        .lightbox-next:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .lightbox-counter {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
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

        @media (max-width: 1024px) {
            .masonry-grid {
                column-count: 2;
            }
        }

        @media (max-width: 768px) {
            .masonry-grid {
                column-count: 1;
            }

            .lightbox-prev,
            .lightbox-next {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .lightbox-prev {
                left: 10px;
            }

            .lightbox-next {
                right: 10px;
            }

            .lightbox-close {
                right: 20px;
                font-size: 40px;
            }
        }
    </style>

    <script>
        // Gallery Lightbox
        const galleryImages = [
            @foreach ($galleries as $gallery)
                {
                    src: "{{ $gallery->image ? asset('storage/' . $gallery->image) : 'https://via.placeholder.com/600x400' }}",
                    title: "{{ $gallery->title }}",
                    description: "{{ $gallery->description ?? '' }}"
                }
                {{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        let currentImageIndex = 0;

        function openLightbox(index) {
            currentImageIndex = index;
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            const caption = document.getElementById('lightbox-caption');
            const counter = document.getElementById('lightbox-counter');

            lightbox.classList.add('show');
            img.src = galleryImages[index].src;
            caption.innerHTML = `<strong>${galleryImages[index].title}</strong><br>${galleryImages[index].description}`;
            counter.innerHTML = `${index + 1} / ${galleryImages.length}`;
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
            const counter = document.getElementById('lightbox-counter');

            img.src = galleryImages[currentImageIndex].src;
            caption.innerHTML =
                `<strong>${galleryImages[currentImageIndex].title}</strong><br>${galleryImages[currentImageIndex].description}`;
            counter.innerHTML = `${currentImageIndex + 1} / ${galleryImages.length}`;
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
@endsection
