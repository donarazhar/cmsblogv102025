@extends('landing.layouts.app')

@section('title', $post->title . ' - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))
@section('meta_description', Str::limit(strip_tags($post->excerpt), 160))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;" data-aos="fade-up">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('blog') }}"
                        style="color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Blog
                    </a>
                </div>
                <a href="{{ route('blog') }}?category={{ $post->category->slug }}"
                    style="display: inline-block; background: rgba(255,255,255,0.2); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; color: white; text-decoration: none;">
                    {{ $post->category->name }}
                </a>
                <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px; line-height: 1.3;">{{ $post->title }}
                </h1>
                <div style="display: flex; gap: 25px; flex-wrap: wrap; opacity: 0.95; font-size: 0.95rem;">
                    <span><i class="fas fa-user"></i> {{ $post->author->name }}</span>
                    <span><i class="fas fa-calendar"></i> {{ $post->published_at->format('d F Y') }}</span>
                    <span><i class="fas fa-eye"></i> {{ number_format($post->views_count) }} views</span>
                    <span><i class="fas fa-clock"></i> {{ $post->reading_time }} menit baca</span>
                    <span><i class="fas fa-comments"></i> {{ $post->approvedComments->count() }} komentar</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 40px;">
                <!-- Main Content -->
                <div>
                    <article class="article-content" data-aos="fade-up">
                        @if ($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                style="width: 100%; border-radius: 20px; margin-bottom: 30px;">
                        @endif

                        <div class="content-body">
                            {!! $post->content !!}
                        </div>

                        <!-- Tags -->
                        @if ($post->tags->count() > 0)
                            <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid var(--border);">
                                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px;">Tags:</h3>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('blog') }}?tag={{ $tag->slug }}" class="tag-large">
                                            #{{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Share -->
                        <div style="margin-top: 40px; padding: 30px; background: var(--light); border-radius: 15px;">
                            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px;">Bagikan Artikel:</h3>
                            <div style="display: flex; gap: 10px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.detail', $post->slug)) }}"
                                    target="_blank" class="share-btn-large" style="background: #1877f2;">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.detail', $post->slug)) }}&text={{ urlencode($post->title) }}"
                                    target="_blank" class="share-btn-large" style="background: #1da1f2;">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.detail', $post->slug)) }}"
                                    target="_blank" class="share-btn-large" style="background: #25d366;">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Author Box -->
                        <div
                            style="margin-top: 40px; padding: 30px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); display: flex; gap: 20px; align-items: center;">
                            <div
                                style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; flex-shrink: 0;">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 5px;">
                                    {{ $post->author->name }}</h4>
                                <p style="color: #6b7280; font-size: 0.95rem;">Penulis</p>
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    @if ($post->allow_comments)
                        <div style="margin-top: 50px;" id="comments">
                            <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 30px;">
                                Komentar ({{ $post->approvedComments->count() }})
                            </h2>

                            <!-- Comment Form -->
                            <div class="comment-form-box" data-aos="fade-up">
                                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Tinggalkan Komentar
                                </h3>
                                <form action="{{ route('blog.detail', $post->slug) }}" method="POST">
                                    @csrf
                                    <div
                                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                        <input type="text" name="name" placeholder="Nama Anda" required
                                            style="padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px;">
                                        <input type="email" name="email" placeholder="Email Anda" required
                                            style="padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px;">
                                    </div>
                                    <textarea name="comment" rows="5" placeholder="Tulis komentar Anda..." required
                                        style="width: 100%; padding: 15px; border: 2px solid var(--border); border-radius: 8px; margin-bottom: 15px; font-family: inherit;"></textarea>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Kirim Komentar
                                    </button>
                                </form>
                            </div>

                            <!-- Comments List -->
                            @if ($post->approvedComments->count() > 0)
                                <div style="margin-top: 40px;">
                                    @foreach ($post->approvedComments->where('parent_id', null) as $comment)
                                        <div class="comment-item" data-aos="fade-up">
                                            <div class="comment-avatar">
                                                {{ strtoupper(substr($comment->author, 0, 1)) }}
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-header">
                                                    <h4>{{ $comment->author }}</h4>
                                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p>{{ $comment->content }}</p>

                                                <!-- Replies -->
                                                @foreach ($comment->replies as $reply)
                                                    <div class="comment-reply">
                                                        <div class="comment-avatar-small">
                                                            {{ strtoupper(substr($reply->author, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="comment-header">
                                                                <h4>{{ $reply->author }}</h4>
                                                                <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p>{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- About Author -->
                    <div class="sidebar-box" data-aos="fade-left">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Tentang Penulis</h3>
                        <div style="text-align: center;">
                            <div
                                style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; margin: 0 auto 15px;">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 5px;">{{ $post->author->name }}
                            </h4>
                            <p style="color: #6b7280; font-size: 0.9rem;">Penulis & Kontributor</p>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if ($relatedPosts->count() > 0)
                        <div class="sidebar-box" data-aos="fade-left" data-aos-delay="100">
                            <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Artikel Terkait</h3>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                @foreach ($relatedPosts as $related)
                                    <a href="{{ route('blog.detail', $related->slug) }}" class="related-post">
                                        <div class="related-post-image"
                                            style="background-image: url('{{ $related->featured_image ? asset('storage/' . $related->featured_image) : 'https://via.placeholder.com/100x100' }}');">
                                        </div>
                                        <div>
                                            <h4>{{ Str::limit($related->title, 60) }}</h4>
                                            <span>{{ $related->published_at->format('d M Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Newsletter -->
                    <div class="sidebar-box" data-aos="fade-left" data-aos-delay="200"
                        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 15px; color: white;">Newsletter</h3>
                        <p style="margin-bottom: 20px; opacity: 0.95;">Dapatkan update artikel terbaru.</p>
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
        .article-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #374151;
        }

        .content-body h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 30px 0 15px;
            color: var(--dark);
        }

        .content-body h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 25px 0 15px;
            color: var(--dark);
        }

        .content-body p {
            margin-bottom: 20px;
        }

        .content-body ul,
        .content-body ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }

        .content-body li {
            margin-bottom: 10px;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 20px 0;
        }

        .content-body blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #6b7280;
        }

        .tag-large {
            display: inline-block;
            background: var(--light);
            color: var(--dark);
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .tag-large:hover {
            background: var(--primary);
            color: white;
        }

        .share-btn-large {
            flex: 1;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .share-btn-large:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .comment-form-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .comment-item {
            display: flex;
            gap: 20px;
            padding: 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .comment-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .comment-header h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .comment-header span {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .comment-content>p {
            color: #6b7280;
            line-height: 1.6;
        }

        .comment-reply {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .comment-avatar-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            position: sticky;
            top: 100px;
        }

        .related-post {
            display: flex;
            gap: 15px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .related-post:hover {
            transform: translateX(5px);
        }

        .related-post-image {
            width: 80px;
            height: 80px;
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .related-post h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .related-post span {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            section>div>div[style*="grid-template-columns: 2.5fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .sidebar-box {
                position: relative;
                top: 0;
            }
        }
    </style>
@endsection
