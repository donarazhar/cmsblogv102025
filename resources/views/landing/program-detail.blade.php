@extends('landing.layouts.app')

@section('title', $program->name . ' - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('programs') }}"
                        style="color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Program
                    </a>
                </div>
                <div
                    style="display: inline-block; background: rgba(255,255,255,0.2); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;">
                    {{ ucfirst($program->type) }}
                </div>
                <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px;">{{ $program->name }}</h1>
                <p style="font-size: 1.1rem; opacity: 0.95;">{{ $program->description }}</p>
            </div>
        </div>
    </section>

    <!-- Program Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                <!-- Main Content -->
                <div>
                    @if ($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}"
                            style="width: 100%; border-radius: 20px; margin-bottom: 30px;" data-aos="fade-up">
                    @endif

                    <div class="content-box" data-aos="fade-up">
                        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px;">Deskripsi Program</h2>
                        <div style="color: #6b7280; line-height: 1.8;">
                            {!! $program->content ?? '<p>' . $program->description . '</p>' !!}
                        </div>
                    </div>

                    @if ($program->organizer || $program->speaker || $program->contact_person)
                        <div class="content-box" data-aos="fade-up" data-aos-delay="100">
                            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px;">Informasi Tambahan</h2>

                            @if ($program->organizer)
                                <div style="margin-bottom: 15px;">
                                    <strong style="color: var(--dark);">Penyelenggara:</strong>
                                    <p style="color: #6b7280; margin-top: 5px;">{{ $program->organizer }}</p>
                                </div>
                            @endif

                            @if ($program->speaker)
                                <div style="margin-bottom: 15px;">
                                    <strong style="color: var(--dark);">Pembicara:</strong>
                                    <p style="color: #6b7280; margin-top: 5px;">{{ $program->speaker }}</p>
                                </div>
                            @endif

                            @if ($program->contact_person)
                                <div style="margin-bottom: 15px;">
                                    <strong style="color: var(--dark);">Contact Person:</strong>
                                    <p style="color: #6b7280; margin-top: 5px;">
                                        {{ $program->contact_person }}
                                        @if ($program->contact_phone)
                                            <br>{{ $program->contact_phone }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <div class="sidebar-box" data-aos="fade-left">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Detail Program</h3>

                        <div class="detail-list">
                            @if ($program->start_date)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Tanggal Mulai</div>
                                        <div class="detail-value">{{ $program->start_date->format('d F Y') }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->end_date)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Tanggal Selesai</div>
                                        <div class="detail-value">{{ $program->end_date->format('d F Y') }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->start_time)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Waktu</div>
                                        <div class="detail-value">
                                            {{ \Carbon\Carbon::parse($program->start_time)->format('H:i') }}
                                            @if ($program->end_time)
                                                - {{ \Carbon\Carbon::parse($program->end_time)->format('H:i') }} WIB
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->frequency)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-redo"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Frekuensi</div>
                                        <div class="detail-value">{{ ucfirst($program->frequency) }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->location)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Lokasi</div>
                                        <div class="detail-value">{{ $program->location }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->max_participants)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Peserta</div>
                                        <div class="detail-value">
                                            {{ $program->current_participants }}/{{ $program->max_participants }} orang
                                            @if ($program->is_full)
                                                <span
                                                    style="color: var(--danger); font-size: 0.85rem; display: block;">(Penuh)</span>
                                            @else
                                                <span
                                                    style="color: var(--success); font-size: 0.85rem; display: block;">({{ $program->available_slots }}
                                                    slot tersisa)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->registration_fee > 0)
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Biaya Pendaftaran</div>
                                        <div class="detail-value"
                                            style="color: var(--primary); font-weight: 700; font-size: 1.2rem;">
                                            Rp {{ number_format($program->registration_fee, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="detail-item-vertical">
                                    <div class="detail-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="detail-label">Biaya</div>
                                        <div class="detail-value" style="color: var(--success); font-weight: 700;">GRATIS
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($program->is_registration_open && !$program->is_full)
                            <a href="{{ route('contact') }}" class="btn btn-primary"
                                style="width: 100%; justify-content: center; margin-top: 20px;">
                                <i class="fas fa-user-plus"></i>
                                Daftar Sekarang
                            </a>
                        @elseif($program->is_full)
                            <button class="btn"
                                style="width: 100%; justify-content: center; margin-top: 20px; background: #9ca3af; cursor: not-allowed;"
                                disabled>
                                <i class="fas fa-times-circle"></i>
                                Pendaftaran Penuh
                            </button>
                        @else
                            <button class="btn"
                                style="width: 100%; justify-content: center; margin-top: 20px; background: #9ca3af; cursor: not-allowed;"
                                disabled>
                                <i class="fas fa-times-circle"></i>
                                Pendaftaran Ditutup
                            </button>
                        @endif

                        <a href="{{ route('contact') }}"
                            style="display: block; text-align: center; margin-top: 15px; color: var(--primary); text-decoration: none; font-weight: 600;">
                            <i class="fas fa-question-circle"></i> Punya pertanyaan?
                        </a>
                    </div>

                    <!-- Share Box -->
                    <div class="sidebar-box" data-aos="fade-left" data-aos-delay="100" style="margin-top: 30px;">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Bagikan Program</h3>
                        <div style="display: flex; gap: 10px;">
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
            position: sticky;
            top: 100px;
        }

        .detail-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .detail-item-vertical {
            display: flex;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .detail-item-vertical:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .detail-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

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
            section>div>div[style*="grid-template-columns: 2fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .sidebar-box {
                position: relative;
                top: 0;
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
