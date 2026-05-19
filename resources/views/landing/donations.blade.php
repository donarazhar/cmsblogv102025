@extends('landing.layouts.app')

@section('title', 'Program Donasi - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
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
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .page-header-content {
            position: relative;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .page-title {
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 1.05rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* ===== STATS SECTION ===== */
        .stats-section {
            margin-top: -40px;
            position: relative;
            z-index: 10;
            padding-bottom: 60px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: var(--white);
            padding: 28px 24px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 83, 197, 0.1);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 83, 197, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.5rem;
            color: var(--white);
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .stat-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: 60px 0;
        }

        .section-light {
            background: var(--bg);
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            color: var(--text-dark);
        }

        /* ===== DONATION GRID ===== */
        .donation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        /* ===== DONATION CARD ===== */
        .donation-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
            transition: var(--transition);
            position: relative;
        }

        .donation-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0, 83, 197, 0.15);
        }

        .donation-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #dc2626;
            color: var(--white);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 5;
            animation: pulse-badge 2s ease infinite;
        }

        @keyframes pulse-badge {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .donation-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: var(--bg);
        }

        .donation-body {
            padding: 20px;
        }

        .donation-category {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .donation-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .donation-desc {
            font-size: 0.875rem;
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Progress */
        .donation-progress {
            margin-bottom: 16px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .progress-label {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .progress-percent {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--bg);
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, #10b981 100%);
            border-radius: 50px;
            transition: width 1s ease;
        }

        .progress-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .amount-current {
            font-weight: 700;
            color: var(--text-dark);
        }

        .amount-target {
            color: var(--text-light);
        }

        /* Amount Box (for no target) */
        .donation-amount-box {
            background: var(--bg);
            padding: 16px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 16px;
        }

        .amount-box-label {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .amount-box-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Meta */
        .donation-meta {
            display: flex;
            gap: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-bottom: 16px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .meta-item i {
            font-size: 0.75rem;
            color: var(--primary);
        }

        /* Button */
        .btn-donate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 20px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-donate:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 83, 197, 0.3);
        }

        .btn-donate i {
            font-size: 0.85rem;
        }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 8px;
        }

        .pagination-wrapper .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            background: var(--white);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
        }

        .pagination-wrapper .page-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .pagination-wrapper .page-item.active .page-link {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .pagination-wrapper .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-text {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .page-header {
                padding: 60px 0 40px;
            }

            .stats-section {
                margin-top: -30px;
                padding-bottom: 40px;
            }

            .stat-card {
                padding: 24px 20px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .section {
                padding: 40px 0;
            }

            .donation-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .donation-image {
                height: 160px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Program Donasi</h1>
                <p class="page-subtitle">Salurkan donasi Anda untuk berbagai program kegiatan dan bantuan sosial</p>
            </div>
        </div>
    </section>





    <!-- All Donations -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Semua Program Donasi</h2>
            </div>

            @if ($donations->count() > 0)
                <div class="donation-grid">
                    @foreach ($donations as $donation)
                        <article class="donation-card">
                            @if ($donation->is_urgent ?? false)
                                <div class="donation-badge">
                                    <i class="fas fa-exclamation-circle"></i>
                                    URGENT
                                </div>
                            @endif

                            <img src="{{ $donation->image ? asset('storage/' . $donation->image) : asset('storage/img/placeholder-donation.jpg') }}"
                                alt="{{ $donation->campaign_name }}" class="donation-image" loading="lazy">

                            <div class="donation-body">
                                <span
                                    class="donation-category">{{ ucfirst(str_replace('_', ' ', $donation->category)) }}</span>
                                <h3 class="donation-title">{{ $donation->campaign_name }}</h3>
                                <p class="donation-desc">{{ Str::limit($donation->description, 80) }}</p>

                                <div class="donation-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-users"></i>
                                        {{ number_format($donation->donor_count) }} Donatur
                                    </span>
                                </div>

                                <a href="{{ route('donations.show', $donation->slug) }}" class="btn-donate">
                                    Donasi Sekarang
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($donations->hasPages())
                    <div class="pagination-wrapper">
                        {{ $donations->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Program Donasi</h3>
                    <p class="empty-text">Program donasi akan segera tersedia. Silakan kunjungi halaman ini kembali.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
