@extends('landing.layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description)

@section('content')
    <!-- Page Content -->
    <section class="section" style="padding-top: 80px;">
        <div class="container">
            <div style="max-width: 1000px; margin: 0 auto;">
                @if ($page->featured_image)
                    <div data-aos="fade-up" style="margin-bottom: 50px;">
                        <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}"
                            style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);">
                    </div>
                @endif

                <div class="page-content" data-aos="fade-up" data-aos-delay="100">
                    {!! $page->content !!}
                </div>

                <!-- Child Pages (if any) -->
                @if ($page->children && $page->children->count() > 0)
                    <div style="margin-top: 60px;" data-aos="fade-up">
                        <h2
                            style="font-size: 2rem; font-weight: 700; margin-bottom: 30px; color: var(--dark); text-align: center;">
                            Halaman Terkait
                        </h2>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                            @foreach ($page->children->where('status', 'published') as $child)
                                <a href="{{ route('page.show', $child->slug) }}" class="child-page-card">
                                    @if ($child->featured_image)
                                        <div class="child-page-image"
                                            style="background-image: url('{{ asset('storage/' . $child->featured_image) }}');">
                                        </div>
                                    @else
                                        <div class="child-page-image child-page-icon">
                                            <i class="{{ $child->icon ?? 'fas fa-file-alt' }}"></i>
                                        </div>
                                    @endif
                                    <div class="child-page-content">
                                        <h4>{{ $child->title }}</h4>
                                        @if ($child->meta_description)
                                            <p>{{ Str::limit($child->meta_description, 80) }}</p>
                                        @endif
                                        <span class="child-page-link">
                                            Lihat Detail <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section (if not a child page) -->
    @if (!$page->parent_id)
        <section class="section"
            style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
            <div class="container">
                <div style="max-width: 800px; margin: 0 auto; text-align: center;" data-aos="zoom-in">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">
                        Butuh Informasi Lebih Lanjut?
                    </h2>
                    <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.95;">
                        Hubungi kami untuk informasi lebih detail atau kunjungi program dan kegiatan kami.
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
    @endif
@endsection

@push('styles')
    <style>
        /* Page Content Styling */
        .page-content {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            font-size: 1.1rem;
            line-height: 1.8;
            color: #374151;
        }

        /* Typography */
        .page-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 40px 0 20px;
            color: var(--dark);
            line-height: 1.3;
        }

        .page-content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin: 35px 0 20px;
            color: var(--dark);
            line-height: 1.4;
            position: relative;
            padding-bottom: 10px;
        }

        .page-content h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 2px;
        }

        .page-content h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 30px 0 15px;
            color: var(--dark);
        }

        .page-content h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 25px 0 12px;
            color: var(--dark);
        }

        .page-content h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 20px 0 10px;
            color: var(--dark);
        }

        .page-content h6 {
            font-size: 1rem;
            font-weight: 700;
            margin: 15px 0 8px;
            color: var(--dark);
        }

        .page-content p {
            margin-bottom: 20px;
            color: #6b7280;
            line-height: 1.8;
        }

        .page-content strong,
        .page-content b {
            color: var(--dark);
            font-weight: 700;
        }

        .page-content em,
        .page-content i {
            font-style: italic;
        }

        .page-content a {
            color: var(--primary);
            text-decoration: underline;
            transition: all 0.3s ease;
        }

        .page-content a:hover {
            color: var(--primary-dark);
        }

        /* Lists */
        .page-content ul,
        .page-content ol {
            margin-bottom: 25px;
            padding-left: 30px;
            color: #6b7280;
        }

        .page-content ul {
            list-style: none;
        }

        .page-content ul li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 12px;
        }

        .page-content ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10px;
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
        }

        .page-content ol {
            list-style: decimal;
        }

        .page-content ol li {
            margin-bottom: 12px;
            padding-left: 10px;
        }

        /* Images */
        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 25px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Blockquote */
        .page-content blockquote {
            border-left: 4px solid var(--primary);
            padding: 20px 25px;
            margin: 30px 0;
            background: var(--light);
            border-radius: 0 12px 12px 0;
            font-style: italic;
            color: #4b5563;
        }

        .page-content blockquote p {
            margin-bottom: 0;
        }

        /* Code */
        .page-content code {
            background: var(--light);
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            color: var(--primary);
        }

        .page-content pre {
            background: #1f2937;
            color: #e5e7eb;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 25px 0;
        }

        .page-content pre code {
            background: none;
            padding: 0;
            color: #e5e7eb;
        }

        /* Tables */
        .page-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            overflow: hidden;
        }

        .page-content table th,
        .page-content table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .page-content table th {
            background: var(--light);
            font-weight: 700;
            color: var(--dark);
        }

        .page-content table tr:hover {
            background: var(--light);
        }

        /* HR */
        .page-content hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 40px 0;
        }

        /* Child Pages Cards */
        .child-page-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .child-page-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .child-page-image {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
            background-color: var(--light);
        }

        .child-page-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .child-page-icon i {
            font-size: 3rem;
            color: white;
            opacity: 0.9;
        }

        .child-page-content {
            padding: 20px;
        }

        .child-page-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .child-page-content p {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .child-page-link {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .child-page-card:hover .child-page-link {
            gap: 8px;
        }

        /* Buttons */
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

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-content {
                padding: 30px 25px;
                font-size: 1rem;
            }

            .page-content h1 {
                font-size: 2rem;
            }

            .page-content h2 {
                font-size: 1.6rem;
            }

            .page-content h3 {
                font-size: 1.4rem;
            }

            .page-content table {
                font-size: 0.9rem;
            }

            .page-content table th,
            .page-content table td {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .page-content {
                padding: 25px 20px;
            }

            .page-content ul,
            .page-content ol {
                padding-left: 20px;
            }

            .page-content blockquote {
                padding: 15px 20px;
            }
        }
    </style>
@endpush
