<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @php($seo = $page['props']['seo'] ?? [])
        @php($siteName = \App\Models\SiteSetting::get('short_name'))
        @php($pageTitle = empty($seo['title']) ? $siteName : $seo['title'] . ' | ' . $siteName)

        <title>{{ $pageTitle }}</title>
        @if (!empty($seo['description']))
            <meta name="description" content="{{ $seo['description'] }}">
        @endif
        @if (!empty($seo['canonical']))
            <link rel="canonical" href="{{ $seo['canonical'] }}">
        @endif
        <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow, max-image-preview:large' }}">

        {{-- Open Graph --}}
        <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        @if (!empty($seo['description']))
            <meta property="og:description" content="{{ $seo['description'] }}">
        @endif
        <meta property="og:url" content="{{ $seo['url'] ?? $seo['canonical'] ?? url()->current() }}">
        <meta property="og:site_name" content="{{ $seo['site_name'] ?? $siteName }}">
        @if (!empty($seo['image']))
            <meta property="og:image" content="{{ $seo['image'] }}">
        @endif

        {{-- X / Twitter card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        @if (!empty($seo['description']))
            <meta name="twitter:description" content="{{ $seo['description'] }}">
        @endif
        @if (!empty($seo['image']))
            <meta name="twitter:image" content="{{ $seo['image'] }}">
        @endif

        @if ($gscVerification = config('nymak.analytics.gsc_verification'))
            <meta name="google-site-verification" content="{{ $gscVerification }}">
        @endif

        <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        {{-- Site-wide schema.org: Organization + WebSite, always present in HTML --}}
        <script type="application/ld+json">{!! \App\Support\Seo::globalSchemaJson() !!}</script>

        {{-- Per-page schema nodes (Product, Article, FAQPage, BreadcrumbList...) --}}
        @foreach (($seo['schema'] ?? []) as $node)
            <script type="application/ld+json">{!! json_encode(array_merge(['@context' => 'https://schema.org'], $node)) !!}</script>
        @endforeach

        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
        @inertiaHead
    </head>
    <body class="font-sans text-slate-800 antialiased bg-white">
        @if ($gaId = config('nymak.analytics.ga4_id'))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $gaId }}');
                window.nymakTrack = function (event, params) { gtag('event', event, params || {}); };
            </script>
        @else
            <script>window.nymakTrack = function () {};</script>
        @endif
        @inertia
    </body>
</html>
