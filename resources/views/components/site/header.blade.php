@php($companyName = \App\Support\SiteSettings::get('company.name', config('company.name_fa', 'صنایع متالورژی دکتر متال')))
@php($logo = \App\Support\SiteSettings::get('company.logo'))

<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ $companyName }}">
            <span class="brand-mark" aria-hidden="true">
                @if ($logo)
                    <img src="{{ asset($logo) }}" alt="">
                @else
                    <svg viewBox="0 0 48 48" role="img">
                        <path d="M24 4 42 14v20L24 44 6 34V14L24 4Z" />
                        <path d="M15 19 24 14l9 5-9 5-9-5Z" />
                        <path d="M15 25v7l9 5 9-5v-7" />
                        <path d="M24 24v13" />
                    </svg>
                @endif
            </span>
            <span>
                <strong>{{ $companyName }}</strong>
                <small>{{ \App\Support\SiteSettings::get('company.tagline', config('company.slogan_fa', 'پرتوی فناوری و دانش')) }}</small>
            </span>
        </a>

        <button class="menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="site-nav" id="site-navigation" data-mobile-menu>
            <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>خانه</a>
            <a href="{{ route('services.index') }}" @class(['is-active' => request()->routeIs('services.*')])>زمینه‌های فعالیت</a>
            <a href="{{ route('products.index') }}" @class(['is-active' => request()->routeIs('products.*')])>محصولات</a>
            <a href="{{ route('clients.index') }}" @class(['is-active' => request()->routeIs('clients.*')])>مشتریان</a>
{{--            <a href="{{ route('certifications.index') }}" @class(['is-active' => request()->routeIs('certifications.*')])>گواهینامه‌ها</a>--}}
            <a href="{{ route('posts.index') }}" @class(['is-active' => request()->routeIs('posts.*')])>مقالات</a>
            <a href="{{ route('about') }}" @class(['is-active' => request()->routeIs('about')])>درباره ما</a>
            <a href="{{ route('contact.index') }}" @class(['is-active' => request()->routeIs('contact.*')])>تماس با ما</a>
        </nav>

        <button class="btn btn-primary header-cta" type="button" data-quote-modal-open>ثبت سفارش</button>
    </div>
</header>
