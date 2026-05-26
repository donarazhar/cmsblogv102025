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
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    .popup-ad-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ===== POPUP CONTAINER ===== */
    .popup-ad-container {
        position: relative;
        max-width: 520px;
        width: 100%;
        background: var(--white, #ffffff);
        border-radius: 20px;
        overflow: hidden;
        box-shadow:
            0 25px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        transform: scale(0.85) translateY(30px);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .popup-ad-overlay.active .popup-ad-container {
        transform: scale(1) translateY(0);
    }

    /* ===== CLOSE BUTTON ===== */
    .popup-ad-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.95rem;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .popup-ad-close:hover {
        background: rgba(220, 38, 38, 0.85);
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
    }

    /* ===== IMAGE LINK ===== */
    .popup-ad-image-link {
        display: block;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .popup-ad-image-link::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            transparent 50%,
            rgba(0, 0, 0, 0.04) 100%
        );
        pointer-events: none;
        transition: all 0.4s ease;
    }

    .popup-ad-image-link:hover::after {
        background: linear-gradient(
            to bottom,
            rgba(0, 83, 197, 0.05) 0%,
            rgba(0, 83, 197, 0.12) 100%
        );
    }

    .popup-ad-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }

    .popup-ad-image-link:hover .popup-ad-image {
        transform: scale(1.03);
    }

    /* ===== BOTTOM BAR ===== */
    .popup-ad-bottom {
        padding: 16px 20px;
        background: linear-gradient(135deg, #004099 0%, #0053c5 50%, #1a6bdc 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .popup-ad-info {
        flex: 1;
        min-width: 0;
    }

    .popup-ad-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.3;
        margin-bottom: 2px;
    }

    .popup-ad-subtitle {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.75);
        font-weight: 400;
    }

    .popup-ad-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .popup-ad-cta:hover {
        background: #ffffff;
        color: #0053c5;
        border-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .popup-ad-cta i {
        font-size: 0.85rem;
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
            rgba(255, 255, 255, 0.15),
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
        .popup-ad-container {
            max-width: 92vw;
            border-radius: 16px;
        }

        .popup-ad-bottom {
            flex-direction: column;
            text-align: center;
            padding: 14px 16px;
            gap: 10px;
        }

        .popup-ad-title {
            font-size: 0.88rem;
        }

        .popup-ad-cta {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
        }

        .popup-ad-close {
            width: 32px;
            height: 32px;
            top: 10px;
            right: 10px;
            font-size: 0.85rem;
        }
    }
</style>

{{-- Popup Ad HTML --}}
<div class="popup-ad-overlay" id="popupAdOverlay">
    <div class="popup-ad-container">
        {{-- Close Button --}}
        <button class="popup-ad-close" id="popupAdClose" type="button" aria-label="Tutup popup">
            <i class="fas fa-times"></i>
        </button>

        {{-- Clickable Banner Image --}}
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

        {{-- Bottom Info Bar --}}
        <div class="popup-ad-bottom">
            <div class="popup-ad-info">
                <div class="popup-ad-title">{{ $popupAd->title }}</div>
                @if($popupAd->subtitle)
                    <div class="popup-ad-subtitle">{{ $popupAd->subtitle }}</div>
                @endif
            </div>
            
            @if($popupAd->target_url)
                <a href="{{ $popupAd->target_url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="popup-ad-cta">
                    @if($popupAd->pdf_file)
                        <i class="fas fa-file-pdf"></i>
                        Buka PDF
                    @else
                        <i class="fas fa-external-link-alt"></i>
                        Buka Link
                    @endif
                </a>
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
