<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="hero section">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">تأمین صنعتی آلومینیوم</p>
                <h1>تولیدکننده تخصصی بیلت و شمش آلومینیوم</h1>
                <p>تأمین پایدار محصولات آلومینیومی با کیفیت صنعتی، کنترل دقیق و تحویل قابل اعتماد برای صنایع داخلی و
                    صادراتی.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('products.index') }}">مشاهده محصولات</a>
                    <a class="btn btn-secondary" href="{{ route('contact.index') }}">دریافت مشاوره</a>
                </div>
                <div class="trust-strip">
                    <span>کنترل کیفی مستمر</span>
                    <span>تولید پایدار</span>
                    <span>مناسب همکاری B2B</span>
                </div>
            </div>
            <figure class="hero-image-card" aria-label="نمای محصولات آلومینیومی دکتر متال">
                <img src="{{ asset('images/hero.png') }}" alt="محصولات آلومینیومی دکتر متال">
            </figure>
        </div>
    </section>

    <section class="section price-section">
        <div class="container">
            <div class="section-title-row">
                <x-site.section-heading eyebrow="بازار فلزات" title="قیمت لحظه‌ای فلزات"
                                        description="نمایی سریع از آخرین داده‌های موجود برای تصمیم‌گیری خرید و برنامه‌ریزی تامین."/>
                <div class="price-section-actions">
                    <span>آخرین بروزرسانی: امروز</span>
                    <div class="swiper-controls" aria-label="کنترل اسلایدر قیمت فلزات">
                        <button class="swiper-button" type="button" data-price-prev aria-label="قبلی">›</button>
                        <button class="swiper-button" type="button" data-price-next aria-label="بعدی">‹</button>
                    </div>
                </div>
            </div>
            @forelse ($metalPrices as $price)
                @if ($loop->first)
                    <div class="price-swiper swiper" data-price-swiper>
                        <div class="price-grid swiper-wrapper">
                            @endif
                            <div class="swiper-slide">
                                <x-site.metal-price-card :price="$price"/>
                            </div>
                            @if ($loop->last)
                        </div>
                    </div>
                    <div class="price-pagination" data-price-pagination aria-label="صفحه‌بندی قیمت فلزات"></div>
                @endif
            @empty
                <p class="empty-state">داده‌ای برای قیمت فلزات ثبت نشده است.</p>
            @endforelse
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading eyebrow="خدمات" title="خدمات تخصصی زنجیره تأمین"
                                    description="از تولید و کنترل کیفیت تا آماده‌سازی، بسته‌بندی و هماهنگی ارسال."/>
            <div class="card-grid service-grid-large">
                @foreach ($featuredServices as $service)
                    <x-site.service-card :service="$service"/>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading eyebrow="محصولات" title="محصولات اصلی"
                                    description="محصولات پرکاربرد برای اکستروژن، ریخته‌گری و تامین مواد اولیه صنعتی."/>
            <div class="product-strip">
                @if ($featuredProducts->count() >= 4)
                    @foreach ($featuredProducts->take(4) as $product)
                        <x-site.product-card :product="$product"/>
                    @endforeach
                @else
                    @foreach ([
                        ['title' => 'بیلت آلومینیوم 6063', 'spec' => 'اکستروژن پروفیل'],
                        ['title' => 'بیلت آلومینیوم 6061', 'spec' => 'آلیاژ صنعتی'],
                        ['title' => 'شمش آلومینیوم A7', 'spec' => 'خلوص 99.7٪'],
                        ['title' => 'شمش آلومینیوم A8', 'spec' => 'مصرف ریخته‌گری'],
                    ] as $fallback)
                        <article class="card product-card">
                            <div class="visual-placeholder" aria-hidden="true"><span>{{ $fallback['spec'] }}</span></div>
                            <div class="card-body">
                                <p class="eyebrow">محصول صنعتی</p>
                                <h3>{{ $fallback['title'] }}</h3>
                                <p>{{ $fallback['spec'] }}</p>
                                <div class="card-actions">
                                    <a class="btn btn-secondary" href="{{ route('products.index') }}">جزئیات بیشتر</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="stats-band container">
        @foreach ([['۲۵+', 'سال تجربه', 'در صنعت آلومینیوم'], ['۱۵۰,۰۰۰', 'تن ظرفیت سالانه', 'تولید بیلت و شمش'], ['۵۰۰+', 'مشتری فعال', 'در داخل و خارج از کشور'], ['۲۰+', 'کشور صادراتی', 'در آسیا، اروپا و خاورمیانه']] as $stat)
            <div class="stat-item">
                <strong>{{ $stat[0] }}</strong>
                <span>{{ $stat[1] }}</span>
                <small>{{ $stat[2] }}</small>
            </div>
        @endforeach
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading eyebrow="مزیت همکاری" title="چرا دکتر متال؟"/>
            <div class="value-grid">
                @foreach (['کیفیت پایدار', 'تحویل به‌موقع', 'قیمت رقابتی', 'کنترل دقیق', 'پشتیبانی تخصصی'] as $value)
                    <div class="value-item">{{ $value }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <h2>برای استعلام قیمت و دریافت مشاوره آماده‌ایم</h2>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('contact.index') }}#quote">درخواست مشاوره</a>
            </div>
        </div>
    </section>
</x-layouts.app>
