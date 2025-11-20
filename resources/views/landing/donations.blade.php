@extends('landing.layouts.app')

@section('title', 'Program Donasi - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Program Donasi</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Salurkan donasi Anda untuk berbagai program kegiatan dan bantuan sosial
                </p>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="section" style="background: var(--light); margin-top: -30px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                <div class="stat-box" data-aos="fade-up">
                    <div class="stat-icon"
                        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                        <i class="fas fa-hand-holding-heart" style="color: white;"></i>
                    </div>
                    <div class="stat-number">Rp {{ number_format($stats['total_collected'] / 1000000, 1) }}M</div>
                    <div class="stat-label">Total Terkumpul</div>
                </div>
                <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%);">
                        <i class="fas fa-users" style="color: white;"></i>
                    </div>
                    <div class="stat-number">{{ number_format($stats['total_donors']) }}</div>
                    <div class="stat-label">Total Donatur</div>
                </div>
                <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);">
                        <i class="fas fa-clipboard-list" style="color: white;"></i>
                    </div>
                    <div class="stat-number">{{ $stats['active_campaigns'] }}</div>
                    <div class="stat-label">Campaign Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .stat-box {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
        }
    </style>

    <!-- Featured Donations -->
    @if ($featuredDonations->count() > 0)
        <section class="section">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-subtitle">Prioritas</div>
                    <h2 class="section-title">Campaign Unggulan</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px;">
                    @foreach ($featuredDonations as $donation)
                        <div class="donation-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            @if ($donation->is_urgent)
                                <div class="donation-urgent">
                                    <i class="fas fa-exclamation-circle"></i> URGENT
                                </div>
                            @endif

                            <div class="donation-image"
                                style="background-image: url('{{ $donation->image ? asset('storage/' . $donation->image) : 'https://via.placeholder.com/600x400' }}');">
                            </div>

                            <div class="donation-content">
                                <div class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}
                                </div>
                                <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                                <p class="donation-description">{{ Str::limit($donation->description, 100) }}</p>

                                @if ($donation->target_amount)
                                    <div class="donation-progress">
                                        <div class="progress-info">
                                            <span class="progress-label">Terkumpul</span>
                                            <span
                                                class="progress-percentage">{{ number_format($donation->percentage, 1) }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill"
                                                style="width: {{ min($donation->percentage, 100) }}%;"></div>
                                        </div>
                                        <div class="progress-stats">
                                            <span class="amount-raised">Rp
                                                {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                            <span class="amount-target">dari Rp
                                                {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="donation-amount">
                                        <span class="amount-label">Terkumpul</span>
                                        <span class="amount-value">Rp
                                            {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="donation-meta">
                                    <span><i class="fas fa-users"></i> {{ number_format($donation->donor_count) }}
                                        Donatur</span>
                                    @if ($donation->days_left)
                                        <span><i class="fas fa-clock"></i> {{ $donation->days_left }} hari lagi</span>
                                    @endif
                                </div>

                                <a href="{{ route('donations.show', $donation->slug) }}" class="btn btn-primary"
                                    style="width: 100%; justify-content: center;">
                                    Donasi Sekarang
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- All Donations -->
    <section class="section" style="background: var(--light);">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Semua Program Donasi</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px;">
                @foreach ($donations as $donation)
                    <div class="donation-card" data-aos="fade-up">
                        @if ($donation->is_urgent)
                            <div class="donation-urgent">
                                <i class="fas fa-exclamation-circle"></i> URGENT
                            </div>
                        @endif

                        <div class="donation-image"
                            style="background-image: url('{{ $donation->image ? asset('storage/' . $donation->image) : 'https://via.placeholder.com/600x400' }}');">
                        </div>

                        <div class="donation-content">
                            <div class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}</div>
                            <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                            <p class="donation-description">{{ Str::limit($donation->description, 100) }}</p>

                            @if ($donation->target_amount)
                                <div class="donation-progress">
                                    <div class="progress-info">
                                        <span class="progress-label">Terkumpul</span>
                                        <span
                                            class="progress-percentage">{{ number_format($donation->percentage, 1) }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ min($donation->percentage, 100) }}%;">
                                        </div>
                                    </div>
                                    <div class="progress-stats">
                                        <span class="amount-raised">Rp
                                            {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                        <span class="amount-target">dari Rp
                                            {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="donation-amount">
                                    <span class="amount-label">Terkumpul</span>
                                    <span class="amount-value">Rp
                                        {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <div class="donation-meta">
                                <span><i class="fas fa-users"></i> {{ number_format($donation->donor_count) }}
                                    Donatur</span>
                                @if ($donation->days_left)
                                    <span><i class="fas fa-clock"></i> {{ $donation->days_left }} hari lagi</span>
                                @endif
                            </div>

                            <a href="{{ route('donations.show', $donation->slug) }}" class="btn btn-primary"
                                style="width: 100%; justify-content: center;">
                                Donasi Sekarang
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $donations->links() }}
            </div>
        </div>
    </section>

    <style>
        .donation-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }

        .donation-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .donation-urgent {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--danger);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            z-index: 10;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .donation-image {
            width: 100%;
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .donation-content {
            padding: 30px;
        }

        .donation-category {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .donation-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .donation-description {
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .donation-progress {
            margin-bottom: 20px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
        }

        .progress-percentage {
            font-size: 1.1rem;
            color: var(--primary);
            font-weight: 700;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: #e5e7eb;
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50px;
            transition: width 1s ease;
        }

        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .amount-raised {
            font-weight: 700;
            color: var(--dark);
        }

        .amount-target {
            color: #9ca3af;
        }

        .donation-amount {
            background: var(--light);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-label {
            display: block;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .amount-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .donation-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .donation-meta i {
            margin-right: 5px;
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
    </style>
@endsection
