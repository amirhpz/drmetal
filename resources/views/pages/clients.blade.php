<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / مشتریان" label="Top Clients" title="مشتریان برتر" />

    <section class="section">
        <div class="container">
            <div class="section-title-row">
                <x-site.section-heading eyebrow="Clients" title="شرکای صنعتی و مشتریان" />
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
                                    <img class="client-carousel-image" src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy">
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
        </div>
    </section>

    <section class="section tight-section">
        <div class="container final-cta">
            <h2>برای همکاری صنعتی با دکتر متال، با ما در ارتباط باشید.</h2>
            <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
        </div>
    </section>
</x-layouts.app>
