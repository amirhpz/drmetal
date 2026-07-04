<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription" :quote-product="$product">
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

</x-layouts.app>
