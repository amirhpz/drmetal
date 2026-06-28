<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="inner-hero section">
        <div class="container inner-hero-grid about-visual-hero">
            <div>
                <p class="eyebrow">{{ $company['name_en'] }}</p>
                <h1>درباره {{ $company['name_fa'] }}</h1>
                <p>{{ $company['slogan_fa'] }}؛ رویکردی دانش‌پایه در طراحی، تولید، بهینه‌سازی و تأمین محصولات فلزی.</p>
                <div class="trust-strip">
                    <span>نزدیک به یک دهه نام نیک</span>
                    <span>تخصص متالورژی</span>
                    <span>فلزات رنگین</span>
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
                <h2>معرفی شرکت</h2>
                <p>{{ $settings['about.story'] ?? $company['intro'] }}</p>
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container card-grid mission-grid">
            <article class="card">
                <h2>ماموریت ما</h2>
                <p>{{ $settings['about.mission'] ?? 'توسعه راهکارهای دانش‌پایه در صنعت فلزات.' }}</p>
            </article>
            <article class="card">
                <h2>چشم‌انداز ما</h2>
                <p>{{ $settings['about.vision'] ?? 'تبدیل شدن به مرجع قابل اعتماد در صنعت فلزات رنگین.' }}</p>
            </article>
            <article class="card">
                <h2>ارزش‌های ما</h2>
                <p>دانش، فناوری، مسئولیت‌پذیری، کیفیت صنعتی، شفافیت و همکاری بلندمدت.</p>
            </article>
        </div>
    </section>

    <section class="section founder-section">
        <div class="container founder-layout">
            <div class="founder-card">
                <p class="eyebrow">{{ $company['founder']['title'] }}</p>
                <h2>{{ $company['founder']['name'] }}</h2>
                <p>{{ $company['founder']['description'] }}</p>
            </div>
            <div class="achievement-grid">
                @foreach ($company['founder']['achievements'] as $achievement)
                    <article>{{ $achievement }}</article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading eyebrow="Fields of Activity" title="زمینه‌های فعالیت" />
            <div class="card-grid">
                @foreach ($company['fields'] as $field)
                    <article class="card activity-card">
                        <h3>{{ $field['title'] }}</h3>
                        <p>{{ $field['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading eyebrow="Top Clients" title="بخشی از مشتریان برتر" />
            <div class="client-grid">
                @foreach ($company['clients'] as $client)
                    <article class="client-card">
                        <strong>{{ $client['name'] }}</strong>
                        <span>{{ $client['en'] }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <h2>برای آشنایی بیشتر با توانمندی‌های دکتر متال با ما در ارتباط باشید.</h2>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('certifications.index') }}">گواهینامه‌ها</a>
            </div>
        </div>
    </section>
</x-layouts.app>
