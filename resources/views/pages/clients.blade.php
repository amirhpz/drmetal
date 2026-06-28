<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="inner-hero section">
        <div class="container inner-hero-grid">
            <div>
                <p class="eyebrow">Top Clients</p>
                <h1>مشتریان برتر</h1>
                <p>همکاری با مشتریان صنعتی معتبر، بخشی از اعتبار و مسیر رشد صنایع متالورژی دکتر متال است.</p>
            </div>
            <div class="factory-visual small-visual industrial-visual" aria-hidden="true">
                <div class="ingot-stack"><span></span><span></span><span></span></div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading eyebrow="Clients" title="شرکای صنعتی و مشتریان" />
            <div class="client-grid large">
                @foreach ($company['clients'] as $client)
                    <article class="client-card">
                        <span class="client-logo-text">{{ mb_substr($client['name'], 0, 1) }}</span>
                        <strong>{{ $client['name'] }}</strong>
                        <span>{{ $client['en'] }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container final-cta">
            <h2>برای همکاری صنعتی با دکتر متال، با ما در ارتباط باشید.</h2>
            <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
        </div>
    </section>
</x-layouts.app>
