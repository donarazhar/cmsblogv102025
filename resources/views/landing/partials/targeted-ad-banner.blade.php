@php
    $targetedBanners = \App\Models\AdBanner::active()
        ->whereNotNull('target_routes')
        ->where('target_routes', '!=', '')
        ->ordered()
        ->get();

    $activeBanners = $targetedBanners->filter(function ($banner) {
        return $banner->matchesCurrentRoute();
    })->values(); // Reset keys after filtering so index matches 0,1,2...
@endphp

@if($activeBanners->count() > 0)
    <div class="container" style="margin-top: 30px; margin-bottom: 10px; position: relative; z-index: 10;" data-aos="fade-up">
        <div style="max-width: 850px; margin: 0 auto; padding: 0 15px;">
            <div class="targeted-ad-banner-carousel" id="targetedAdBannerCarousel" style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
                @foreach($activeBanners as $index => $banner)
                    <a href="{{ $banner->url_link ?? '#' }}" {!! $banner->url_link ? 'target="_blank"' : 'style="pointer-events: none;"' !!} class="targeted-ad-banner-link" data-index="{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }}; transition: transform 0.3s ease; animation: targetedFadeIn 0.5s ease-in-out;">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="width: 100%; height: auto; display: block;">
                    </a>
                @endforeach

                @if($activeBanners->count() > 1)
                    <!-- Navigation Controls -->
                    <button class="targeted-ad-nav-btn targeted-ad-prev" aria-label="Previous Banner">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="targeted-ad-nav-btn targeted-ad-next" aria-label="Next Banner">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Progress Bar -->
                    <div class="targeted-ad-progress-bar">
                        <div class="targeted-ad-progress-fill"></div>
                    </div>
                @endif
            </div>
            
            @if($activeBanners->count() > 1)
            <style>
                .targeted-ad-banner-carousel:hover .targeted-ad-banner-link {
                    transform: translateY(-2px);
                }
                .targeted-ad-nav-btn {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    background: rgba(255, 255, 255, 0.8);
                    color: var(--primary);
                    border: none;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    font-size: 1.1rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    z-index: 10;
                }
                .targeted-ad-banner-carousel:hover .targeted-ad-nav-btn {
                    opacity: 1;
                    visibility: visible;
                }
                .targeted-ad-nav-btn:hover {
                    background: var(--primary);
                    color: white;
                }
                .targeted-ad-prev { left: 12px; }
                .targeted-ad-next { right: 12px; }
                
                .targeted-ad-progress-bar {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 4px;
                    background: rgba(255, 255, 255, 0.3);
                    z-index: 10;
                }
                .targeted-ad-progress-fill {
                    height: 100%;
                    width: 0%;
                    background: var(--primary);
                    transition: none;
                }

                @keyframes targetedFadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const targetedBanners = document.querySelectorAll('#targetedAdBannerCarousel .targeted-ad-banner-link');
                    const targetedProgressFill = document.querySelector('#targetedAdBannerCarousel .targeted-ad-progress-fill');
                    const targetedBtnPrev = document.querySelector('#targetedAdBannerCarousel .targeted-ad-prev');
                    const targetedBtnNext = document.querySelector('#targetedAdBannerCarousel .targeted-ad-next');
                    
                    if (!targetedBanners.length || !targetedBtnPrev || !targetedBtnNext) return;

                    let targetedCurrentIndex = 0;
                    const targetedTotalBanners = targetedBanners.length;
                    const targetedSlideDuration = 15000; // 15 seconds
                    let targetedSlideTimer;

                    function targetedResetProgress() {
                        targetedProgressFill.style.transition = 'none';
                        targetedProgressFill.style.width = '0%';
                        // Force reflow
                        void targetedProgressFill.offsetWidth;
                        targetedProgressFill.style.transition = `width ${targetedSlideDuration}ms linear`;
                        targetedProgressFill.style.width = '100%';
                    }

                    function targetedShowBanner(index) {
                        targetedBanners.forEach(b => b.style.display = 'none');
                        targetedBanners[index].style.display = 'block';
                        targetedResetProgress();
                    }

                    function targetedNextBanner() {
                        targetedCurrentIndex = (targetedCurrentIndex + 1) % targetedTotalBanners;
                        targetedShowBanner(targetedCurrentIndex);
                        targetedStartTimer();
                    }

                    function targetedPrevBanner() {
                        targetedCurrentIndex = (targetedCurrentIndex - 1 + targetedTotalBanners) % targetedTotalBanners;
                        targetedShowBanner(targetedCurrentIndex);
                        targetedStartTimer();
                    }

                    function targetedStartTimer() {
                        clearInterval(targetedSlideTimer);
                        targetedSlideTimer = setInterval(targetedNextBanner, targetedSlideDuration);
                        targetedResetProgress();
                    }

                    targetedBtnNext.addEventListener('click', (e) => {
                        e.preventDefault();
                        targetedNextBanner();
                    });

                    targetedBtnPrev.addEventListener('click', (e) => {
                        e.preventDefault();
                        targetedPrevBanner();
                    });

                    // Start carousel
                    targetedStartTimer();
                });
            </script>
            @endif
        </div>
    </div>
@endif
