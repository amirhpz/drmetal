<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / درباره ما" label="About Dr Metal" :title="'درباره '.$company['name_fa']" />

    <section class="section">
        <div class="container split-section">
            <img src="{{asset('/images/home-1.png')}}">
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

    <section class="section activity-section">
        <div class="container">
            <div class="activity-section-head">
                <x-site.section-heading eyebrow="Fields of Activity" title="زمینه‌های فعالیت"
                                        :description="$company['fields_description'] ?? null" />
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
        <div class="container">
            <div class="section-title-row">
                <x-site.section-heading eyebrow="Top Clients" title="بخشی از مشتریان برتر" />
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
                                    <span class="client-carousel-image client-carousel-placeholder">{{ mb_substr($client->name, 0, 1) }}</span>
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
