@extends('landing.layouts.app')

@section('title', $donation->campaign_name . ' - ' . setting('site_name', 'Masjid Agung Al Azhar'))

@push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .donation-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 70px 0 50px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .donation-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("{{ asset('storage/img/background.svg') }}"); background-size: cover; background-position: center;
            pointer-events: none;
        }

        .donation-header-content {
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

        .header-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--white);
        }

        .header-badge.urgent {
            background: #dc2626;
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

        .donation-title {
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 14px;
        }

        .donation-excerpt {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 700px;
        }

        /* ===== MAIN LAYOUT ===== */
        .donation-section {
            padding: 50px 0;
        }

        .donation-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 40px;
            align-items: start;
        }

        /* ===== MAIN CONTENT ===== */
        .donation-image {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 83, 197, 0.1);
        }

        .content-card {
            background: var(--white);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
            margin-bottom: 24px;
        }

        .content-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-light);
        }

        .content-body {
            font-size: 0.95rem;
            color: var(--text);
            line-height: 1.8;
        }

        .content-body p {
            margin-bottom: 16px;
        }

        .content-body p:last-child {
            margin-bottom: 0;
        }

        .content-body h1, .content-body h2, .content-body h3, .content-body h4, .content-body h5, .content-body h6 {
            color: var(--text-dark);
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            font-weight: 700;
            line-height: 1.3;
        }
        
        .content-body h1 { font-size: 1.8rem; }
        .content-body h2 { font-size: 1.5rem; }
        .content-body h3 { font-size: 1.25rem; }

        .content-body ul, .content-body ol {
            margin-bottom: 16px;
            padding-left: 24px;
        }

        .content-body li {
            margin-bottom: 8px;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 16px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .content-body blockquote {
            border-left: 4px solid var(--primary);
            margin: 16px 0;
            color: var(--text-light);
            font-style: italic;
            background: var(--bg);
            padding: 16px 20px;
            border-radius: 0 8px 8px 0;
        }
        
        .content-body a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .content-body a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .content-body strong, .content-body b {
            font-weight: 700;
            color: var(--text-dark);
        }

        /* ===== DONORS LIST ===== */
        .donors-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .donor-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px;
            background: var(--bg);
            border-radius: 12px;
            transition: var(--transition);
        }

        .donor-item:hover {
            background: var(--primary-light);
        }

        .donor-avatar {
            width: 44px;
            height: 44px;
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

        .donor-info {
            flex: 1;
            min-width: 0;
        }

        .donor-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .donor-amount {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .donor-amount strong {
            color: var(--primary);
            font-weight: 700;
        }

        .donor-time {
            font-size: 0.75rem;
            color: var(--text-light);
            white-space: nowrap;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 25px rgba(0, 83, 197, 0.1);
            position: sticky;
            top: 90px;
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        /* Progress Section */
        .progress-section {
            margin-bottom: 24px;
        }

        .progress-amount-label {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 6px;
        }

        .progress-amount-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 14px;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
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

        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .progress-percent {
            font-weight: 700;
            color: var(--primary);
        }

        .progress-target {
            color: var(--text-light);
        }

        /* Amount Box (No Target) */
        .amount-box {
            text-align: center;
            padding: 24px;
            background: var(--bg);
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .amount-box-label {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 6px;
        }

        .amount-box-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* Stats Grid */
        .stats-mini {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-mini-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px;
            background: var(--bg);
            border-radius: 10px;
        }

        .stat-mini-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .stat-mini-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
        }

        .stat-mini-label {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Payment Methods */
        .payment-section {
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid var(--border);
        }

        .payment-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 14px;
        }

        .payment-item {
            display: flex;
            gap: 12px;
            padding: 14px;
            background: var(--bg);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .payment-item:last-child {
            margin-bottom: 0;
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .payment-info {
            flex: 1;
            min-width: 0;
        }

        .payment-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .payment-detail {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .payment-number {
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 0.5px;
        }

        /* CTA Button */
        .btn-donate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px 24px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            margin-top: 20px;
        }

        .btn-donate:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 83, 197, 0.3);
        }

        .secure-text {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 12px;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .secure-text i {
            color: #10b981;
        }

        /* Share Section */
        .share-section {
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid var(--border);
        }

        .share-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .share-buttons {
            display: flex;
            gap: 8px;
        }

        .share-btn {
            flex: 1;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            border-radius: 10px;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1rem;
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

        /* ===== RELATED SECTION ===== */
        .related-section {
            padding: 60px 0;
            background: var(--bg);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 32px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .related-card {
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 83, 197, 0.08);
            transition: var(--transition);
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 83, 197, 0.12);
        }

        .related-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: var(--bg);
        }

        .related-body {
            padding: 20px;
        }

        .related-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-desc {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 14px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-progress {
            margin-bottom: 14px;
        }

        .related-progress-bar {
            width: 100%;
            height: 6px;
            background: var(--bg);
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .related-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, #10b981 100%);
            border-radius: 50px;
        }

        .related-progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .related-progress-percent {
            font-weight: 700;
            color: var(--primary);
        }

        .related-progress-amount {
            color: var(--text-light);
        }

        .related-link {
            display: block;
            text-align: center;
            padding: 10px 16px;
            background: var(--primary);
            color: var(--white);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .related-link:hover {
            background: var(--primary-dark);
        }

        /* ===== EMPTY STATE ===== */
        .empty-donors {
            text-align: center;
            padding: 40px 20px;
            background: var(--bg);
            border-radius: 12px;
        }

        .empty-donors-icon {
            font-size: 2.5rem;
            color: var(--text-light);
            margin-bottom: 12px;
        }

        .empty-donors-text {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .donation-layout {
                grid-template-columns: 1fr;
            }

            .sidebar-card {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .donation-header {
                padding: 60px 0 40px;
            }

            .donation-section {
                padding: 30px 0;
            }

            .content-card {
                padding: 20px;
            }

            .sidebar-card {
                padding: 20px;
            }

            .stats-mini {
                grid-template-columns: 1fr;
            }

            .share-buttons {
                flex-wrap: wrap;
            }

            .share-btn {
                flex: 1 1 calc(50% - 4px);
            }

            .related-section {
                padding: 40px 0;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .header-badges {
                flex-direction: column;
                align-items: flex-start;
            }

            .donation-image {
                border-radius: 12px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <header class="donation-header">
        <div class="container">
            <div class="donation-header-content">
                <a href="{{ route('donations') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Donasi
                </a>

                <div class="header-badges">
                    <span class="header-badge">
                        {{ ucfirst(str_replace('_', ' ', $donation->category)) }}
                    </span>
                    @if ($donation->is_urgent ?? false)
                        <span class="header-badge urgent">
                            <i class="fas fa-exclamation-circle"></i>
                            URGENT
                        </span>
                    @endif
                </div>

                <h1 class="donation-title">{{ $donation->campaign_name }}</h1>
                <p class="donation-excerpt">{{ $donation->description }}</p>
            </div>
        </div>
    </header>

    <!-- Donation Content -->
    <section class="donation-section">
        <div class="container">
            <div class="donation-layout">
                <!-- Main Content -->
                <main>
                    @if ($donation->image)
                        <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->campaign_name }}"
                            class="donation-image" loading="eager">
                    @endif

                    <!-- About Campaign -->
                    <div class="content-card">
                        <h2 class="content-title">Tentang Campaign</h2>
                        <div class="content-body">
                            {!! $donation->content ?? '<p>' . nl2br(e($donation->description)) . '</p>' !!}
                        </div>
                    </div>


                </main>

                <!-- Sidebar -->
                <aside>
                    <div class="sidebar-card">

                        <!-- Payment Methods -->
                        <div class="payment-section">
                            <h4 class="payment-title">Metode Pembayaran</h4>

                            @if ($donation->bank_name && $donation->bank_account)
                                <div class="payment-item">
                                    <div class="payment-icon">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="payment-info">
                                        <div class="payment-name">Transfer Bank</div>
                                        <div class="payment-detail">{{ $donation->bank_name }}</div>
                                        <div class="payment-number">{{ $donation->bank_account }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($donation->qris_image)
                                <div class="payment-item">
                                    <div class="payment-icon">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <div class="payment-info">
                                        <div class="payment-name">QRIS</div>
                                        <div class="payment-detail">Scan QR Code untuk donasi</div>
                                        <div style="margin-top: 10px;">
                                            <img src="{{ asset('storage/' . $donation->qris_image) }}" alt="QRIS {{ $donation->campaign_name }}" style="max-width: 100%; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Button -->
                        <a href="{{ route('contact') }}" class="btn-donate">
                            <i class="fas fa-comments"></i>
                            Kontak Kami
                        </a>

                        <div class="secure-text">
                            <i class="fas fa-shield-alt"></i>
                            Donasi Anda aman dan terpercaya
                        </div>

                        <!-- Share Section -->
                        <div class="share-section">
                            <h4 class="share-title">Bagikan Campaign</h4>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('donations.show', $donation->slug)) }}"
                                    target="_blank" rel="noopener" class="share-btn facebook" title="Share ke Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('donations.show', $donation->slug)) }}&text={{ urlencode($donation->campaign_name) }}"
                                    target="_blank" rel="noopener" class="share-btn twitter" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($donation->campaign_name . ' - ' . route('donations.show', $donation->slug)) }}"
                                    target="_blank" rel="noopener" class="share-btn whatsapp" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <button onclick="copyLink()" class="share-btn copy" title="Salin Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Related Donations -->
    @if ($relatedDonations->count() > 0)
        <section class="related-section">
            <div class="container">
                <h2 class="section-title">Campaign Lainnya</h2>

                <div class="related-grid">
                    @foreach ($relatedDonations as $related)
                        <article class="related-card">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('storage/img/placeholder-donation.jpg') }}"
                                alt="{{ $related->campaign_name }}" class="related-image" loading="lazy">

                            <div class="related-body">
                                <h3 class="related-title">{{ $related->campaign_name }}</h3>
                                <p class="related-desc">{{ Str::limit($related->description, 70) }}</p>


                                <a href="{{ route('donations.show', $related->slug) }}" class="related-link">
                                    Lihat Detail
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
    <script>
        function copyLink() {
            const url = window.location.href;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showToast('Link berhasil disalin!');
                }).catch(function() {
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();

            try {
                document.execCommand('copy');
                showToast('Link berhasil disalin!');
            } catch (err) {
                showToast('Gagal menyalin link');
            }

            document.body.removeChild(textArea);
        }

        function showToast(message) {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #1e293b;
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                font-size: 0.9rem;
                z-index: 9999;
                animation: fadeInUp 0.3s ease;
            `;

            document.body.appendChild(toast);

            setTimeout(function() {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(function() {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }
    </script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
@endpush
