@extends('landing.layouts.app')

@section('title', 'Program Kegiatan - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Program & Kegiatan</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Ikuti berbagai program kegiatan keagamaan yang kami selenggarakan
                </p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="section" style="padding-top: 40px;">
        <div class="container">
            <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; margin-bottom: 40px;"
                data-aos="fade-up">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-th"></i> Semua
                </button>
                <button class="filter-btn" data-filter="regular">
                    <i class="fas fa-calendar"></i> Regular
                </button>
                <button class="filter-btn" data-filter="event">
                    <i class="fas fa-calendar-star"></i> Event
                </button>
                <button class="filter-btn" data-filter="course">
                    <i class="fas fa-graduation-cap"></i> Kursus
                </button>
                <button class="filter-btn" data-filter="charity">
                    <i class="fas fa-hand-holding-heart"></i> Sosial
                </button>
            </div>

            <div class="programs-grid">
                @foreach ($programs as $program)
                    <div class="program-card" data-type="{{ $program->type }}" data-aos="fade-up">
                        @if ($program->image)
                            <div class="program-image"
                                style="background-image: url('{{ asset('storage/' . $program->image) }}');"></div>
                        @else
                            <div class="program-image"
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="{{ $program->icon ?? 'fas fa-mosque' }}"
                                    style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                            </div>
                        @endif

                        <div class="program-content">
                            <div class="program-type">{{ ucfirst($program->type) }}</div>

                            @if ($program->icon)
                                <div class="program-icon">
                                    <i class="{{ $program->icon }}"></i>
                                </div>
                            @endif

                            <h3 class="program-title">{{ $program->name }}</h3>
                            <p class="program-description">{{ Str::limit($program->description, 120) }}</p>

                            <div class="program-details">
                                @if ($program->start_time)
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($program->start_time)->format('H:i') }}</span>
                                    </div>
                                @endif

                                @if ($program->frequency)
                                    <div class="detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ ucfirst($program->frequency) }}</span>
                                    </div>
                                @endif

                                @if ($program->location)
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $program->location }}</span>
                                    </div>
                                @endif

                                @if ($program->max_participants)
                                    <div class="detail-item">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $program->current_participants }}/{{ $program->max_participants }}</span>
                                    </div>
                                @endif
                            </div>

                            @if ($program->registration_fee > 0)
                                <div class="program-fee">
                                    <span class="fee-label">Biaya:</span>
                                    <span class="fee-amount">Rp
                                        {{ number_format($program->registration_fee, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <a href="{{ route('program.detail', $program->slug) }}" class="program-link">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 50px; display: flex; justify-content: center;">
                {{ $programs->links() }}
            </div>
        </div>
    </section>

    <style>
        .filter-btn {
            padding: 12px 25px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark);
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .filter-btn i {
            font-size: 1rem;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .program-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .program-image {
            width: 100%;
            height: 220px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .program-content {
            padding: 30px;
        }

        .program-type {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .program-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
        }

        .program-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--dark);
            line-height: 1.4;
        }

        .program-description {
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .program-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
            padding: 20px;
            background: var(--light);
            border-radius: 12px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .detail-item i {
            width: 20px;
            color: var(--primary);
        }

        .program-fee {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .fee-label {
            font-size: 0.9rem;
            color: #92400e;
            font-weight: 600;
        }

        .fee-amount {
            font-size: 1.2rem;
            font-weight: 700;
            color: #92400e;
        }

        .program-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .program-link:hover {
            gap: 12px;
        }

        @media (max-width: 768px) {
            .programs-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const programCards = document.querySelectorAll('.program-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');

                // Update active button
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // Filter cards
                programCards.forEach(card => {
                    const type = card.getAttribute('data-type');

                    if (filter === 'all' || type === filter) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    </script>
@endsection
