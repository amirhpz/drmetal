<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription" page-class="home-page">
    <section class="hero section">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">{{ $settings['company.tagline_en'] ?? $company['slogan_en'] }}</p>
                <h1>{{ $settings['company.name'] ?? $company['name_fa'] }}</h1>
                <p>{{ $settings['company.tagline'] ?? $company['slogan_fa'] }} در صنعت فلزات</p>
                <p>{{ $settings['company.short_description'] ?? $company['hero_description'] }}</p>
                <div class="trust-strip">
                    <span>دانش‌پایه</span>
                    <span>متالورژی صنعتی</span>
                    <span>آلومینیوم و فلزات رنگین</span>
                </div>
            </div>
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

    <section class="section tight-section">
        <div class="container split-section">
            <div>
                <p class="eyebrow">{{ $settings['company.name_en'] ?? $company['name_en'] }}</p>
                <h2>فعال در طراحی، تولید، بهینه‌سازی و تأمین محصولات فلزی</h2>
                <p>{{ $settings['about.story'] ?? $company['intro'] }}</p>
            </div>
            <div>
                <img src="{{asset("images/home-1.png")}}">
            </div>
        </div>
    </section>

    <section class="section activity-section">
        <div class="container">
            <div class="activity-section-head">
                <x-site.section-heading eyebrow="Fields of Activity" title="زمینه‌های فعالیت"
                                        :description="$company['fields_description']"/>
                <a class="btn btn-secondary" href="{{ route('services.index') }}">جزئیات خدمات</a>
            </div>
            <div class="activity-grid">
                @foreach ($company['fields'] as $field)
                    <article class="card activity-card">
                        <div class="activity-card-head">
                            <span class="activity-number">{{ \App\Support\PersianNumber::digits($loop->iteration) }}</span>
                            <small>Dr Metal Field</small>
                        </div>
                        <h3>{{ $field['title'] }}</h3>
                        <p>{{ $field['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container founder-highlight">
            <div>
                <p class="eyebrow">{{ $company['founder']['title'] }}</p>
                <h2>{{ $company['founder']['name'] }}</h2>
                <p>{{ $company['founder']['description'] }}</p>
                <a class="btn btn-secondary" href="{{ route('about') }}">مطالعه بیشتر</a>
            </div>
            <div class="founder-mini-list">
                @foreach (array_slice($company['founder']['achievements'], 0, 4) as $achievement)
                    <span>{{ $achievement }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <div class="section-title-row">
                <x-site.section-heading eyebrow="Top Clients" title="مشتریان برتر"/>
                <div class="swiper-controls" aria-label="کنترل اسلایدر مشتریان">
                    <button class="swiper-button" type="button" data-client-prev aria-label="قبلی">›</button>
                    <button class="swiper-button" type="button" data-client-next aria-label="بعدی">‹</button>
                </div>
            </div>
            <div class="client-swiper" data-client-swiper>
                <div class="client-carousel-track">
                    @foreach ($clients as $client)
                        <div class="client-slide">
                            <article class="client-card client-carousel-card">
                                @if ($client->logo)
                                    <img class="client-carousel-image" src="{{ asset($client->logo) }}"
                                         alt="{{ $client->name }}" loading="lazy">
                                @else
                                    <span
                                        class="client-carousel-image client-carousel-placeholder">{{ mb_substr($client->name, 0, 1) }}</span>
                                @endif
                                <strong>{{ $client->name }}</strong>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="client-pagination" data-client-pagination aria-label="صفحه‌بندی مشتریان"></div>
            <div class="center-action">
                <a class="btn btn-secondary" href="{{ route('clients.index') }}">مشاهده مشتریان</a>
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container certifications-strip">
            <div>
                <p class="eyebrow">Certifications & Approvals</p>
                <h2>گواهینامه‌ها و تأییدیه‌ها</h2>
                <p>استانداردهای ISO، IMS و HSE به عنوان بخشی از اعتبار صنعتی مجموعه معرفی شده‌اند و قابل اصلاح در ساختار
                    محتوایی سایت هستند.</p>
            </div>
            <div class="cert-pill-row">
                @foreach (['ISO', 'IMS', 'HSE'] as $cert)
                    <span>{{ $cert }}</span>
                @endforeach
            </div>
            <a class="btn btn-primary" href="{{ route('certifications.index') }}">مشاهده گواهینامه‌ها</a>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading eyebrow="محصولات" title="محصولات اصلی"
                                    description="محصولات و قطعات فلزی مرتبط با آلومینیوم و فلزات رنگین."/>
            <div class="product-strip">
                @if ($featuredProducts->count() >= 4)
                    @foreach ($featuredProducts->take(4) as $product)
                        <x-site.product-card :product="$product"/>
                    @endforeach
                @else
                    @foreach ([
                        ['title' => 'شمش آلیاژی آلومینیوم', 'spec' => 'رده‌های خشک و نرم'],
                        ['title' => 'قطعات آلومینیومی دایکاست', 'spec' => 'طراحی و تولید صنعتی'],
                        ['title' => 'ورق آلومینیومی', 'spec' => 'بر اساس نیاز فنی'],
                        ['title' => 'فلزات رنگین', 'spec' => 'آلومینیوم و مس'],
                    ] as $fallback)
                        <article class="card product-card">
                            <div class="visual-placeholder" aria-hidden="true"><span>{{ $fallback['spec'] }}</span>
                            </div>
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

    <section class="section">
        <div class="container final-cta">
            <h2>برای شروع همکاری با صنایع متالورژی دکتر متال در ارتباط باشید.</h2>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
            </div>
        </div>
    </section>
</x-layouts.app>
