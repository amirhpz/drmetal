<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="inner-hero section">
        <div class="container inner-hero-grid about-visual-hero">
            <div>
                <h1>درباره {{ $settings['company.name'] ?? 'دکتر متال' }}</h1>
                <p>تولیدکننده و تأمین‌کننده صنعتی بیلت و شمش آلومینیوم با تمرکز بر کیفیت پایدار، قابلیت اتکا و همکاری بلندمدت با صنایع داخلی و صادراتی.</p>
                <div class="trust-strip">
                    <span>کیفیت پایدار</span>
                    <span>تولید پیشرفته</span>
                    <span>همکاری صنعتی</span>
                </div>
            </div>
            <div class="factory-visual industrial-visual" aria-hidden="true">
                <div class="ingot-stack"><span></span><span></span><span></span></div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container split-section">
            <div class="factory-visual wide" aria-hidden="true"></div>
            <div>
                <h2>داستان ما</h2>
                <p>{{ $settings['about.story'] ?? 'دکتر متال با نگاه صنعتی و بلندمدت شکل گرفته است؛ تمرکز ما بر تولید محصولات آلومینیومی قابل اتکا، کنترل دقیق کیفیت و پاسخ‌گویی منظم به نیاز کارخانه‌ها و تولیدکنندگان است. ساختار فعلی سایت برای اتصال به پنل مدیریت آینده آماده شده و اطلاعات تکمیلی شرکت در آن مرحله قابل توسعه خواهد بود.' }}</p>
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading title="مسیر رشد" />
            <div class="timeline-grid">
                @foreach ([['۱۳۸۵', 'آغاز فعالیت'], ['۱۳۹۲', 'توسعه خطوط تولید'], ['۱۳۹۷', 'دریافت گواهینامه‌ها'], ['۱۴۰۰', 'توسعه صادرات'], ['۱۴۰۳', 'افزایش ظرفیت تولید']] as $item)
                    <div class="timeline-item">
                        <strong>{{ $item[0] }}</strong>
                        <span>{{ $item[1] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container card-grid mission-grid">
            <article class="card">
                <h2>ماموریت ما</h2>
                <p>{{ $settings['about.mission'] ?? 'تامین محصولات قابل اتکا برای مشتریان صنعتی.' }}</p>
            </article>
            <article class="card">
                <h2>چشم‌انداز ما</h2>
                <p>{{ $settings['about.vision'] ?? 'تبدیل شدن به تامین‌کننده قابل اعتماد منطقه‌ای.' }}</p>
            </article>
            <article class="card">
                <h2>ارزش‌های ما</h2>
                <p>کیفیت، شفافیت، مسئولیت‌پذیری، همکاری بلندمدت و احترام به تعهدات صنعتی.</p>
            </article>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading title="ارزش‌های ما" />
            <div class="value-grid">
                @foreach (['اعتماد مشتری', 'تعهد', 'شفافیت', 'کیفیت پایدار', 'مسئولیت‌پذیری'] as $value)
                    <div class="value-item">{{ $value }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="stats-band container">
        @foreach ([['۲۵+', 'سال تجربه', 'در صنعت آلومینیوم'], ['۱۵۰,۰۰۰', 'تن ظرفیت سالانه', 'تولید بیلت و شمش'], ['۵۰۰+', 'مشتری فعال', 'در داخل و خارج از کشور'], ['۲۰+', 'کشور صادراتی', 'در آسیا، اروپا و خاورمیانه'], ['۹۸٪', 'رضایت مشتری', 'در همکاری‌های صنعتی']] as $stat)
            <div class="stat-item">
                <strong>{{ $stat[0] }}</strong>
                <span>{{ $stat[1] }}</span>
                <small>{{ $stat[2] }}</small>
            </div>
        @endforeach
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading title="گواهینامه‌ها و استانداردها" />
            <div class="certificate-grid">
                @foreach (['ISO 9001', 'ISO 14001', 'ISO 45001', 'CE'] as $cert)
                    <div class="certificate-card">
                        <div class="certificate-paper"></div>
                        <strong>{{ $cert }}</strong>
                        <span>قابل تکمیل در پنل آینده</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container factory-panel">
            <div>
                <h2>نمایی از کارخانه</h2>
                <p>کارخانه دکتر متال مجهز به خطوط تولید پیشرفته، سیستم‌های کنترلی و آزمایشگاه تخصصی کنترل کیفیت است. این بخش برای تصاویر واقعی کارخانه در آینده آماده شده است.</p>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
            </div>
            <div class="factory-visual wide" aria-hidden="true"></div>
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <h2>برای شروع همکاری صنعتی با تیم فروش در ارتباط باشید.</h2>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('products.index') }}">مشاهده محصولات</a>
            </div>
        </div>
    </section>
</x-layouts.app>
