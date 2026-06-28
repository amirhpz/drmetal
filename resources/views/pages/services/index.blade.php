<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="services-hero">
        <div class="container services-hero-grid">
            <div class="services-hero-copy">
                <p class="eyebrow">Fields of Activity</p>
                <h1>زمینه‌های فعالیت</h1>
                <p>{{ $company['fields_description'] }}</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                    <a class="btn btn-secondary" href="{{ route('products.index') }}">مشاهده محصولات</a>
                </div>
                <div class="services-hero-metrics" aria-label="شاخص‌های فعالیت">
                    <div>
                        <strong>۴</strong>
                        <span>زمینه اصلی فعالیت</span>
                    </div>
                    <div>
                        <strong>۱۰</strong>
                        <span>سال تجربه صنعتی</span>
                    </div>
                    <div>
                        <strong>R&D</strong>
                        <span>رویکرد دانش‌پایه</span>
                    </div>
                </div>
            </div>

            <aside class="services-hero-panel" aria-label="نمای متالورژی">
                <div class="services-panel-head">
                    <span>METALLURGY SYSTEM</span>
                    <strong>{{ $company['slogan_en'] }}</strong>
                </div>
                <div class="services-production-card">
                    <div class="services-ingot-scene" aria-hidden="true">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <div>
                        <strong>طراحی تا تأمین</strong>
                        <p>مسیر فعالیت دکتر متال از دانش فنی تا تولید و تأمین صنعتی را پوشش می‌دهد.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="section services-cards-section">
        <div class="container">
            <div class="services-feature-grid">
                @foreach ($company['fields'] as $field)
                    <article class="service-feature-card">
                        <div class="service-feature-top">
                            <div class="service-icon">
                                <x-site.icon name="quality"/>
                            </div>
                            <span>{{ \App\Support\PersianNumber::digits($loop->iteration) }}</span>
                        </div>
                        <h2>{{ $field['title'] }}</h2>
                        <p>{{ $field['description'] }}</p>
                        <div class="service-feature-line" aria-hidden="true"></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section services-process-section">
        <div class="container services-process-layout">
            <div class="services-process-copy">
                <p class="eyebrow">فرایند همکاری</p>
                <h2>از بررسی نیاز فنی تا ارائه راهکار صنعتی</h2>
                <p>هر پروژه با شناخت نیاز، بررسی فنی، پیشنهاد راهکار و هماهنگی تولید یا تأمین پیش می‌رود.</p>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">شروع گفتگو</a>
            </div>
            <div class="services-process-list">
                @foreach ([
                    ['دریافت نیاز', 'محصول، قطعه، آلیاژ، مقدار و کاربرد مورد نظر بررسی می‌شود.'],
                    ['بررسی فنی', 'امکان طراحی، تولید، بهینه‌سازی یا تأمین بر اساس داده‌های فنی سنجیده می‌شود.'],
                    ['پیشنهاد راهکار', 'مسیر تولید، تأمین، کنترل کیفیت و زمان‌بندی همکاری پیشنهاد می‌شود.'],
                    ['اجرای همکاری', 'پس از تایید، تولید یا تأمین مطابق توافق و نیاز صنعتی پیگیری می‌شود.'],
                ] as $step)
                    <article>
                        <span>{{ \App\Support\PersianNumber::digits($loop->iteration) }}</span>
                        <div>
                            <strong>{{ $step[0] }}</strong>
                            <p>{{ $step[1] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container services-final-cta">
            <div>
                <p class="eyebrow">پرتوی فناوری و دانش</p>
                <h2>برای بررسی نیاز صنعتی خود با دکتر متال در ارتباط باشید.</h2>
                <p>اطلاعات محصول، قطعه، آلیاژ یا فلز مورد نیاز را ارسال کنید تا مسیر همکاری بررسی شود.</p>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('clients.index') }}">مشتریان</a>
            </div>
        </div>
    </section>
</x-layouts.app>
