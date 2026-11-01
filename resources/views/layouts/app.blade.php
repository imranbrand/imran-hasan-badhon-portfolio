<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', config('portfolio.profile.name') . ' | ' . config('portfolio.profile.headline'))</title>
    <meta name="description" content="@yield('description', config('portfolio.profile.lead'))">
    <meta name="theme-color" content="#06080d">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('portfolio.profile.name') }}">
    <meta property="og:title" content="@yield('title', config('portfolio.profile.name') . ' | ' . config('portfolio.profile.headline'))">
    <meta property="og:description" content="@yield('description', config('portfolio.profile.lead'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset(config('portfolio.profile.og_image')) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}?v={{ filemtime(public_path('css/portfolio.css')) }}">
    <script type="application/ld+json">{!! $jsonLd !!}</script>
</head>
<body>
    <canvas id="bg" aria-hidden="true"></canvas>
    <div class="vignette" aria-hidden="true"></div>

    @include('partials.nav')

    <main id="top">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/portfolio.js') }}?v={{ filemtime(public_path('js/portfolio.js')) }}" defer></script>
</body>
</html>
