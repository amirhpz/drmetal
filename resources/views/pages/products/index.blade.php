<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <x-site.page-hero path="خانه / محصولات" label="Industrial Products" title="محصولات" />

    <section class="section products-catalog-section">
        <div class="container products-simple-layout">
            <div class="catalog-toolbar products-toolbar">
                <div>
                    <span>محصولات قابل تامین</span>
                    <h2>{{ $selectedCategory?->title ?? 'همه محصولات' }}</h2>
                </div>
                <p>{{ \App\Support\PersianNumber::digits($products->total()) }} محصول</p>
            </div>

            <nav class="category-nav products-filter" aria-label="دسته‌بندی محصولات">
                <a @class(['is-active' => ! request('category')]) href="{{ route('products.index') }}">
                    <span>همه</span>
                </a>
                @foreach ($categories as $category)
                    <a @class(['is-active' => $selectedCategory?->is($category)]) href="{{ route('products.index', ['category' => $category->slug]) }}">
                        <span>{{ $category->title }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="product-grid-detailed catalog-product-grid">
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <x-site.product-card :product="$product" />
                    @endforeach
                @else
                    @foreach ([
                        ['title' => 'بیلت آلومینیوم 6063', 'meta' => 'اکستروژن پروفیل / سطح یکنواخت'],
                        ['title' => 'بیلت آلومینیوم 6061', 'meta' => 'کاربرد صنعتی / مقاومت مکانیکی'],
                        ['title' => 'شمش آلومینیوم A7', 'meta' => 'خلوص 99.7٪ / ریخته‌گری'],
                    ] as $fallback)
                        <article class="card product-card">
                            <div class="visual-placeholder" aria-hidden="true"><span>{{ $fallback['meta'] }}</span></div>
                            <div class="card-body">
                                <div class="product-card-kicker">محصول قابل سفارش</div>
                                <h3>{{ $fallback['title'] }}</h3>
                                <p>{{ $fallback['meta'] }}</p>
                                <div class="spec-row"><span>استعلام روز</span></div>
                                <div class="card-actions">
                                    <button class="btn btn-secondary" type="button" data-quote-modal-open>استعلام قیمت</button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>

            <div class="pagination-wrap">{{ $products->links() }}</div>
        </div>
    </section>

    <section class="section tight-section">
        <div class="container procurement-band">
            @foreach ([
                ['بررسی نیاز', 'گرید، مقدار، کاربرد و زمان تحویل بررسی می‌شود.'],
                ['پیشنهاد فنی', 'گزینه مناسب محصول و شرایط تامین اعلام می‌شود.'],
                ['هماهنگی سفارش', 'بسته‌بندی، بارگیری و ارسال با برنامه تولید هماهنگ می‌شود.'],
            ] as $step)
                <div>
                    <strong>{{ $step[0] }}</strong>
                    <p>{{ $step[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <h2>برای دریافت مشخصات فنی و پیش‌فاکتور، درخواست خود را ارسال کنید.</h2>
            <button class="btn btn-primary" type="button" data-quote-modal-open>ثبت درخواست قیمت</button>
        </div>
    </section>
</x-layouts.app>
