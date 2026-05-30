@extends('landing.layouts.app')

@section('title', $program->name . ' - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Program Content -->
    <section class="section" style="padding-top: 30px;">
        <div class="container">
            <div class="program-layout">
                <!-- Main Content -->
                <div class="main-content">
                    <div style="margin-bottom: 20px;" data-aos="fade-up">
                        <a href="{{ route('programs') }}"
                            style="color: var(--primary); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Program
                        </a>
                    </div>
                    
                    <div style="margin-bottom: 25px;" data-aos="fade-up" data-aos-delay="50">
                        <div
                            style="display: inline-block; background: var(--primary-light); color: var(--primary); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">
                            {{ ucfirst($program->type) }}
                        </div>
                        <h1 style="font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; color: var(--dark); margin-bottom: 15px; line-height: 1.2;">{{ $program->name }}</h1>
                        <p style="font-size: 1.1rem; color: #6b7280; line-height: 1.6;">{{ $program->description }}</p>
                    </div>

                    @if ($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}"
                            style="width: 100%; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);" data-aos="fade-up" data-aos-delay="100">
                    @endif

                    <div class="content-box" data-aos="fade-up">
                        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px;">Deskripsi Program</h2>
                        <div style="color: #6b7280; line-height: 1.8;">
                            {!! $program->content ?? '<p>' . $program->description . '</p>' !!}
                        </div>
                    </div>



                <!-- Sidebar Container dengan Batas -->
                <div class="sidebar-container">

                    <!-- Share Box (Non-Sticky) -->
                    <div class="sidebar-box share-box" data-aos="fade-left" data-aos-delay="100">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Bagikan Program</h3>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('program.detail', $program->slug)) }}"
                                target="_blank" class="share-btn" style="background: #1877f2;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('program.detail', $program->slug)) }}&text={{ urlencode($program->name) }}"
                                target="_blank" class="share-btn" style="background: #1da1f2;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($program->name . ' - ' . route('program.detail', $program->slug)) }}"
                                target="_blank" class="share-btn" style="background: #25d366;">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <button onclick="copyLink()" class="share-btn" style="background: #6b7280;">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>

                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
                            <p style="font-size: 0.85rem; color: #6b7280; text-align: center;">
                                <i class="fas fa-share-alt"></i> Bantu sebarkan program ini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Programs -->
    @if ($relatedPrograms->count() > 0)
        <section class="section" style="background: var(--light);">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="section-title">Program Terkait</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    @foreach ($relatedPrograms as $related)
                        <div class="program-card-small" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            @if ($related->image)
                                <div class="program-image-small"
                                    style="background-image: url('{{ asset('storage/' . $related->image) }}');"></div>
                            @else
                                <div class="program-image-small"
                                    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                                    <i class="{{ $related->icon ?? 'fas fa-mosque' }}"
                                        style="font-size: 3rem; color: white; opacity: 0.5;"></i>
                                </div>
                            @endif

                            <div style="padding: 20px;">
                                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 10px;">{{ $related->name }}
                                </h4>
                                <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 15px;">
                                    {{ Str::limit($related->description, 80) }}</p>
                                <a href="{{ route('program.detail', $related->slug) }}"
                                    style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <style>
        .program-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .main-content {
            /* Main content area */
        }

        .sidebar-container {
            /* Container normal, tidak perlu position */
        }

        .content-box {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .sidebar-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            /* Spacing antar box */
        }

        /* Hapus semua sticky behavior */


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
            border: none;
            cursor: pointer;
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

        .share-btn {
            flex: 1;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            min-width: 45px;
            /* Prevent too small on mobile */
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .program-card-small {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .program-card-small:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .program-image-small {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1024px) {
            .program-layout {
                grid-template-columns: 1fr !important;
            }

            .sidebar-container {
                margin-top: 20px;
            }

            .sidebar-box {
                margin-bottom: 20px;
            }

            .sidebar-box.share-box {
                margin-bottom: 0;
            }
        }

        @media (max-width: 480px) {
            .content-box {
                padding: 25px;
            }

            .sidebar-box {
                padding: 20px;
            }

            .detail-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .share-btn {
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    </script>
@endsection
