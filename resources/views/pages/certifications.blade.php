<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="inner-hero section">
        <div class="container inner-hero-grid">
            <div>
                <p class="eyebrow">Certifications & Approvals</p>
                <h1>گواهینامه‌ها و تأییدیه‌ها</h1>
                <p>گواهینامه‌های ISO، IMS و HSE برای نمایش روشن و قابل اصلاح در ساختار محتوایی سایت آماده شده‌اند.</p>
            </div>
            <div class="hero-visual small-visual industrial-visual" aria-hidden="true">
                <div class="ingot-stack"><span></span><span></span><span></span></div>
            </div>
        </div>
    </section>

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
            <p class="content-note">برخی شماره‌های گواهینامه از تصویر کم‌کیفیت استخراج شده‌اند و در ساختار محتوایی سایت قابل اصلاح نگه داشته شده‌اند.</p>
        </div>
    </section>
</x-layouts.app>
