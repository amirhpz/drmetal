<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="products-hero">
        <div class="container products-hero-grid">
            <div>
                <p class="eyebrow">کاتالوگ صنعتی دکتر متال</p>
                <h1>بیلت، شمش و آلیاژهای آلومینیومی برای تامین پایدار تولید</h1>
                <p>محصولات قابل تامین برای اکستروژن، ریخته‌گری و مصرف صنعتی با امکان هماهنگی گرید، بسته‌بندی، مقدار سفارش و برنامه تحویل.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('contact.index') }}#quote">استعلام قیمت</a>
                    <a class="btn btn-secondary" href="{{ route('contact.index') }}">مشاوره فنی</a>
                </div>
            </div>

            <div class="catalog-summary" aria-label="خلاصه کاتالوگ محصولات">
                <div>
                    <span>دسته‌بندی فعال</span>
                    <strong>{{ $categories->count() ?: '۴' }}</strong>
                </div>
                <div>
                    <span>محصول قابل نمایش</span>
                    <strong>{{ $products->total() ?: '۶' }}</strong>
                </div>
                <div>
                    <span>نوع همکاری</span>
                    <strong>B2B</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="section products-catalog-section">
        <div class="container catalog-layout">
            <aside class="catalog-sidebar">
                <div class="catalog-sidebar-head">
                    <span>فیلتر محصولات</span>
                    <strong>{{ $selectedCategory?->title ?? 'همه محصولات' }}</strong>
                </div>
                <nav class="category-nav" aria-label="دسته‌بندی محصولات">
                    <a @class(['is-active' => ! request('category')]) href="{{ route('products.index') }}">
                        <span>همه محصولات</span>
                        <small>{{ $products->total() ?: '۶' }}</small>
                    </a>
                    @foreach ($categories as $category)
                        <a @class(['is-active' => $selectedCategory?->is($category)]) href="{{ route('products.index', ['category' => $category->slug]) }}">
                            <span>{{ $category->title }}</span>
                            <small>مشاهده</small>
                        </a>
                    @endforeach
                </nav>
                <div class="catalog-note">
                    <strong>سفارش سفارشی</strong>
                    <p>برای گرید، ابعاد یا بسته‌بندی خاص، مشخصات مورد نیاز را برای واحد فروش ارسال کنید.</p>
                </div>
            </aside>

            <div class="catalog-main">
                <div class="catalog-toolbar">
                    <div>
                        <span>محصولات قابل تامین</span>
                        <h2>{{ $selectedCategory?->title ?? 'کاتالوگ محصولات' }}</h2>
                    </div>
                    <p>مرتب‌سازی بر اساس اولویت تامین و کاربرد صنعتی</p>
                </div>

                <div class="catalog-tags">
                    @foreach (['بیلت 6063', 'بیلت 6061', 'شمش A7', 'شمش A8', 'آلیاژ سفارشی'] as $tag)
                        <span>{{ $tag }}</span>
                    @endforeach
                </div>

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
                                        <a class="btn btn-secondary" href="{{ route('contact.index') }}#quote">استعلام قیمت</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>

                <div class="pagination-wrap">{{ $products->links() }}</div>
            </div>
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
            <a class="btn btn-primary" href="{{ route('contact.index') }}#quote">ثبت درخواست قیمت</a>
        </div>
    </section>
</x-layouts.app>
