<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="inner-hero section">
        <div class="container inner-hero-grid">
            <div>
                <h1>ارتباط با ما</h1>
                <p>برای دریافت مشاوره، بررسی همکاری صنعتی یا ارتباط با صنایع متالورژی دکتر متال در ارتباط
                    باشید.</p>
            </div>
            <div class="hero-visual small-visual industrial-visual" aria-hidden="true">
                <div class="ingot-stack"><span></span><span></span><span></span></div>
            </div>
        </div>
    </section>

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

            <div class="forms-stack">
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
                            @foreach (['استعلام قیمت', 'مشاوره خرید', 'پیگیری سفارش', 'سایر موارد'] as $subject)
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

                <form class="form-card" id="quote" method="post" action="{{ route('quote.store') }}">
                    @csrf
                    <h2>درخواست قیمت</h2>
                    <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="honeypot">
                    <label>نام شرکت
                        <input name="company_name" value="{{ old('company_name') }}"
                               placeholder="نام شرکت خود را وارد کنید">
                        <x-site.form-error name="company_name"/>
                    </label>
                    <label>نام رابط
                        <input name="contact_person" value="{{ old('contact_person') }}" required
                               placeholder="نام رابط را وارد کنید">
                        <x-site.form-error name="contact_person"/>
                    </label>
                    <label>شماره تماس
                        <input name="phone" value="{{ old('phone') }}" required placeholder="شماره تماس را وارد کنید">
                        <x-site.form-error name="phone"/>
                    </label>
                    <label>محصول
                        <select name="product_id">
                            <option value="">انتخاب محصول</option>
                            @foreach ($products as $product)
                                <option
                                    value="{{ $product->id }}" @selected((string) old('product_id') === (string) $product->id)>{{ $product->title }}</option>
                            @endforeach
                        </select>
                        <x-site.form-error name="product_id"/>
                    </label>
                    <label>مقدار مورد نیاز
                        <input name="quantity" value="{{ old('quantity') }}" placeholder="مقدار سفارش را وارد کنید">
                        <x-site.form-error name="quantity"/>
                    </label>
                    <label>توضیحات
                        <textarea name="message" rows="4"
                                  placeholder="توضیحات تکمیلی سفارش">{{ old('message') }}</textarea>
                        <x-site.form-error name="message"/>
                    </label>
                    <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                </form>
            </div>
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
            <a class="btn btn-primary" href="#quote">درخواست مشاوره</a>
        </div>
    </section>
</x-layouts.app>
