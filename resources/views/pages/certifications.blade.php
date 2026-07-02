<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / گواهینامه‌ها" label="Certifications & Approvals" title="گواهینامه‌ها و تأییدیه‌ها" />

    <section class="section tight-section">
        <div class="container cert-category-row">
            @foreach (['ISO', 'IMS', 'HSE'] as $category)
                <article>
                    <strong>{{ $category }}</strong>
                    <span>{{ $category === 'ISO' ? 'International Standards' : 'Management System' }}</span>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading title="فهرست گواهینامه‌ها" />
            <div class="certificate-grid detailed">
                @foreach ($company['certifications'] as $certification)
                    <article class="certificate-card detailed">
                        <div class="certificate-paper"></div>
                        <span>{{ $certification['category'] }}</span>
                        <strong>{{ $certification['code'] }}</strong>
                        <p>{{ $certification['title'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
