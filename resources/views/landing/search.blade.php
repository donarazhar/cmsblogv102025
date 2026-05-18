@extends('landing.layouts.app')

@section('title', ($query ? 'Hasil Pencarian: ' . $query : 'Pencarian') . ' - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Compact Page Header -->
    <section class="search-header">
        <div class="container">
            <div class="header-content">
                <h1><i class="fas fa-search"></i> Pencarian</h1>
                <p>Temukan informasi, berita, layanan, dan kegiatan Masjid Agung Al Azhar</p>

                <!-- Search Form -->
                <form method="GET" action="{{ route('search') }}" class="search-form">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="q" placeholder="Ketik kata kunci pencarian..."
                            value="{{ $query }}" class="search-input" autofocus id="searchInput">
                        <button type="submit" class="search-btn">
                            <span>Cari</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Search Results -->
    <section class="search-results-section">
        <div class="container">
            @if ($query)
                <!-- Results Summary -->
                <div class="results-summary">
                    <p>
                        Menampilkan <strong>{{ $totalResults }}</strong> hasil untuk
                        "<strong>{{ $query }}</strong>"
                    </p>
                </div>

                @if ($totalResults > 0)
                    <!-- Blog Results -->
                    @if ($posts->count() > 0)
                        <div class="result-group">
                            <div class="result-group-header">
                                <h2><i class="fas fa-newspaper"></i> Berita & Artikel</h2>
                                <span class="result-count">{{ $posts->count() }} hasil</span>
                            </div>
                            <div class="result-list">
                                @foreach ($posts as $post)
                                    <a href="{{ route('blog.detail', $post->slug) }}" class="result-item">
                                        <div class="result-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="result-content">
                                            <h3>{{ $post->title }}</h3>
                                            <p>{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 160) }}</p>
                                            <div class="result-meta">
                                                @if ($post->category)
                                                    <span class="result-tag">{{ $post->category->name }}</span>
                                                @endif
                                                <span><i class="far fa-calendar"></i>
                                                    {{ $post->published_at->format('d M Y') }}</span>
                                                <span><i class="far fa-eye"></i>
                                                    {{ number_format($post->views_count) }} views</span>
                                            </div>
                                        </div>
                                        @if ($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                alt="{{ $post->title }}" class="result-thumb" loading="lazy">
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Program Results -->
                    @if ($programs->count() > 0)
                        <div class="result-group">
                            <div class="result-group-header">
                                <h2><i class="fas fa-mosque"></i> Layanan Masjid</h2>
                                <span class="result-count">{{ $programs->count() }} hasil</span>
                            </div>
                            <div class="result-list">
                                @foreach ($programs as $program)
                                    <a href="{{ route('program.detail', $program->slug) }}" class="result-item">
                                        <div class="result-icon program-icon">
                                            <i class="{{ $program->icon ?? 'fas fa-star' }}"></i>
                                        </div>
                                        <div class="result-content">
                                            <h3>{{ $program->name }}</h3>
                                            <p>{{ Str::limit(strip_tags($program->description), 160) }}</p>
                                            <div class="result-meta">
                                                @if ($program->frequency)
                                                    <span class="result-tag">{{ ucfirst($program->frequency) }}</span>
                                                @endif
                                                @if ($program->location)
                                                    <span><i class="fas fa-map-marker-alt"></i>
                                                        {{ $program->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}"
                                                alt="{{ $program->name }}" class="result-thumb" loading="lazy">
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Donation Results -->
                    @if ($donations->count() > 0)
                        <div class="result-group">
                            <div class="result-group-header">
                                <h2><i class="fas fa-hand-holding-heart"></i> Donasi</h2>
                                <span class="result-count">{{ $donations->count() }} hasil</span>
                            </div>
                            <div class="result-list">
                                @foreach ($donations as $donation)
                                    <a href="{{ route('donations.show', $donation->slug) }}" class="result-item">
                                        <div class="result-icon donation-icon">
                                            <i class="fas fa-hand-holding-heart"></i>
                                        </div>
                                        <div class="result-content">
                                            <h3>{{ $donation->campaign_name }}</h3>
                                            <p>{{ Str::limit(strip_tags($donation->description), 160) }}</p>
                                            <div class="result-meta">
                                                <span class="result-tag">Donasi</span>
                                                <span><i class="fas fa-users"></i>
                                                    {{ $donation->donor_count }} donatur</span>
                                            </div>
                                        </div>
                                        @if ($donation->image)
                                            <img src="{{ asset('storage/' . $donation->image) }}"
                                                alt="{{ $donation->campaign_name }}" class="result-thumb"
                                                loading="lazy">
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="no-results">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Tidak Ada Hasil</h3>
                        <p>Tidak ditemukan hasil untuk "<strong>{{ $query }}</strong>"</p>
                        <div class="no-results-suggestions">
                            <h4>Saran:</h4>
                            <ul>
                                <li>Periksa ejaan kata kunci Anda</li>
                                <li>Gunakan kata kunci yang lebih umum</li>
                                <li>Coba gunakan kata kunci yang berbeda</li>
                            </ul>
                        </div>
                    </div>
                @endif
            @else
                <!-- Initial Search State -->
                <div class="initial-state">
                    <div class="initial-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3>Jelajahi Masjid Agung Al Azhar</h3>
                    <p>Ketik kata kunci untuk mencari berita, layanan, donasi, dan informasi lainnya</p>

                    <div class="quick-links">
                        <h4>Pencarian Populer</h4>
                        <div class="quick-links-grid">
                            <a href="{{ route('search', ['q' => 'kajian']) }}" class="quick-link">
                                <i class="fas fa-book-open"></i> Kajian
                            </a>
                            <a href="{{ route('search', ['q' => 'sholat']) }}" class="quick-link">
                                <i class="fas fa-praying-hands"></i> Sholat
                            </a>
                            <a href="{{ route('search', ['q' => 'ramadhan']) }}" class="quick-link">
                                <i class="fas fa-moon"></i> Ramadhan
                            </a>
                            <a href="{{ route('search', ['q' => 'donasi']) }}" class="quick-link">
                                <i class="fas fa-hand-holding-heart"></i> Donasi
                            </a>
                            <a href="{{ route('search', ['q' => 'pendidikan']) }}" class="quick-link">
                                <i class="fas fa-graduation-cap"></i> Pendidikan
                            </a>
                            <a href="{{ route('search', ['q' => 'kegiatan']) }}" class="quick-link">
                                <i class="fas fa-calendar-alt"></i> Kegiatan
                            </a>
                        </div>
                    </div>
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
            --green: #38a169;
            --orange: #ed8936;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Search Header */
        .search-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 80px 0 60px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .search-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></svg>');
            opacity: 0.3;
        }

        .search-header .header-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .search-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .search-header h1 i {
            margin-right: 12px;
            opacity: 0.8;
        }

        .search-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 30px;
        }

        /* Search Form */
        .search-form .search-wrapper {
            display: flex;
            position: relative;
            background: var(--white);
            border-radius: 60px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .search-form .search-icon {
            position: absolute;
            left: 24px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.1rem;
            z-index: 1;
        }

        .search-form .search-input {
            flex: 1;
            padding: 18px 20px 18px 56px;
            border: none;
            outline: none;
            font-size: 1.05rem;
            color: var(--dark);
            background: transparent;
        }

        .search-form .search-input::placeholder {
            color: var(--gray-500);
        }

        .search-form .search-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 18px 32px;
            background: var(--primary);
            color: var(--white);
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-form .search-btn:hover {
            background: var(--primary-dark);
        }

        /* Search Results Section */
        .search-results-section {
            padding: 50px 0 80px;
            background: var(--gray-100);
            min-height: 50vh;
        }

        /* Results Summary */
        .results-summary {
            margin-bottom: 30px;
            padding: 16px 20px;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--primary);
        }

        .results-summary p {
            color: var(--gray-700);
            font-size: 0.95rem;
        }

        /* Result Group */
        .result-group {
            margin-bottom: 30px;
        }

        .result-group-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .result-group-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .result-group-header h2 i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .result-count {
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        /* Result Item */
        .result-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .result-item {
            display: flex;
            gap: 16px;
            padding: 20px;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            transition: var(--transition);
            align-items: flex-start;
        }

        .result-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .result-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .result-icon.program-icon {
            background: #fef3c7;
            color: #d97706;
        }

        .result-icon.donation-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .result-content {
            flex: 1;
            min-width: 0;
        }

        .result-content h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
            transition: var(--transition);
        }

        .result-item:hover .result-content h3 {
            color: var(--primary);
        }

        .result-content p {
            font-size: 0.9rem;
            color: var(--gray-700);
            line-height: 1.6;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .result-meta i {
            margin-right: 4px;
        }

        .result-tag {
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 10px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .result-thumb {
            width: 100px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            flex-shrink: 0;
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 80px 20px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .no-results-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .no-results-icon i {
            font-size: 2rem;
            color: var(--gray-300);
        }

        .no-results h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .no-results > p {
            color: var(--gray-500);
            margin-bottom: 30px;
        }

        .no-results-suggestions {
            text-align: left;
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
        }

        .no-results-suggestions h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .no-results-suggestions ul {
            list-style: disc;
            padding-left: 20px;
        }

        .no-results-suggestions li {
            font-size: 0.85rem;
            color: var(--gray-700);
            margin-bottom: 6px;
            line-height: 1.5;
        }

        /* Initial State */
        .initial-state {
            text-align: center;
            padding: 60px 20px;
        }

        .initial-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), #d1e3ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .initial-icon i {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .initial-state h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .initial-state > p {
            color: var(--gray-500);
            font-size: 1rem;
            margin-bottom: 40px;
        }

        /* Quick Links */
        .quick-links {
            max-width: 600px;
            margin: 0 auto;
        }

        .quick-links h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 16px;
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            color: var(--gray-700);
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .quick-link:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .quick-link i {
            color: var(--primary);
            transition: var(--transition);
        }

        .quick-link:hover i {
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-header {
                padding: 60px 0 40px;
            }

            .search-header h1 {
                font-size: 1.8rem;
            }

            .search-form .search-btn span {
                display: none;
            }

            .search-form .search-btn {
                padding: 18px 20px;
            }

            .result-thumb {
                width: 70px;
                height: 60px;
            }

            .result-item {
                padding: 16px;
            }

            .quick-links-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .result-thumb {
                display: none;
            }

            .quick-links-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .quick-link {
                padding: 10px 12px;
                font-size: 0.85rem;
            }
        }
    </style>
@endsection
