@php
    $company = \App\Support\SiteSettings::group('company');
    $contact = \App\Support\SiteSettings::group('contact');
@endphp

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-about">
            <h2>{{ $company['company.name'] ?? config('app.name') }}</h2>
            <p>{{ $company['company.short_description'] ?? 'تامین صنعتی محصولات آلومینیومی.' }}</p>
            <div class="social-row" aria-label="شبکه‌های اجتماعی">
                <span>in</span>
                <span>wa</span>
                <span>tg</span>
            </div>
        </div>
        <div>
            <h3>دسترسی سریع</h3>
            <a href="{{ route('home') }}">خانه</a>
            <a href="{{ route('services.index') }}">خدمات</a>
            <a href="{{ route('products.index') }}">محصولات</a>
            <a href="{{ route('about') }}">درباره ما</a>
            <a href="{{ route('contact.index') }}">تماس با ما</a>
        </div>
        <div>
            <h3>محصولات</h3>
            <a href="{{ route('products.index') }}">بیلت آلومینیوم</a>
            <a href="{{ route('products.index') }}">شمش A7</a>
            <a href="{{ route('products.index') }}">شمش A8</a>
            <a href="{{ route('products.index') }}">تامین سفارشی</a>
        </div>
        <div>
            <h3>ارتباط با فروش</h3>
            <a href="tel:{{ $contact['contact.sales_phone'] ?? '' }}">{{ $contact['contact.sales_phone'] ?? 'ثبت نشده' }}</a>
            <a href="mailto:{{ $contact['contact.email'] ?? '' }}">{{ $contact['contact.email'] ?? 'ثبت نشده' }}</a>
            <p>{{ $contact['contact.working_hours'] ?? 'ساعات کاری ثبت نشده' }}</p>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© {{ now()->format('Y') }} {{ $company['company.name'] ?? config('app.name') }}. تمامی حقوق محفوظ است.</span>
        <span>{{ $company['company.address'] ?? 'آدرس از طریق پنل مدیریت آینده تکمیل می‌شود.' }}</span>
    </div>
</footer>
