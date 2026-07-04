@props(['pageClass' => null, 'quoteProduct' => null])

@php($favicon = \App\Support\SiteSettings::get('company.favicon'))

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
    @if ($favicon)
        <link rel="icon" href="{{ asset($favicon) }}">
        <link rel="shortcut icon" href="{{ asset($favicon) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body @class([$pageClass])>
    <div class="page-shell">
        <x-site.header />

        @if (session('success'))
            <div class="flash container" role="status">{{ session('success') }}</div>
        @endif

        <main>
            {{ $slot }}
        </main>

        <x-site.footer />
        <button class="mobile-quote-fab" type="button" data-quote-modal-open>ثبت سفارش</button>
        <x-site.quote-modal :products="$quoteProducts ?? collect()" :selected-product="$quoteProduct" />
    </div>
</body>
</html>
