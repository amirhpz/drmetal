<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    @php
        $quickSpecs = collect([
            'گرید' => $product->grade,
            'خلوص' => $product->purity,
            'وزن' => $product->weight,
            'ابعاد' => $product->dimensions,
            'بسته‌بندی' => $product->packaging,
            'حداقل سفارش' => $product->minimum_order_quantity,
        ])->filter();

        $technicalSpecs = collect($product->specifications ?? [])->filter();
    @endphp

    <section class="product-detail-hero">
        <div class="container product-detail-hero-grid">
            <div class="product-detail-copy">
                <a class="detail-back-link" href="{{ route('products.index') }}">بازگشت به محصولات</a>
                <p class="eyebrow">{{ $product->category?->title ?? 'محصول صنعتی' }}</p>
                <h1>{{ $product->title }}</h1>
                <div class="product-detail-actions">
                    <button class="btn btn-primary" type="button" data-quote-modal-open>درخواست قیمت</button>
                    <a class="btn btn-secondary" href="{{ route('contact.index') }}">مشاوره فروش</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section product-detail-section">
        <div class="container product-detail-layout">
            <div class="product-visual-panel">
                @if ($product->featured_image)
                    <img class="product-detail-image" src="{{ asset($product->featured_image) }}"
                         alt="{{ $product->title }}">
                @else
                    <div class="product-detail-visual" aria-hidden="true">
                        <span>{{ $product->category?->title ?? 'ALUMINIUM' }}</span>
                    </div>
                @endif
                <div class="product-detail-mini-specs">
                    @forelse ($quickSpecs->take(4) as $label => $value)
                        <div>
                            <span>{{ $label }}</span>
                            <strong>{{ $value }}</strong>
                        </div>
                    @empty
                        <div>
                            <span>نوع تامین</span>
                            <strong>سفارشی</strong>
                        </div>
                    @endforelse
                </div>
                @if ($product->gallery)
                    <div class="product-gallery-strip">
                        @foreach ($product->gallery as $galleryImage)
                            <img src="{{ asset($galleryImage) }}" alt="{{ $product->title }}">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-detail-content">
                <section class="detail-panel">
                    <div class="detail-panel-heading">
                        <span>معرفی محصول</span>
                        <h2>توضیحات و کاربرد صنعتی</h2>
                    </div>
                    <p>{{ $product->description ?: $product->short_description }}</p>

                    @if ($product->applications)
                        <div class="detail-tags">
                            @foreach ($product->applications as $application)
                                <span>{{ $application }}</span>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="detail-panel">
                    <div class="detail-panel-heading">
                        <span>داده فنی</span>
                        <h2>مشخصات محصول</h2>
                    </div>
                    <dl class="product-spec-table">
                        @forelse ($technicalSpecs->merge($quickSpecs) as $label => $value)
                            <div>
                                <dt>{{ $label }}</dt>
                                <dd>{{ $value }}</dd>
                            </div>
                        @empty
                            <div>
                                <dt>وضعیت</dt>
                                <dd>مشخصات تکمیلی پس از استعلام اعلام می‌شود.</dd>
                            </div>
                        @endforelse
                    </dl>
                </section>
            </div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container product-process-band">
            @foreach ([
                ['ارسال نیاز', 'گرید، مقدار و مقصد تحویل را اعلام کنید.'],
                ['بررسی فنی', 'تیم فروش و فنی امکان تامین را بررسی می‌کند.'],
                ['اعلام شرایط', 'قیمت، زمان تحویل و شرایط سفارش ارائه می‌شود.'],
            ] as $step)
                <div>
                    <strong>{{ $step[0] }}</strong>
                    <p>{{ $step[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="section section-muted">
            <div class="container">
                <x-site.section-heading title="محصولات مرتبط"/>
                <div class="card-grid">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-site.product-card :product="$relatedProduct"/>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="quote-modal" data-quote-modal aria-hidden="true">
        <div class="quote-modal-backdrop" data-quote-modal-close></div>
        <section class="quote-modal-panel" role="dialog" aria-modal="true" aria-labelledby="quote-modal-title">
            <button class="quote-modal-close" type="button" data-quote-modal-close aria-label="بستن">×</button>
            <div class="quote-modal-head">
                <span>درخواست قیمت</span>
                <h2 id="quote-modal-title">{{ $product->title }}</h2>
                <p>اطلاعات تماس و مقدار مورد نیاز را ثبت کنید تا واحد فروش شرایط تأمین و قیمت را اعلام کند.</p>
            </div>

            <form class="quote-modal-form" method="post" action="{{ route('quote.store') }}" data-quote-form>
                @csrf
                <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="honeypot">
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <label>
                    <span>محصول</span>
                    <input value="{{ $product->title }}" readonly>
                </label>

                <label>
                    <span>نام رابط</span>
                    <input name="contact_person" required autocomplete="name" placeholder="نام و نام خانوادگی">
                    <small class="field-error" data-error-for="contact_person"></small>
                </label>

                <label>
                    <span>شماره تماس</span>
                    <input name="phone" required inputmode="tel" autocomplete="tel" placeholder="مثلا ۰۹۱۲...">
                    <small class="field-error" data-error-for="phone"></small>
                </label>

                <label>
                    <span>نام شرکت</span>
                    <input name="company_name" autocomplete="organization" placeholder="اختیاری">
                    <small class="field-error" data-error-for="company_name"></small>
                </label>

                <label>
                    <span>ایمیل</span>
                    <input type="email" name="email" autocomplete="email" placeholder="اختیاری">
                    <small class="field-error" data-error-for="email"></small>
                </label>

                <label>
                    <span>مقدار مورد نیاز</span>
                    <input name="quantity" placeholder="مثلا ۵ تن یا ۱۰۰۰ کیلوگرم">
                    <small class="field-error" data-error-for="quantity"></small>
                </label>

                <label class="is-wide">
                    <span>توضیحات</span>
                    <textarea name="message" rows="4" placeholder="گرید، زمان تحویل، مقصد یا توضیحات تکمیلی"></textarea>
                    <small class="field-error" data-error-for="message"></small>
                </label>

                <div class="quote-modal-actions">
                    <button class="btn btn-primary" type="submit">ثبت درخواست قیمت</button>
                    <button class="btn btn-secondary" type="button" data-quote-modal-close>انصراف</button>
                </div>
            </form>
        </section>
    </div>

    <div class="site-toast" data-site-toast role="status" aria-live="polite"></div>
</x-layouts.app>
