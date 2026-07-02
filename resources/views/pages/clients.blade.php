<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / مشتریان" label="Top Clients" title="مشتریان برتر" />

    <section class="section">
        <div class="container">
            <x-site.section-heading eyebrow="Clients" title="شرکای صنعتی و مشتریان" />
            <div class="client-grid large">
                @foreach ($clients as $client)
                    <article class="client-card">
                        @if ($client->logo)
                            <img class="client-logo-image" src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy">
                        @else
                            <span class="client-logo-text">{{ mb_substr($client->name, 0, 1) }}</span>
                        @endif
                        <strong>{{ $client->name }}</strong>
                        @if ($client->english_name)
                            <span>{{ $client->english_name }}</span>
                        @endif
                        @if ($client->industry)
                            <small>{{ $client->industry }}</small>
                        @endif
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
