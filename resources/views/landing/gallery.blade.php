@extends('landing.layouts.app')

@section('title', 'Galeri Kegiatan - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Galeri Kegiatan</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Dokumentasi berbagai kegiatan yang telah kami laksanakan
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Albums -->
    <section class="section">
        <div class="container">
            @if ($albums->count() > 0)
                <div class="gallery-albums-grid">
                    @foreach ($albums as $album)
                        <a href="{{ route('gallery.album', $album->slug) }}" class="gallery-album-card" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="album-cover"
                                style="background-image: url('{{ $album->cover_image ? asset('storage/' . $album->cover_image) : 'https://via.placeholder.com/600x400' }}');">
                                <div class="album-overlay">
                                    <div class="album-count">
                                        <i class="fas fa-images"></i>
                                        <span>{{ $album->galleries_count }} Foto</span>
                                    </div>
                                </div>
                            </div>
                            <div class="album-info">
                                <h3 class="album-title">{{ $album->name }}</h3>
                                @if ($album->description)
                                    <p class="album-description">{{ Str::limit($album->description, 80) }}</p>
                                @endif
                                <div class="album-meta">
                                    @if ($album->event_date)
                                        <span><i class="fas fa-calendar"></i>
                                            {{ $album->event_date->format('d F Y') }}</span>
                                    @endif
                                    <span><i class="fas fa-images"></i> {{ $album->galleries_count }} Foto</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="margin-top: 50px; display: flex; justify-content: center;">
                    {{ $albums->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 80px 20px;">
                    <i class="fas fa-images" style="font-size: 5rem; color: #e5e7eb; margin-bottom: 20px;"></i>
                    <h3 style="font-size: 1.8rem; color: #6b7280; margin-bottom: 10px;">Belum Ada Album</h3>
                    <p style="color: #9ca3af;">Album galeri akan segera ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>

    <style>
        .gallery-albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .gallery-album-card {
            text-decoration: none;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .gallery-album-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .album-cover {
            width: 100%;
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .album-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-album-card:hover .album-overlay {
            opacity: 1;
        }

        .album-count {
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .album-count i {
            color: var(--primary);
        }

        .album-info {
            padding: 25px;
        }

        .album-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .album-description {
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .album-meta {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .album-meta i {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .gallery-albums-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
