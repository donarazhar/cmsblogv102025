@php
    $targetedBanners = \App\Models\AdBanner::active()
        ->whereNotNull('target_routes')
        ->where('target_routes', '!=', '')
        ->ordered()
        ->get();

    $activeBanner = $targetedBanners->first(function ($banner) {
        return $banner->matchesCurrentRoute();
    });
@endphp

@if($activeBanner)
    <div class="container" style="margin-top: 30px; margin-bottom: 10px; position: relative; z-index: 10;" data-aos="fade-up">
        <div style="max-width: 850px; margin: 0 auto; padding: 0 15px;">
            @if($activeBanner->url_link)
                <a href="{{ $activeBanner->url_link }}" target="_blank" rel="noopener noreferrer" style="display: block; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.12); transition: transform 0.3s ease;">
                    <img src="{{ asset('storage/' . $activeBanner->image) }}" alt="{{ $activeBanner->title }}" style="width: 100%; height: auto; display: block;">
                </a>
            @else
                <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
                    <img src="{{ asset('storage/' . $activeBanner->image) }}" alt="{{ $activeBanner->title }}" style="width: 100%; height: auto; display: block;">
                </div>
            @endif
        </div>
    </div>
@endif
