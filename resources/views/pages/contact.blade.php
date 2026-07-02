<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / تماس با ما" label="Contact Dr Metal" title="ارتباط با ما" />

    <section class="section tight-section">
        <div class="container contact-cards">
            <article class="contact-info-card">
                <x-site.icon name="location"/>
                <strong>آدرس</strong><span>{{ $contactSettings['company.address'] ?? 'آدرس از طریق پنل مدیریت آینده تکمیل می‌شود.' }}</span>
            </article>
            <article class="contact-info-card">
                <x-site.icon name="phone"/>
                <strong>تلفن</strong><span>{{ $contactSettings['contact.main_phone'] ?? 'ثبت نشده' }}</span></article>
            <article class="contact-info-card">
                <x-site.icon name="phone"/>
                <strong>موبایل فروش</strong><span>{{ $contactSettings['contact.sales_phone'] ?? 'ثبت نشده' }}</span>
            </article>
            <article class="contact-info-card">
                <x-site.icon name="mail"/>
                <strong>وب‌سایت</strong><span>{{ $company['website'] }}</span></article>
            <article class="contact-info-card">
                <x-site.icon name="clock"/>
                <strong>ساعات کاری</strong><span>{{ $contactSettings['contact.working_hours'] ?? 'ثبت نشده' }}</span>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container contact-grid">
            <aside class="contact-panel">
                <h2>اطلاعات تماس</h2>
                <div class="contact-line">
                    <x-site.icon name="location"/>
                    <p>{{ $contactSettings['company.address'] ?? 'آدرس از طریق پنل مدیریت آینده تکمیل می‌شود.' }}</p>
                </div>
                <div class="contact-line">
                    <x-site.icon name="phone"/>
                    <a href="tel:{{ $contactSettings['contact.main_phone'] ?? '' }}">{{ $contactSettings['contact.main_phone'] ?? 'ثبت نشده' }}</a>
                </div>
                <div class="contact-line">
                    <x-site.icon name="phone"/>
                    <a href="tel:{{ $contactSettings['contact.sales_phone'] ?? '' }}">واحد
                        فروش: {{ $contactSettings['contact.sales_phone'] ?? 'ثبت نشده' }}</a></div>
                <div class="contact-line">
                    <x-site.icon name="mail"/>
                    <a href="https://{{ $company['website'] }}" target="_blank" rel="noopener">{{ $company['website'] }}</a>
                </div>
                <div class="contact-line">
                    <x-site.icon name="clock"/>
                    <p>{{ $contactSettings['contact.working_hours'] ?? 'ثبت نشده' }}</p></div>
            </aside>

            <form class="form-card" method="post" action="{{ route('contact.store') }}">
                @csrf
                <h2>فرم تماس</h2>
                <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="honeypot">
                <label>نام و نام خانوادگی
                    <input name="full_name" value="{{ old('full_name') }}" required
                           placeholder="نام و نام خانوادگی خود را وارد کنید">
                    <x-site.form-error name="full_name"/>
                </label>
                <label>شماره تماس
                    <input name="phone" value="{{ old('phone') }}" required
                           placeholder="شماره تماس خود را وارد کنید">
                    <x-site.form-error name="phone"/>
                </label>
                <label>ایمیل
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="ایمیل خود را وارد کنید">
                    <x-site.form-error name="email"/>
                </label>
                <label>نام شرکت
                    <input name="company_name" value="{{ old('company_name') }}"
                           placeholder="نام شرکت را وارد کنید">
                </label>
                <label>موضوع
                    <select name="subject">
                        <option value="">موضوع مورد نظر را انتخاب کنید</option>
                        @foreach (['مشاوره خرید', 'پیگیری سفارش', 'همکاری صنعتی', 'سایر موارد'] as $subject)
                            <option
                                value="{{ $subject }}" @selected(old('subject') === $subject)>{{ $subject }}</option>
                        @endforeach
                    </select>
                    <x-site.form-error name="subject"/>
                </label>
                <label>پیام
                    <textarea name="message" rows="5" required
                              placeholder="پیام خود را بنویسید">{{ old('message') }}</textarea>
                    <x-site.form-error name="message"/>
                </label>
                <button class="btn btn-primary" type="submit">ارسال پیام</button>
            </form>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading title="ارتباط با واحدها"/>
            <div class="card-grid compact-grid">
                @foreach ([['واحد فروش', 'بررسی همکاری، استعلام و برنامه تامین'], ['پشتیبانی فنی', 'مشاوره آلیاژ، قطعه، کاربرد و مشخصات محصول'], ['امور صنعتی', 'هماهنگی نیازهای تولید، طراحی و تأمین']] as $department)
                    <article class="card department-card">
                        <h3>{{ $department[0] }}</h3>
                        <p>{{ $department[1] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container panel">
            <x-site.section-heading title="موقعیت ما"/>
            <div class="map-placeholder">موقعیت کارخانه و دفتر فروش پس از تکمیل اطلاعات شرکت قابل نمایش است.</div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container">
            <x-site.section-heading title="پرسش‌های متداول"/>
            <div class="faq-list">
                @foreach ([
                    ['چگونه استعلام قیمت دریافت کنم؟', 'از فرم درخواست قیمت استفاده کنید یا با واحد فروش تماس بگیرید تا بر اساس محصول، مقدار و شرایط تحویل پاسخ دقیق دریافت کنید.'],
                    ['حداقل مقدار سفارش چقدر است؟', 'حداقل مقدار سفارش بر اساس نوع محصول و برنامه تولید تعیین می‌شود و توسط واحد فروش اعلام خواهد شد.'],
                    ['مدت زمان تحویل سفارش‌ها چقدر است؟', 'زمان تحویل به موجودی، حجم سفارش و مقصد ارسال بستگی دارد و در مرحله پیش‌فاکتور مشخص می‌شود.'],
                    ['آیا امکان ارسال به خارج از کشور وجود دارد؟', 'بله، امکان بررسی سفارش‌های صادراتی و بسته‌بندی مناسب ارسال خارجی وجود دارد.'],
                    ['روش‌های پرداخت چگونه است؟', 'شرایط پرداخت پس از بررسی سفارش و اعتبارسنجی همکاری به صورت شفاف اعلام می‌شود.'],
                ] as $faq)
                    <details class="faq-item">
                        <summary>{{ $faq[0] }}</summary>
                        <p>{{ $faq[1] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <h2>نیاز به مشاوره یا استعلام قیمت دارید؟</h2>
            <a class="btn btn-primary" href="{{ route('products.index') }}">مشاهده محصولات</a>
        </div>
    </section>
</x-layouts.app>
