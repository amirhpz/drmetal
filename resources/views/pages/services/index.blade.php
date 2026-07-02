<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / زمینه‌های فعالیت" label="Fields of Activity" title="زمینه‌های فعالیت" />

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
