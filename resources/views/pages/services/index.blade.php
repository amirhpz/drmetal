<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="services-hero">
        <div class="container services-hero-grid">
            <div class="services-hero-copy">
                <p class="eyebrow">خدمات صنعتی دکتر متال</p>
                <h1>زنجیره کامل تولید، کنترل کیفیت و تامین آلومینیوم</h1>
                <p>از بررسی نیاز فنی تا آماده‌سازی، بسته‌بندی و هماهنگی تحویل؛ خدمات ما برای خریداران عمده، کارخانه‌ها و خطوط تولیدی طراحی شده که کیفیت پایدار و زمان‌بندی دقیق می‌خواهند.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('contact.index') }}#quote">ثبت درخواست تامین</a>
                    <a class="btn btn-secondary" href="{{ route('products.index') }}">مشاهده محصولات</a>
                </div>
                <div class="services-hero-metrics" aria-label="شاخص‌های خدمات">
                    <div>
                        <strong>۷</strong>
                        <span>مرحله کنترل سفارش</span>
                    </div>
                    <div>
                        <strong>۲۴h</strong>
                        <span>پاسخ اولیه فروش</span>
                    </div>
                    <div>
                        <strong>B2B</strong>
                        <span>تمرکز بر تامین عمده</span>
                    </div>
                </div>
            </div>

            <aside class="services-hero-panel" aria-label="نمای کلی خدمات">
                <div class="services-panel-head">
                    <span>AL SUPPLY SYSTEM</span>
                    <strong>برنامه‌ریزی تامین صنعتی</strong>
                </div>
                <div class="services-production-card">
                    <div class="services-ingot-scene" aria-hidden="true">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <div>
                        <strong>کیفیت قابل ردیابی</strong>
                        <p>هماهنگی تولید، آنالیز، بسته‌بندی و تحویل بر اساس نیاز هر سفارش.</p>
                    </div>
                </div>
                <div class="services-panel-rows">
                    <div><span>ورودی</span><strong>نیاز فنی و مقدار</strong></div>
                    <div><span>کنترل</span><strong>آنالیز و استاندارد</strong></div>
                    <div><span>خروجی</span><strong>تحویل هماهنگ‌شده</strong></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="section services-overview-section">
        <div class="container services-overview">
            <div>
                <p class="eyebrow">دامنه خدمات</p>
                <h2>هر سفارش با مسیر روشن و قابل پیگیری جلو می‌رود.</h2>
            </div>
            <p>ساختار خدمات برای کاهش ریسک خرید صنعتی طراحی شده است: مشخصات فنی روشن، قیمت‌گذاری شفاف، کنترل کیفیت و هماهنگی لجستیک در کنار ارتباط مستقیم با تیم فروش.</p>
        </div>
    </section>

    <section class="section services-cards-section">
        <div class="container">
            <div class="services-feature-grid">
                @forelse ($services as $service)
                    <article class="service-feature-card">
                        <div class="service-feature-top">
                            <div class="service-icon">
                                <x-site.icon :name="$service->icon ?: 'quality'"/>
                            </div>
                            <span>{{ \App\Support\PersianNumber::digits($loop->iteration) }}</span>
                        </div>
                        <h2>{{ $service->title }}</h2>
                        <p>{{ $service->description ?: $service->short_description }}</p>
                        <div class="service-feature-line" aria-hidden="true"></div>
                    </article>
                @empty
                    <p class="empty-state">خدمتی برای نمایش ثبت نشده است.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section services-process-section">
        <div class="container services-process-layout">
            <div class="services-process-copy">
                <p class="eyebrow">فرایند همکاری</p>
                <h2>از درخواست اولیه تا تحویل، هر مرحله قابل پیگیری است.</h2>
                <p>برای سفارش‌های صنعتی، سرعت به تنهایی کافی نیست. مسیر همکاری باید دقیق، مستند و قابل هماهنگی با برنامه تولید مشتری باشد.</p>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">شروع گفتگو با فروش</a>
            </div>
            <div class="services-process-list">
                @foreach ([
                    ['ثبت درخواست', 'مقدار، گرید، مقصد و زمان‌بندی مورد نیاز دریافت می‌شود.'],
                    ['بررسی نیاز', 'امکان تامین، مشخصات فنی و شرایط سفارش بررسی می‌شود.'],
                    ['اعلام قیمت', 'قیمت، شرایط پرداخت، بسته‌بندی و زمان تحویل پیشنهاد می‌شود.'],
                    ['تأیید سفارش', 'پس از تایید نهایی، برنامه تامین یا تولید فعال می‌شود.'],
                    ['کنترل کیفیت', 'آنالیز، ظاهر محصول و بسته‌بندی قبل از ارسال کنترل می‌شود.'],
                    ['ارسال', 'هماهنگی بارگیری و تحویل بر اساس برنامه مشتری انجام می‌شود.'],
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

    <section class="section tight-section services-advantages-section">
        <div class="container services-advantages">
            <div class="services-advantages-head">
                <p class="eyebrow">مزیت خدمات ما</p>
                <h2>مناسب برای تامین‌کنندگان و تولیدکنندگانی که ثبات می‌خواهند.</h2>
            </div>
            <div class="services-advantage-grid">
                @foreach ([
                    ['بسته‌بندی استاندارد', 'کاهش آسیب در حمل و انبارش'],
                    ['سفارشی‌سازی', 'هماهنگی ابعاد، گرید و شرایط سفارش'],
                    ['پشتیبانی تخصصی', 'همراهی فروش و فنی در تصمیم خرید'],
                    ['کیفیت پایدار', 'تمرکز بر تکرارپذیری در تامین'],
                    ['تحویل به‌موقع', 'هماهنگی لجستیک با برنامه تولید'],
                ] as $value)
                    <article>
                        <strong>{{ $value[0] }}</strong>
                        <p>{{ $value[1] }}</p>
                    </article>
                @endforeach
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
        <div class="container services-final-cta">
            <div>
                <p class="eyebrow">آماده بررسی سفارش شما هستیم</p>
                <h2>برای برنامه‌ریزی تأمین پایدار آلومینیوم، با تیم فروش در ارتباط باشید.</h2>
                <p>اطلاعات محصول، مقدار تقریبی و مقصد تحویل را ارسال کنید تا مسیر تامین و قیمت پیشنهادی بررسی شود.</p>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}#quote">درخواست مشاوره</a>
                <a class="btn btn-secondary" href="{{ route('contact.index') }}">تماس با ما</a>
            </div>
        </div>
    </section>
</x-layouts.app>
