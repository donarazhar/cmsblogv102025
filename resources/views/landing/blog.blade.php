@extends('landing.layouts.app')

@section('title', 'Berita & Artikel - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Blog Content -->
    <section class="blog-section" style="padding-top: 80px;">
        <div class="container">
            <!-- Main Content -->
            <div class="main-content">
                <!-- Compact Search & Filter -->
                <div class="search-box" data-aos="fade-up">
                    <form method="GET" action="{{ route('blog') }}">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" placeholder="Cari artikel..."
                                value="{{ request('search') }}" class="search-input">
                            <button type="submit" class="search-btn">
                                <span>Cari</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Posts Grid -->
                @if ($posts->count() > 0)
                    <div class="posts-grid">
                        @foreach ($posts as $post)
                            <article class="post-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <a href="{{ route('blog.detail', $post->slug) }}" class="post-image-wrapper">
                                    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('storage/img/placeholder.jpg') }}"
                                        alt="{{ $post->title }}" class="post-image" loading="lazy">
                                    <span class="post-category">{{ $post->category->name }}</span>
                                </a>

                                <div class="post-body">
                                    <div class="post-meta">
                                        <span><i class="far fa-calendar"></i>
                                            {{ $post->published_at->format('d M Y') }}</span>
                                        <span><i class="far fa-eye"></i> {{ number_format($post->views_count) }}</span>
                                    </div>

                                    <h2 class="post-title">
                                        <a href="{{ route('blog.detail', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>

                                    <p class="post-excerpt">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>

                                    <div class="post-footer">
                                        <div class="post-author">
                                            <i class="far fa-user"></i>
                                            <span>{{ $post->author->name }}</span>
                                        </div>
                                        <a href="{{ route('blog.detail', $post->slug) }}" class="read-more">
                                            Baca <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Modern Pagination -->
                    <div class="pagination-wrapper">
                        {{ $posts->links('vendor.pagination.simple') }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="far fa-folder-open"></i>
                        <h3>Tidak Ada Artikel</h3>
                        <p>Belum ada artikel yang dipublikasikan.</p>
                    </div>
                @endif
            </div>

            <!-- Bottom Widgets (Moved from Sidebar) -->
            <div class="bottom-widgets">
                <!-- Terbaru Posts Widget -->
                @php
                    $latestPostsWidget = \App\Models\Post::published()->latest('published_at')->limit(4)->get();
                @endphp
                @if ($latestPostsWidget->count() > 0)
                    <div class="widget" data-aos="fade-up">
                        <h3 class="widget-title">Terbaru</h3>
                        <div class="popular-list">
                            @foreach ($latestPostsWidget as $latest)
                                <a href="{{ route('blog.detail', $latest->slug) }}" class="popular-item">
                                    <img src="{{ $latest->featured_image ? asset('storage/' . $latest->featured_image) : asset('storage/img/placeholder.jpg') }}"
                                        alt="{{ $latest->title }}" loading="lazy">
                                    <div class="popular-content">
                                        <h4>{{ Str::limit($latest->title, 50) }}</h4>
                                        <span class="popular-views">
                                            <i class="far fa-calendar"></i> {{ $latest->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Popular Posts Widget -->
                @if ($popularPosts->count() > 0)
                    <div class="widget" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="widget-title">Trending</h3>
                        <div class="popular-list">
                            @foreach ($popularPosts as $popular)
                                <a href="{{ route('blog.detail', $popular->slug) }}" class="popular-item">
                                    <img src="{{ $popular->featured_image ? asset('storage/' . $popular->featured_image) : asset('storage/img/placeholder.jpg') }}"
                                        alt="{{ $popular->title }}" loading="lazy">
                                    <div class="popular-content">
                                        <h4>{{ Str::limit($popular->title, 50) }}</h4>
                                        <span class="popular-views">
                                            <i class="far fa-eye"></i> {{ number_format($popular->views_count) }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Categories Widget -->
                <div class="widget" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="widget-title">Kategori</h3>
                    <div class="category-list">
                        @foreach ($categories as $category)
                            <a href="{{ route('blog') }}?category={{ $category->slug }}" class="category-item">
                                <span class="category-name">{{ $category->name }}</span>
                                <span class="category-count">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
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
            background: url("{{ asset('storage/img/background.svg') }}"); background-size: cover; background-position: center;
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

        /* Blog Section */
        .blog-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        /* Compact Search Box */
        .search-box {
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            background: var(--white);
            border-radius: 50px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .search-wrapper:focus-within {
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.15);
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            z-index: 1;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px 15px 50px;
            border: none;
            outline: none;
            font-size: 0.95rem;
            background: transparent;
        }

        .search-btn {
            padding: 15px 30px;
            background: var(--primary);
            color: var(--white);
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .search-btn:hover {
            background: var(--primary-dark);
        }

        /* Modern Posts Grid */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .post-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .post-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            display: block;
        }

        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .post-card:hover .post-image {
            transform: scale(1.08);
        }

        .post-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: var(--white);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 1;
        }

        .post-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .post-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-bottom: 12px;
        }

        .post-meta i {
            margin-right: 4px;
        }

        .post-title {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .post-title a {
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-title a:hover {
            color: var(--primary);
        }

        .post-excerpt {
            color: var(--gray-700);
            line-height: 1.6;
            font-size: 0.9rem;
            margin-bottom: 15px;
            flex: 1;
        }

        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--gray-300);
        }

        .post-author {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .read-more {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }

        .read-more:hover {
            gap: 10px;
        }

        /* Modern Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 60px;
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

        /* Bottom Widgets */
        .bottom-widgets {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding-top: 60px;
            border-top: 1px solid var(--gray-300);
        }

        .widget {
            background: var(--white);
            padding: 25px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .widget-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* Category List */
        .category-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--gray-700);
            transition: var(--transition);
            background: var(--gray-100);
        }

        .category-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(5px);
        }

        .category-name {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .category-count {
            background: var(--white);
            color: var(--gray-500);
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Popular Posts */
        .popular-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .popular-item {
            display: flex;
            gap: 12px;
            text-decoration: none;
            transition: var(--transition);
            padding: 8px;
            border-radius: var(--radius-sm);
        }

        .popular-item:hover {
            background: var(--gray-100);
            transform: translateX(5px);
        }

        .popular-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            flex-shrink: 0;
        }

        .popular-content h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .popular-views {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .popular-views i {
            margin-right: 4px;
        }

        /* Newsletter Widget */
        .widget-newsletter {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .newsletter-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .widget-newsletter .widget-title {
            color: var(--white);
            justify-content: center;
        }

        .widget-newsletter .widget-title::before {
            background: var(--white);
        }

        .widget-newsletter p {
            margin-bottom: 20px;
            opacity: 0.95;
            font-size: 0.9rem;
        }

        .widget-newsletter form {
            margin-top: auto;
        }

        .widget-newsletter input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: var(--radius-sm);
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .widget-newsletter button {
            width: 100%;
            padding: 12px;
            background: var(--white);
            color: var(--primary);
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .widget-newsletter button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--white);
            border-radius: var(--radius-lg);
            margin-bottom: 40px;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--gray-700);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray-500);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .posts-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .bottom-widgets {
                grid-template-columns: repeat(2, 1fr);
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

            .blog-section {
                padding: 40px 0;
            }

            .posts-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .bottom-widgets {
                grid-template-columns: 1fr;
            }

            .search-btn span {
                display: none;
            }

            .search-btn {
                padding: 15px 20px;
            }

            .search-btn::after {
                content: '\f002';
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
            }
        }

        @media (max-width: 480px) {
            .post-image-wrapper {
                height: 200px;
            }

            .post-body {
                padding: 15px;
            }

            .widget {
                padding: 20px;
            }
        }
    </style>
@endsection
