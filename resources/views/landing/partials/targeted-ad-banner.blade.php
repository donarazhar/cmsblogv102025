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
    <div class="container" style="margin-top: 25px; margin-bottom: 5px; position: relative; z-index: 10;" data-aos="fade-up">
        @if($activeBanner->url_link)
            <a href="{{ $activeBanner->url_link }}" target="_blank" rel="noopener noreferrer" style="display: block; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <img src="{{ asset('storage/' . $activeBanner->image) }}" alt="{{ $activeBanner->title }}" style="width: 100%; height: auto; display: block;">
            </a>
        @else
            <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
                <img src="{{ asset('storage/' . $activeBanner->image) }}" alt="{{ $activeBanner->title }}" style="width: 100%; height: auto; display: block;">
            </div>
        @endif
    </div>
@endif
