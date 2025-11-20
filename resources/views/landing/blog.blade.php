@extends('landing.layouts.app')

@section('title', 'Berita & Artikel - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Berita & Artikel</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Ikuti perkembangan dan kegiatan terbaru dari Masjid Al Azhar
                </p>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 40px;">
                <!-- Main Content -->
                <div>
                    <!-- Search & Filter -->
                    <div style="margin-bottom: 30px;" data-aos="fade-up">
                        <form method="GET" action="{{ route('blog') }}">
                            <div style="display: flex; gap: 15px;">
                                <input type="text" name="search" placeholder="Cari artikel..."
                                    value="{{ request('search') }}"
                                    style="flex: 1; padding: 15px 20px; border: 2px solid var(--border); border-radius: 50px; font-size: 1rem;">
                                <button type="submit"
                                    style="padding: 15px 30px; background: var(--primary); color: white; border: none; border-radius: 50px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Posts Grid -->
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <article class="blog-post-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <a href="{{ route('blog.detail', $post->slug) }}" class="post-image-link">
                                    <div class="post-image-horizontal"
                                        style="background-image: url('{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/800x500' }}');">
                                    </div>
                                </a>

                                <div class="post-content-horizontal">
                                    <div class="post-meta-horizontal">
                                        <a href="{{ route('blog') }}?category={{ $post->category->slug }}"
                                            class="post-category-badge">
                                            {{ $post->category->name }}
                                        </a>
                                        <div class="post-meta-items">
                                            <span><i class="fas fa-user"></i> {{ $post->author->name }}</span>
                                            <span><i class="fas fa-calendar"></i>
                                                {{ $post->published_at->format('d M Y') }}</span>
                                            <span><i class="fas fa-eye"></i> {{ number_format($post->views_count) }}</span>
                                            <span><i class="fas fa-clock"></i> {{ $post->reading_time }} menit</span>
                                        </div>
                                    </div>

                                    <h2 class="post-title-horizontal">
                                        <a href="{{ route('blog.detail', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>

                                    <p class="post-excerpt-horizontal">{{ Str::limit(strip_tags($post->excerpt), 180) }}
                                    </p>

                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                        <a href="{{ route('blog.detail', $post->slug) }}" class="read-more-link">
                                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>

                                        @if ($post->tags->count() > 0)
                                            <div class="post-tags">
                                                @foreach ($post->tags->take(2) as $tag)
                                                    <a href="{{ route('blog') }}?tag={{ $tag->slug }}"
                                                        class="tag-badge">
                                                        #{{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        <!-- Pagination -->
                        <div style="margin-top: 50px;">
                            {{ $posts->links('vendor.pagination.simple') }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 60px 20px;">
                            <i class="fas fa-inbox" style="font-size: 4rem; color: #e5e7eb; margin-bottom: 20px;"></i>
                            <h3 style="font-size: 1.5rem; color: #6b7280; margin-bottom: 10px;">Tidak Ada Artikel</h3>
                            <p style="color: #9ca3af;">Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Categories -->
                    <div class="sidebar-widget" data-aos="fade-left">
                        <h3 class="widget-title">Kategori</h3>
                        <ul class="category-list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('blog') }}?category={{ $category->slug }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="count">{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Popular Posts -->
                    @if ($popularPosts->count() > 0)
                        <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                            <h3 class="widget-title">Artikel Populer</h3>
                            <div class="popular-posts">
                                @foreach ($popularPosts as $popular)
                                    <a href="{{ route('blog.detail', $popular->slug) }}" class="popular-post-item">
                                        <div class="popular-post-image"
                                            style="background-image: url('{{ $popular->featured_image ? asset('storage/' . $popular->featured_image) : 'https://via.placeholder.com/100x100' }}');">
                                        </div>
                                        <div class="popular-post-content">
                                            <h4>{{ Str::limit($popular->title, 60) }}</h4>
                                            <div class="popular-post-meta">
                                                <span><i class="fas fa-eye"></i>
                                                    {{ number_format($popular->views_count) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Newsletter -->
                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="200"
                        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
                        <h3 class="widget-title" style="color: white;">Newsletter</h3>
                        <p style="margin-bottom: 20px; opacity: 0.95;">Dapatkan update artikel terbaru langsung ke email
                            Anda.</p>
                        <form>
                            <input type="email" placeholder="Email Anda"
                                style="width: 100%; padding: 12px 15px; border: none; border-radius: 8px; margin-bottom: 10px;">
                            <button type="submit"
                                style="width: 100%; padding: 12px; background: white; color: var(--primary); border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                Berlangganan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .blog-post-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            display: flex;
            gap: 25px;
            transition: all 0.3s ease;
        }

        .blog-post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .post-image-link {
            flex-shrink: 0;
            width: 350px;
        }

        .post-image-horizontal {
            width: 100%;
            height: 100%;
            min-height: 280px;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }

        .blog-post-card:hover .post-image-horizontal {
            transform: scale(1.05);
        }

        .post-content-horizontal {
            padding: 30px 30px 30px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .post-meta-horizontal {
            margin-bottom: 15px;
        }

        .post-category-badge {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .post-meta-items {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: #9ca3af;
            flex-wrap: wrap;
        }

        .post-meta-items i {
            margin-right: 5px;
        }

        .post-title-horizontal {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .post-title-horizontal a {
            color: var(--dark);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-title-horizontal a:hover {
            color: var(--primary);
        }

        .post-excerpt-horizontal {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
        }

        .read-more-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .read-more-link:hover {
            gap: 12px;
        }

        .post-tags {
            display: flex;
            gap: 8px;
        }

        .tag-badge {
            background: var(--light);
            color: #6b7280;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .tag-badge:hover {
            background: var(--primary);
            color: white;
        }

        /* Sidebar */
        .sidebar-widget {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .widget-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        .category-list {
            list-style: none;
        }

        .category-list li {
            border-bottom: 1px solid var(--border);
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list a {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .category-list a:hover {
            color: var(--primary);
            padding-left: 10px;
        }

        .category-list .count {
            background: var(--light);
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Popular Posts */
        .popular-posts {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .popular-post-item {
            display: flex;
            gap: 15px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .popular-post-item:hover {
            transform: translateX(5px);
        }

        .popular-post-image {
            width: 80px;
            height: 80px;
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .popular-post-content h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .popular-post-meta {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .popular-post-meta i {
            margin-right: 5px;
        }

        /* ✅ PAGINATION STYLING - TAMBAHKAN INI */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            padding: 0 15px;
            background: white;
            color: var(--dark);
            border: 2px solid var(--border);
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .pagination .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #9ca3af;
            border-color: #e5e7eb;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Previous & Next buttons */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0 20px;
        }

        /* Dots */
        .pagination .page-item .page-link[aria-label*="..."] {
            border: none;
            background: transparent;
            pointer-events: none;
        }

        @media (max-width: 1024px) {
            section>div>div[style*="grid-template-columns: 2.5fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .blog-post-card {
                flex-direction: column;
            }

            .post-image-link {
                width: 100%;
            }

            .post-content-horizontal {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .pagination .page-link {
                min-width: 40px;
                height: 40px;
                padding: 0 12px;
                font-size: 0.9rem;
            }

            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link {
                padding: 0 15px;
            }

            /* Hide some page numbers on mobile */
            .pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
                display: none;
            }
        }
    </style>
@endsection
