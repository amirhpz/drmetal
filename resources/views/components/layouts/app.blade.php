<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? \App\Support\SiteSettings::get('seo.default_title', config('app.name')) }}</title>
    <meta name="description" content="{{ $metaDescription ?? \App\Support\SiteSettings::get('seo.default_description', '') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? \App\Support\SiteSettings::get('seo.default_title', config('app.name')) }}">
    <meta property="og:description" content="{{ $metaDescription ?? \App\Support\SiteSettings::get('seo.default_description', '') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page-shell">
        <x-site.header />

        @if (session('success'))
            <div class="flash container" role="status">{{ session('success') }}</div>
        @endif

        <main>
            {{ $slot }}
        </main>

        <x-site.footer />
    </div>
</body>
</html>
