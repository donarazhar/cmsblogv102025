@php
    use App\Helpers\SeoHelper;
    $seo = SeoHelper::generateMetaTags([
        'title' => $title ?? setting('site_name'),
        'description' => $description ?? setting('seo_description'),
        'keywords' => $keywords ?? setting('seo_keywords'),
        'image' => $image ?? (setting('site_logo') ? asset('storage/' . setting('site_logo')) : null),
        'url' => $url ?? URL::current(),
        'type' => $type ?? 'website',
    ]);
@endphp

{{-- Basic Meta Tags --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SEO Meta Tags --}}
<title>{{ $seo['title'] }} - {{ setting('site_name') }}</title>
<meta name="title" content="{{ $seo['title'] }}">
<meta name="description" content="{{ $seo['description'] }}">
@if ($seo['keywords'])
    <meta name="keywords" content="{{ $seo['keywords'] }}">
@endif
<meta name="author" content="{{ setting('site_name') }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<link rel="canonical" href="{{ $seo['url'] }}">

{{-- Google Search Console Verification --}}
@if (setting('google_site_verification'))
    <meta name="google-site-verification" content="{{ setting('google_site_verification') }}">
@endif

{{-- Open Graph Meta Tags (Facebook) --}}
<meta property="og:type" content="{{ $seo['type'] }}">
<meta property="og:site_name" content="{{ $seo['site_name'] }}">
<meta property="og:title" content="{{ $seo['title'] }}">
<meta property="og:description" content="{{ $seo['description'] }}">
<meta property="og:url" content="{{ $seo['url'] }}">
<meta property="og:locale" content="{{ $seo['locale'] }}">
@if ($seo['image'])
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:secure_url" content="{{ $seo['image'] }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $seo['title'] }}">
@endif

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['title'] }}">
<meta name="twitter:description" content="{{ $seo['description'] }}">
@if ($seo['image'])
    <meta name="twitter:image" content="{{ $seo['image'] }}">
@endif
@if (setting('social_twitter'))
    <meta name="twitter:site" content="{{ setting('social_twitter') }}">
    <meta name="twitter:creator" content="{{ setting('social_twitter') }}">
@endif

{{-- Favicon --}}
@if (setting('site_favicon'))
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . setting('site_favicon')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . setting('site_favicon')) }}">
@else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
@endif

{{-- 1. Organization Structured Data --}}
<script type="application/ld+json">
{!! SeoHelper::generateStructuredData() !!}
</script>

{{-- 2. WebSite Schema with SearchAction (KEY for Google Sitelinks) --}}
<script type="application/ld+json">
{!! SeoHelper::generateWebSiteSchema() !!}
</script>

{{-- 3. SiteNavigationElement Schema (tells Google your nav structure) --}}
<script type="application/ld+json">
{!! SeoHelper::generateSiteNavigationSchema() !!}
</script>

{{-- 4. Mosque / PlaceOfWorship Schema (local SEO for mosque searches) --}}
<script type="application/ld+json">
{!! SeoHelper::generatePlaceOfWorshipSchema() !!}
</script>

{{-- 5. Breadcrumb Structured Data (if provided) --}}
@if (isset($breadcrumb) && !empty($breadcrumb))
    <script type="application/ld+json">
{!! SeoHelper::generateBreadcrumb($breadcrumb) !!}
</script>
@endif

{{-- DNS Prefetch & Preconnect --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- Additional Meta --}}
<meta name="theme-color" content="#0053C5">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ setting('site_name') }}">
