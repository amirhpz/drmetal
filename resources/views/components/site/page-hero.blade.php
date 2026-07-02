@props([
    'title',
    'label',
    'path',
])

<section class="page-hero">
    <div class="container page-hero-inner">
        <nav class="page-hero-path" aria-label="مسیر صفحه">{{ $path }}</nav>
        <p>{{ $label }}</p>
        <h1>{{ $title }}</h1>
    </div>
</section>
