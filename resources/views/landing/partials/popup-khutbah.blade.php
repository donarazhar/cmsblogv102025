@php
    $allActivePopups = \App\Models\PopupAd::active()->ordered()->get();
    $popupAd = $allActivePopups->first(function ($popup) {
        return $popup->matchesCurrentRoute();
    });
@endphp

@if($popupAd)
{{-- Popup Iklan - Dinamis --}}
<style>
    /* ===== POPUP AD OVERLAY ===== */
    .popup-ad-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    .popup-ad-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ===== POPUP WRAPPER (card + button grouped) ===== */
    .popup-ad-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-height: calc(100vh - 32px);
        max-height: calc(100dvh - 32px);
        transform: scale(0.85) translateY(30px);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .popup-ad-overlay.active .popup-ad-wrapper {
        transform: scale(1) translateY(0);
    }

    /* ===== CLOSE BUTTON (top-right of overlay) ===== */
    .popup-ad-close {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 30px;
        height: 30px;
        background: #ef4444;
        border: 2px solid #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.75rem;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        padding: 0;
        line-height: 1;
    }

    .popup-ad-close:hover {
        background: #dc2626;
        transform: rotate(90deg) scale(1.15);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.5);
    }

    /* ===== POPUP CARD (white card) ===== */
    .popup-ad-card {
        max-width: 420px;
        width: 100%;
        max-height: calc(100vh - 32px);
        max-height: calc(100dvh - 32px);
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
    }

    /* ===== HEADER (Title + Description) ===== */
    .popup-ad-header {
        flex-shrink: 0;
        padding: 20px 24px 12px 24px;
        text-align: center;
    }

    .popup-ad-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.35;
        margin-bottom: 6px;
        letter-spacing: -0.01em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .popup-ad-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 400;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== IMAGE SECTION (flexible, shrinks to fit) ===== */
    .popup-ad-image-wrapper {
        flex: 1 1 auto;
        min-height: 0;
        padding: 0 20px 12px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .popup-ad-image-link {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        border-radius: 12px;
        width: 100%;
        max-height: 100%;
    }

    .popup-ad-image-link::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            transparent 60%,
            rgba(0, 0, 0, 0.03) 100%
        );
        pointer-events: none;
        transition: all 0.4s ease;
        border-radius: 12px;
    }

    .popup-ad-image-link:hover::after {
        background: linear-gradient(
            to bottom,
            rgba(0, 83, 197, 0.03) 0%,
            rgba(0, 83, 197, 0.08) 100%
        );
    }

    .popup-ad-image {
        width: 100%;
        height: 100%;
        max-height: 100%;
        display: block;
        border-radius: 12px;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .popup-ad-image-link:hover .popup-ad-image {
        transform: scale(1.02);
    }

    /* ===== CTA BUTTON (inside card, fixed at bottom) ===== */
    .popup-ad-footer {
        flex-shrink: 0;
        padding: 4px 24px 16px 24px;
        text-align: center;
    }

    .popup-ad-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 28px;
        background: #25D366;
        border: none;
        border-radius: 50px;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4);
    }

    .popup-ad-cta:hover {
        background: #1fb855;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 211, 102, 0.5);
    }

    .popup-ad-cta i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .popup-ad-cta:hover i {
        transform: translateX(3px);
    }

    /* ===== DECORATIVE SHIMMER ===== */
    .popup-ad-image-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        z-index: 2;
        animation: popupShimmer 3s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes popupShimmer {
        0% { left: -100%; }
        50% { left: 150%; }
        100% { left: 150%; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 576px) {
        .popup-ad-overlay {
            padding: 12px;
        }

        .popup-ad-wrapper {
            max-height: calc(100vh - 24px);
            max-height: calc(100dvh - 24px);
        }

        .popup-ad-card {
            max-width: 92vw;
            max-height: calc(100vh - 24px);
            max-height: calc(100dvh - 24px);
            border-radius: 14px;
        }

        .popup-ad-header {
            padding: 16px 18px 8px 18px;
        }

        .popup-ad-title {
            font-size: 1.05rem;
            margin-bottom: 4px;
        }

        .popup-ad-subtitle {
            font-size: 0.8rem;
        }

        .popup-ad-image-wrapper {
            padding: 0 14px 10px 14px;
        }

        .popup-ad-image-link {
            border-radius: 10px;
        }

        .popup-ad-image {
            border-radius: 10px;
        }

        .popup-ad-footer {
            padding: 2px 14px 14px 14px;
        }

        .popup-ad-cta {
            padding: 9px 22px;
            font-size: 0.82rem;
        }

        .popup-ad-close {
            width: 28px;
            height: 28px;
            top: -6px;
            right: -6px;
            font-size: 0.7rem;
        }
    }
</style>

{{-- Popup Ad HTML --}}
<div class="popup-ad-overlay" id="popupAdOverlay">
    <div class="popup-ad-wrapper">
        {{-- Close Button (top-right corner of card) --}}
        <button class="popup-ad-close" id="popupAdClose" type="button" aria-label="Tutup popup">
            <i class="fas fa-times"></i>
        </button>

        {{-- White Card --}}
        <div class="popup-ad-card">
            {{-- Header: Title + Description --}}
            <div class="popup-ad-header">
                <div class="popup-ad-title">{{ $popupAd->title }}</div>
                @if($popupAd->subtitle)
                    <div class="popup-ad-subtitle">{{ $popupAd->subtitle }}</div>
                @endif
            </div>

            {{-- Banner Image --}}
            <div class="popup-ad-image-wrapper">
                @if($popupAd->target_url)
                    <a href="{{ $popupAd->target_url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="popup-ad-image-link"
                       title="Buka: {{ $popupAd->title }}">
                        <img src="{{ asset('storage/' . $popupAd->banner_image) }}"
                             alt="{{ $popupAd->title }}"
                             class="popup-ad-image"
                             loading="eager">
                    </a>
                @else
                    <div class="popup-ad-image-link" style="cursor: default;">
                        <img src="{{ asset('storage/' . $popupAd->banner_image) }}"
                             alt="{{ $popupAd->title }}"
                             class="popup-ad-image"
                             loading="eager">
                    </div>
                @endif
            </div>

            {{-- CTA Button (inside card) --}}
            @if($popupAd->target_url)
                <div class="popup-ad-footer">
                    <a href="{{ $popupAd->target_url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="popup-ad-cta">
                        <i class="fas fa-external-link-alt"></i>
                        Klik Link
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Popup Script --}}
<script>
    (function() {
        const popupId = '{{ $popupAd->id }}';
        const POPUP_KEY = 'popup_ad_closed_' + popupId;
        const overlay = document.getElementById('popupAdOverlay');
        const closeBtn = document.getElementById('popupAdClose');

        if (!overlay || !closeBtn) return;

        // Don't show if already dismissed in this session
        if (sessionStorage.getItem(POPUP_KEY)) return;

        // Show popup after configured delay
        setTimeout(function() {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }, {{ $popupAd->show_delay }});

        // Close popup function
        function closePopup() {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
            sessionStorage.setItem(POPUP_KEY, '1');
        }

        // Close button click
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closePopup();
        });

        // (Fungsi 'Klik di luar untuk menutup' telah dihapus 
        // agar pengunjung tidak sengaja menutup popup tanpa mengklik X)

        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closePopup();
            }
        });
    })();
</script>
@endif
