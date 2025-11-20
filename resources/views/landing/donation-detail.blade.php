@extends('landing.layouts.app')

@section('title', $donation->campaign_name . ' - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;" data-aos="fade-up">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('donations') }}"
                        style="color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Donasi
                    </a>
                </div>
                <div
                    style="display: inline-block; background: rgba(255,255,255,0.2); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;">
                    {{ ucfirst(str_replace('_', ' ', $donation->category)) }}
                </div>
                @if ($donation->is_urgent)
                    <div
                        style="display: inline-block; background: var(--danger); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; margin-left: 10px;">
                        <i class="fas fa-exclamation-circle"></i> URGENT
                    </div>
                @endif
                <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; line-height: 1.3;">
                    {{ $donation->campaign_name }}</h1>
                <p style="font-size: 1.1rem; opacity: 0.95;">{{ $donation->description }}</p>
            </div>
        </div>
    </section>

    <!-- Donation Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                <!-- Main Content -->
                <div>
                    @if ($donation->image)
                        <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->campaign_name }}"
                            style="width: 100%; border-radius: 20px; margin-bottom: 30px;" data-aos="fade-up">
                    @endif

                    <div class="content-box" data-aos="fade-up">
                        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px;">Tentang Campaign</h2>
                        <div style="color: #6b7280; line-height: 1.8;">
                            {!! $donation->content ?? '<p>' . $donation->description . '</p>' !!}
                        </div>
                    </div>

                    <!-- Recent Donations -->
                    @if ($recentDonations->count() > 0)
                        <div class="content-box" data-aos="fade-up" data-aos-delay="100">
                            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px;">Donatur Terbaru</h2>
                            <div class="donors-list">
                                @foreach ($recentDonations as $transaction)
                                    <div class="donor-item">
                                        <div class="donor-avatar">
                                            {{ strtoupper(substr($transaction->donor_name, 0, 1)) }}
                                        </div>
                                        <div class="donor-info">
                                            <h4>{{ $transaction->donor_name }}</h4>
                                            <p>Berdonasi <strong>Rp
                                                    {{ number_format($transaction->amount, 0, ',', '.') }}</strong></p>
                                        </div>
                                        <div class="donor-time">
                                            {{ $transaction->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <div class="donation-sidebar" data-aos="fade-left">
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 20px;">Progress Donasi</h3>

                        @if ($donation->target_amount)
                            <div class="donation-progress-large">
                                <div class="progress-amount">
                                    <span class="label">Terkumpul</span>
                                    <span class="amount">Rp
                                        {{ number_format($donation->current_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="progress-bar-large">
                                    <div class="progress-fill-large"
                                        style="width: {{ min($donation->percentage, 100) }}%;"></div>
                                </div>
                                <div class="progress-stats-large">
                                    <span>{{ number_format($donation->percentage, 1) }}%</span>
                                    <span>Target: Rp {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @else
                            <div
                                style="text-align: center; padding: 30px; background: var(--light); border-radius: 15px; margin-bottom: 20px;">
                                <div style="font-size: 0.9rem; color: #6b7280; margin-bottom: 10px;">Total Terkumpul</div>
                                <div style="font-size: 2rem; font-weight: 800; color: var(--primary);">
                                    Rp {{ number_format($donation->current_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <div class="stats-grid-small">
                            <div class="stat-item-small">
                                <i class="fas fa-users"></i>
                                <div>
                                    <div class="stat-value-small">{{ number_format($donation->donor_count) }}</div>
                                    <div class="stat-label-small">Donatur</div>
                                </div>
                            </div>
                            @if ($donation->days_left)
                                <div class="stat-item-small">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <div class="stat-value-small">{{ $donation->days_left }}</div>
                                        <div class="stat-label-small">Hari Lagi</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($donation->payment_methods)
                            <div style="margin-top: 30px; padding-top: 25px; border-top: 2px solid var(--border);">
                                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 15px;">Metode Pembayaran</h4>
                                @php
                                    $methods = is_string($donation->payment_methods)
                                        ? json_decode($donation->payment_methods, true)
                                        : $donation->payment_methods;
                                @endphp

                                @if (isset($methods['bank_transfer']))
                                    <div class="payment-method">
                                        <i class="fas fa-university"></i>
                                        <div>
                                            <strong>Transfer Bank</strong>
                                            <p>{{ $methods['bank_transfer']['bank'] ?? 'Bank Syariah Indonesia' }}</p>
                                            <p
                                                style="font-family: monospace; font-size: 1.1rem; color: var(--primary); font-weight: 700;">
                                                {{ $methods['bank_transfer']['account_number'] ?? '1234567890' }}
                                            </p>
                                            <p>a.n. {{ $methods['bank_transfer']['account_name'] ?? 'YPI Al Azhar' }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($methods['qris']) && $methods['qris'])
                                    <div class="payment-method">
                                        <i class="fas fa-qrcode"></i>
                                        <div>
                                            <strong>QRIS</strong>
                                            <p>Scan QR Code untuk donasi</p>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($methods['cash']) && $methods['cash'])
                                    <div class="payment-method">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>
                                            <strong>Tunai</strong>
                                            <p>Langsung ke sekretariat masjid</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('contact') }}" class="btn btn-primary"
                            style="width: 100%; justify-content: center; margin-top: 25px;">
                            <i class="fas fa-heart"></i>
                            Donasi Sekarang
                        </a>

                        <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #9ca3af;">
                            <i class="fas fa-lock"></i> Donasi Anda aman dan terpercaya
                        </p>

                        <!-- Share -->
                        <div style="margin-top: 30px; padding-top: 25px; border-top: 2px solid var(--border);">
                            <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 15px;">Bagikan Campaign</h4>
                            <div style="display: flex; gap: 10px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('donations.show', $donation->slug)) }}"
                                    target="_blank" class="share-btn-small" style="background: #1877f2;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('donations.show', $donation->slug)) }}&text={{ urlencode($donation->campaign_name) }}"
                                    target="_blank" class="share-btn-small" style="background: #1da1f2;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($donation->campaign_name . ' - ' . route('donations.show', $donation->slug)) }}"
                                    target="_blank" class="share-btn-small" style="background: #25d366;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <button onclick="copyLink()" class="share-btn-small" style="background: #6b7280;">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Donations -->
    @if ($relatedDonations->count() > 0)
        <section class="section" style="background: var(--light);">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="section-title">Campaign Lainnya</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
                    @foreach ($relatedDonations as $related)
                        <div class="donation-card-small" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="donation-image-small"
                                style="background-image: url('{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/400x300' }}');">
                            </div>
                            <div style="padding: 20px;">
                                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 10px;">
                                    {{ $related->campaign_name }}</h4>
                                <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 15px;">
                                    {{ Str::limit($related->description, 80) }}</p>

                                @if ($related->target_amount)
                                    <div class="progress-bar-mini">
                                        <div class="progress-fill-mini"
                                            style="width: {{ min($related->percentage, 100) }}%;"></div>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 0.85rem;">
                                        <span
                                            style="color: var(--primary); font-weight: 700;">{{ number_format($related->percentage, 1) }}%</span>
                                        <span style="color: #9ca3af;">Rp
                                            {{ number_format($related->current_amount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <a href="{{ route('donations.show', $related->slug) }}"
                                    style="display: block; text-align: center; margin-top: 15px; padding: 10px; background: var(--primary); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                                    Lihat Detail
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

        .donation-sidebar {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
        }

        .donation-progress-large {
            margin-bottom: 25px;
        }

        .progress-amount {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .progress-amount .label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .progress-amount .amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }

        .progress-bar-large {
            width: 100%;
            height: 12px;
            background: #e5e7eb;
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .progress-fill-large {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50px;
            transition: width 1s ease;
        }

        .progress-stats-large {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .progress-stats-large span:first-child {
            font-weight: 700;
            color: var(--primary);
        }

        .progress-stats-large span:last-child {
            color: #9ca3af;
        }

        .stats-grid-small {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item-small {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: var(--light);
            border-radius: 12px;
        }

        .stat-item-small i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .stat-value-small {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1;
        }

        .stat-label-small {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .payment-method {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: var(--light);
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .payment-method i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .payment-method strong {
            display: block;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .payment-method p {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .donors-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .donor-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--light);
            border-radius: 12px;
        }

        .donor-avatar {
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

        .donor-info {
            flex: 1;
        }

        .donor-info h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 3px;
            color: var(--dark);
        }

        .donor-info p {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .donor-time {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .share-btn-small {
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

        .share-btn-small:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .donation-card-small {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .donation-card-small:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .donation-image-small {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
        }

        .progress-bar-mini {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 50px;
            overflow: hidden;
        }

        .progress-fill-mini {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50px;
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

        @media (max-width: 1024px) {
            section>div>div[style*="grid-template-columns: 2fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .donation-sidebar {
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
