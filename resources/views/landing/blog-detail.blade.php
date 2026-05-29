@extends('landing.layouts.app')

@section('title', $post->title . ' - ' . setting('site_name', 'Masjid Agung Al Azhar'))
@section('meta_description', Str::limit(strip_tags($post->excerpt), 160))

@push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .article-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 70px 0 50px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .article-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("{{ asset('storage/img/background.svg') }}"); background-size: cover; background-position: center;
            pointer-events: none;
        }

        .article-header-content {
            position: relative;
            max-width: 800px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--white);
            transform: translateX(-3px);
        }

        .article-category {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
        }

        .article-category:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .article-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 20px;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .article-meta-item i {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* ===== MAIN LAYOUT ===== */
        .article-section {
            padding: 50px 0;
        }

        .article-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 40px;
            align-items: start;
        }

        /* ===== ARTICLE CONTENT ===== */
        .article-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
            overflow: hidden;
        }

        .article-featured-image {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        /* Featured Video Embed */
        .article-featured-video {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            background: #000;
        }

        .article-featured-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Video Source Section (below content) */
        .article-video-source {
            margin-top: 32px;
            padding-top: 28px;
            border-top: 2px solid var(--border);
        }

        .video-source-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .video-source-header i {
            font-size: 1.4rem;
            color: #e53e3e;
        }

        .video-source-header h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .article-video-source .article-featured-video {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .article-body {
            padding: 32px;
        }

        /* Content Styling */
        .content-body {
            font-size: 1.05rem;
            line-height: 1.85;
            color: var(--text);
        }

        .content-body h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 32px 0 16px;
            color: var(--text-dark);
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary-light);
        }

        .content-body h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 28px 0 12px;
            color: var(--text-dark);
        }

        .content-body h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 24px 0 10px;
            color: var(--text-dark);
        }

        .content-body p {
            margin-bottom: 18px;
        }

        .content-body ul,
        .content-body ol {
            margin-bottom: 18px;
            padding-left: 24px;
        }

        .content-body li {
            margin-bottom: 8px;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 24px 0;
        }

        .content-body blockquote {
            border-left: 4px solid var(--primary);
            background: var(--primary-light);
            padding: 20px 24px;
            margin: 24px 0;
            border-radius: 0 12px 12px 0;
            font-style: italic;
            color: var(--text);
        }

        .content-body blockquote p:last-child {
            margin-bottom: 0;
        }

        .content-body a {
            color: var(--primary);
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .content-body a:hover {
            color: var(--primary-dark);
        }

        .content-body code {
            background: var(--bg);
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 0.9em;
            color: var(--primary-dark);
        }

        .content-body pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            overflow-x: auto;
            margin: 24px 0;
            font-size: 0.9rem;
        }

        .content-body pre code {
            background: none;
            padding: 0;
            color: inherit;
        }

        /* ===== TAGS ===== */
        .article-tags {
            padding-top: 24px;
            margin-top: 32px;
            border-top: 1px solid var(--border);
        }

        .tags-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-item {
            display: inline-block;
            background: var(--bg);
            color: var(--text);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }

        .tag-item:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* ===== SHARE BOX ===== */
        .share-box {
            background: var(--bg);
            padding: 24px;
            border-radius: 12px;
            margin-top: 32px;
        }

        .share-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 14px;
        }

        .share-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
        }

        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .share-btn.facebook {
            background: #1877f2;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.whatsapp {
            background: #25d366;
        }

        .share-btn.copy {
            background: var(--text-light);
        }

        /* ===== AUTHOR BOX ===== */
        .author-box {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-top: 32px;
        }

        .author-avatar {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .author-info h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .author-info p {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-light);
        }

        /* Sidebar Author */
        .sidebar-author {
            text-align: center;
        }

        .sidebar-author-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 14px;
        }

        .sidebar-author-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .sidebar-author-role {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* Related Posts */
        .related-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .related-item {
            display: flex;
            gap: 12px;
            text-decoration: none;
            padding: 10px;
            margin: -10px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .related-item:hover {
            background: var(--bg);
        }

        .related-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: var(--bg);
        }

        .related-content {
            flex: 1;
            min-width: 0;
        }

        .related-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-date {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Newsletter */
        .newsletter-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
        }

        .newsletter-card .sidebar-title {
            color: var(--white);
            border-bottom-color: rgba(255, 255, 255, 0.2);
        }

        .newsletter-text {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .newsletter-input {
            width: 100%;
            padding: 12px 14px;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .newsletter-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .newsletter-btn {
            width: 100%;
            padding: 12px;
            background: var(--white);
            color: var(--primary);
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .newsletter-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        /* ===== COMMENTS SECTION ===== */
        .comments-section {
            margin-top: 50px;
        }

        .comments-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        /* Comment Form */
        .comment-form-card {
            background: var(--white);
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
            margin-bottom: 32px;
        }

        .comment-form-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 83, 197, 0.3);
        }

        /* Comments List */
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .comment-card {
            background: var(--white);
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);
        }

        .comment-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 14px;
        }

        .comment-avatar {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .comment-meta {
            flex: 1;
        }

        .comment-author {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .comment-date {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .comment-text {
            font-size: 0.95rem;
            color: var(--text);
            line-height: 1.7;
        }

        /* Comment Replies */
        .comment-replies {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .reply-card {
            display: flex;
            gap: 12px;
            padding-left: 20px;
            border-left: 3px solid var(--primary-light);
        }

        .reply-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .reply-content {
            flex: 1;
        }

        .reply-author {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .reply-date {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-bottom: 6px;
        }

        .reply-text {
            font-size: 0.9rem;
            color: var(--text);
            line-height: 1.6;
        }

        /* ===== EMPTY COMMENTS ===== */
        .no-comments {
            text-align: center;
            padding: 40px 20px;
            background: var(--bg);
            border-radius: 14px;
        }

        .no-comments-icon {
            font-size: 2.5rem;
            color: var(--text-light);
            margin-bottom: 12px;
        }

        .no-comments-text {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .article-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .article-header {
                padding: 60px 0 40px;
            }

            .article-meta {
                gap: 12px 20px;
            }

            .article-section {
                padding: 30px 0;
            }

            .article-body {
                padding: 24px;
            }

            .content-body {
                font-size: 1rem;
            }

            .content-body h2 {
                font-size: 1.35rem;
            }

            .content-body h3 {
                font-size: 1.15rem;
            }

            .share-buttons {
                flex-direction: column;
            }

            .share-btn {
                justify-content: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .sidebar {
                grid-template-columns: 1fr;
            }

            .comment-form-card {
                padding: 20px;
            }

            .comment-card {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .article-body {
                padding: 20px;
            }

            .sidebar-card {
                padding: 20px;
            }

            .author-box {
                flex-direction: column;
                text-align: center;
            }
        }
        /* ===== GOOGLE VERIFY (COMMENT) ===== */
        .google-verify-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            border: 2px dashed var(--primary);
            border-radius: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .verify-box-icon {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            flex-shrink: 0;
        }

        .verify-box-text {
            flex: 1;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            min-width: 150px;
        }

        .btn-verify-small {
            padding: 8px 20px;
            background: var(--white);
            border: 2px solid #cbd5e0;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.82rem;
            color: #4a5568;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-verify-small:hover {
            border-color: #4285F4;
            color: #4285F4;
            box-shadow: 0 3px 10px rgba(66, 133, 244, 0.15);
            transform: translateY(-1px);
        }

        .comment-verified-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
            border: 2px solid #10b981;
            border-radius: 10px;
            margin-bottom: 16px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .comment-verified-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #10b981;
            flex-shrink: 0;
        }

        .comment-verified-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-verified-avatar i {
            font-size: 1rem;
            color: #10b981;
        }

        .comment-verified-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .comment-verified-name {
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--text-dark);
        }

        .comment-verified-email {
            font-size: 0.75rem;
            color: #065f46;
        }

        .comment-verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            background: #10b981;
            color: var(--white);
            border-radius: 50px;
            font-size: 0.68rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .btn-change-small {
            width: 30px;
            height: 30px;
            border: none;
            background: rgba(0,0,0,0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: #4a5568;
            font-size: 0.72rem;
            flex-shrink: 0;
        }

        .btn-change-small:hover {
            background: rgba(0,0,0,0.15);
        }

        .btn-submit:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-submit:disabled:hover {
            background: #cbd5e0;
            transform: none;
            box-shadow: none;
        }
    </style>
@endpush

@section('content')
    <!-- Article Content -->
    <section class="article-section" style="padding-top: 30px;">
        <div class="container">
            <div class="article-layout">
                <!-- Main Content -->
                <main>
                    <div style="margin-bottom: 25px;" data-aos="fade-up">
                        <a href="{{ route('blog') }}" class="back-link" style="color: var(--primary); font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Blog
                        </a>

                        <div style="margin-bottom: 15px;">
                            <a href="{{ route('blog') }}?category={{ $post->category->slug }}" class="article-category" style="background: var(--primary-light); color: var(--primary); margin-bottom: 0;">
                                {{ $post->category->name }}
                            </a>
                        </div>

                        <h1 class="article-title" style="color: var(--dark); margin-bottom: 15px;">{{ $post->title }}</h1>

                        <div class="article-meta" style="color: #6b7280;">
                            <span class="article-meta-item">
                                <i class="fas fa-user"></i>
                                {{ $post->author->name }}
                            </span>
                            <span class="article-meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $post->published_at->format('d F Y') }}
                            </span>
                            <span class="article-meta-item">
                                <i class="fas fa-eye"></i>
                                {{ number_format($post->views_count) }} views
                            </span>
                            @if ($post->reading_time)
                                <span class="article-meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $post->reading_time }} menit baca
                                </span>
                            @endif
                        </div>
                    </div>

                    <article class="article-card" data-aos="fade-up" data-aos-delay="100">
                        @if ($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                class="article-featured-image" loading="eager">
                        @endif

                        <div class="article-body">
                            <div class="content-body">
                                {!! $post->content !!}
                            </div>

                            {{-- Featured Video Source (optional, below content) --}}
                            @if ($post->featured_video)
                                <div class="article-video-source">
                                    <div class="video-source-header">
                                        <i class="fas fa-play-circle"></i>
                                        <h3>Video Sumber</h3>
                                    </div>
                                    <div class="article-featured-video">
                                        <iframe
                                            src="{{ \App\Helpers\VideoHelper::getEmbedUrl($post->featured_video) }}"
                                            title="{{ $post->title }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                </div>
                            @endif

                            <!-- Tags -->
                            @if ($post->tags->count() > 0)
                                <div class="article-tags">
                                    <p class="tags-label">Tags:</p>
                                    <div class="tags-list">
                                        @foreach ($post->tags as $tag)
                                            <a href="{{ route('blog') }}?tag={{ $tag->slug }}" class="tag-item">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Share -->
                            <div class="share-box">
                                <p class="share-label">Bagikan Artikel:</p>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.detail', $post->slug)) }}"
                                        target="_blank" rel="noopener" class="share-btn facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.detail', $post->slug)) }}&text={{ urlencode($post->title) }}"
                                        target="_blank" rel="noopener" class="share-btn twitter">
                                        <i class="fab fa-twitter"></i>
                                        Twitter
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.detail', $post->slug)) }}"
                                        target="_blank" rel="noopener" class="share-btn whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>

                            <!-- Author Box -->
                            <div class="author-box">
                                <div class="author-avatar">
                                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                </div>
                                <div class="author-info">
                                    <h4>{{ $post->author->name }}</h4>
                                    <p>Penulis & Kontributor</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    @if ($post->allow_comments ?? true)
                        <div class="comments-section" id="comments">
                            <h2 class="comments-title">
                                Komentar ({{ $post->approvedComments->count() }})
                            </h2>

                            <!-- Comment Form -->
                            <div class="comment-form-card">
                                <h3 class="comment-form-title">Tinggalkan Komentar</h3>

                                {{-- Success Message --}}
                                @if (session('success'))
                                    <div
                                        style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #6ee7b7;">
                                        <i class="fas fa-check-circle"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- Error Messages --}}
                                @if ($errors->any())
                                    <div
                                        style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #fecaca;">
                                        <ul style="margin: 0; padding-left: 20px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Google Verified Comment Form --}}
                                <form action="{{ route('blog.comment.submit', $post->slug) }}" method="POST" id="commentForm">
                                    @csrf
                                    <input type="hidden" name="google_verified" id="commentGoogleVerified" value="0">
                                    <input type="hidden" name="name" id="commentNameHidden">
                                    <input type="hidden" name="email" id="commentEmailHidden">

                                    <!-- Google Verification -->
                                    <div class="google-verify-box" id="commentVerifySection">
                                        <div class="verify-box-icon">
                                            <svg viewBox="0 0 24 24" width="22" height="22">
                                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                            </svg>
                                        </div>
                                        <span class="verify-box-text">Verifikasi akun Google untuk berkomentar</span>
                                        <button type="button" class="btn-verify-small" onclick="commentGoogleSignIn()">
                                            Verifikasi
                                        </button>
                                    </div>

                                    <!-- Verified Info -->
                                    <div class="comment-verified-card" id="commentVerifiedCard" style="display: none;">
                                        <div class="comment-verified-avatar" id="commentVerifiedAvatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="comment-verified-info">
                                            <span class="comment-verified-name" id="commentVerifiedName"></span>
                                            <span class="comment-verified-email" id="commentVerifiedEmail"></span>
                                        </div>
                                        <span class="comment-verified-badge">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                        <button type="button" class="btn-change-small" onclick="commentChangeAccount()" title="Ganti akun">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>

                                    <textarea name="comment" rows="4" placeholder="Tulis komentar Anda..." required class="form-textarea">{{ old('comment') }}</textarea>
                                    <button type="submit" class="btn-submit" id="btnCommentSubmit" disabled>
                                        <i class="fas fa-paper-plane"></i>
                                        Kirim Komentar
                                    </button>
                                </form>
                            </div>

                            <!-- Comments List -->
                            @if ($post->approvedComments->where('parent_id', null)->count() > 0)
                                <div class="comments-list">
                                    @foreach ($post->approvedComments->where('parent_id', null) as $comment)
                                        <div class="comment-card">
                                            <div class="comment-header">
                                                <div class="comment-avatar">
                                                    {{-- ✅ USE ACCESSOR --}}
                                                    {{ strtoupper(substr($comment->author, 0, 1)) }}
                                                </div>
                                                <div class="comment-meta">
                                                    {{-- ✅ USE ACCESSOR --}}
                                                    <div class="comment-author">{{ $comment->author }}</div>
                                                    <div class="comment-date">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                        @if ($comment->user)
                                                            <span style="color: var(--primary); margin-left: 8px;">
                                                                <i class="fas fa-check-circle"></i> Verified
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="comment-text">{{ $comment->content }}</p>

                                            <!-- Replies -->
                                            @if ($comment->replies->count() > 0)
                                                <div class="comment-replies">
                                                    @foreach ($comment->replies as $reply)
                                                        <div class="reply-card">
                                                            <div class="reply-avatar">
                                                                {{-- ✅ USE ACCESSOR --}}
                                                                {{ strtoupper(substr($reply->author, 0, 1)) }}
                                                            </div>
                                                            <div class="reply-content">
                                                                {{-- ✅ USE ACCESSOR --}}
                                                                <div class="reply-author">
                                                                    {{ $reply->author }}
                                                                    @if ($reply->user)
                                                                        <span
                                                                            style="color: var(--success); margin-left: 5px; font-size: 0.75rem;">
                                                                            <i class="fas fa-check-circle"></i> Admin
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="reply-date">
                                                                    {{ $reply->created_at->diffForHumans() }}
                                                                </div>
                                                                <p class="reply-text">{{ $reply->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-comments">
                                    <div class="no-comments-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <p class="no-comments-text">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                                </div>
                            @endif

                        </div>
                    @endif
                </main>
                <!-- Sidebar -->
                <aside class="sidebar">
                    <!-- About Author -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">Tentang Penulis</h3>
                        <div class="sidebar-author">
                            <div class="sidebar-author-avatar">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <div class="sidebar-author-name">{{ $post->author->name }}</div>
                            <div class="sidebar-author-role">Penulis & Kontributor</div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if ($relatedPosts->count() > 0)
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">Artikel Terkait</h3>
                            <div class="related-list">
                                @foreach ($relatedPosts as $related)
                                    <a href="{{ route('blog.detail', $related->slug) }}" class="related-item">
                                        <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('storage/img/placeholder.jpg') }}"
                                            alt="{{ $related->title }}" class="related-image" loading="lazy">
                                        <div class="related-content">
                                            <h4 class="related-title">{{ Str::limit($related->title, 55) }}</h4>
                                            <span
                                                class="related-date">{{ $related->published_at->format('d M Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Newsletter -->
                    <div class="sidebar-card newsletter-card">
                        <h3 class="sidebar-title">Newsletter</h3>
                        <p class="newsletter-text">Dapatkan update artikel terbaru langsung di inbox Anda.</p>
                        <form>
                            <input type="email" placeholder="Email Anda" required class="newsletter-input">
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane"></i>
                                Berlangganan
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        // Copy URL functionality
        function copyURL() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link berhasil disalin!');
            });
        }

        // Google Sign-In for Comments
        const COMMENT_GOOGLE_CLIENT_ID = '{{ config("services.google.client_id", "") }}';
        let commentIsVerified = false;

        function commentGoogleSignIn() {
            if (!COMMENT_GOOGLE_CLIENT_ID) {
                alert('Google Client ID belum dikonfigurasi. Hubungi administrator.');
                return;
            }

            google.accounts.id.initialize({
                client_id: COMMENT_GOOGLE_CLIENT_ID,
                callback: handleCommentGoogleResponse,
                auto_select: false,
            });

            google.accounts.id.prompt((notification) => {
                if (notification.isNotDisplayed() || notification.isSkippedMoment()) {
                    google.accounts.oauth2.initTokenClient({
                        client_id: COMMENT_GOOGLE_CLIENT_ID,
                        scope: 'email profile',
                        callback: handleCommentOAuthResponse,
                    }).requestAccessToken();
                }
            });
        }

        function handleCommentGoogleResponse(response) {
            const payload = parseCommentJwt(response.credential);
            if (payload && payload.email_verified) {
                setCommentVerifiedUser(payload.name, payload.email, payload.picture);
            }
        }

        function handleCommentOAuthResponse(tokenResponse) {
            fetch('https://www.googleapis.com/oauth2/v3/userinfo', {
                headers: { 'Authorization': 'Bearer ' + tokenResponse.access_token }
            })
            .then(res => res.json())
            .then(userInfo => {
                if (userInfo.email_verified) {
                    setCommentVerifiedUser(userInfo.name, userInfo.email, userInfo.picture);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Gagal memverifikasi. Silakan coba lagi.');
            });
        }

        function setCommentVerifiedUser(name, email, picture) {
            commentIsVerified = true;
            document.getElementById('commentNameHidden').value = name;
            document.getElementById('commentEmailHidden').value = email;
            document.getElementById('commentGoogleVerified').value = '1';
            document.getElementById('commentVerifiedName').textContent = name;
            document.getElementById('commentVerifiedEmail').textContent = email;

            if (picture) {
                document.getElementById('commentVerifiedAvatar').innerHTML = '<img src="' + picture + '" alt="Avatar">';
            }

            document.getElementById('commentVerifySection').style.display = 'none';
            document.getElementById('commentVerifiedCard').style.display = 'flex';
            document.getElementById('btnCommentSubmit').disabled = false;
        }

        function commentChangeAccount() {
            commentIsVerified = false;
            document.getElementById('commentNameHidden').value = '';
            document.getElementById('commentEmailHidden').value = '';
            document.getElementById('commentGoogleVerified').value = '0';
            document.getElementById('commentVerifySection').style.display = 'flex';
            document.getElementById('commentVerifiedCard').style.display = 'none';
            document.getElementById('btnCommentSubmit').disabled = true;
        }

        function parseCommentJwt(token) {
            try {
                const base64Url = token.split('.')[1];
                const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                return JSON.parse(decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join('')));
            } catch (e) { return null; }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('commentForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!commentIsVerified) {
                        e.preventDefault();
                        alert('Silakan verifikasi akun Google Anda terlebih dahulu.');
                    }
                });
            }
        });
    </script>
@endpush
