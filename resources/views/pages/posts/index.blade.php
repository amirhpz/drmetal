<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription" page-class="articles-page">
    <x-site.page-hero path="خانه / مقالات" label="Knowledge Center" title="مقالات و دانشنامه" />

{{--    <section class="section articles-feature-section">--}}
{{--        <div class="container">--}}
{{--            <div class="articles-toolbar">--}}
{{--                <div>--}}
{{--                    <span>مقاله منتخب</span>--}}
{{--                    <h2>شروع مطالعه از اینجا</h2>--}}
{{--                </div>--}}

{{--                <form class="articles-search" action="{{ route('posts.index') }}" method="get" role="search">--}}
{{--                    @if ($selectedCategory)--}}
{{--                        <input type="hidden" name="category" value="{{ $selectedCategory }}">--}}
{{--                    @endif--}}
{{--                    <label for="article-search">جستجو در مقالات</label>--}}
{{--                    <div>--}}
{{--                        <input id="article-search" name="q" value="{{ $search }}" placeholder="جستجو در مقالات...">--}}
{{--                        <button class="btn btn-primary" type="submit">جستجو</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            @if ($featuredPost)--}}
{{--                <article class="featured-article">--}}
{{--                    <a class="featured-article-media" href="{{ route('posts.show', $featuredPost) }}" aria-label="مطالعه مقاله {{ $featuredPost->title }}">--}}
{{--                        @if ($featuredPost->featured_image)--}}
{{--                            <img src="{{ asset($featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" loading="lazy">--}}
{{--                        @else--}}
{{--                            <span>{{ $featuredPost->category ?: 'Dr Metal' }}</span>--}}
{{--                        @endif--}}
{{--                    </a>--}}

{{--                    <div class="featured-article-content">--}}
{{--                        <div class="article-meta">--}}
{{--                            <span>{{ $featuredPost->category ?: 'مقاله' }}</span>--}}
{{--                            @if ($featuredPost->published_at)--}}
{{--                                <time datetime="{{ $featuredPost->published_at->toDateString() }}">{{ \App\Support\PersianDate::date($featuredPost->published_at->timezone('Asia/Tehran')) }}</time>--}}
{{--                            @endif--}}
{{--                            <span>{{ \App\Support\PersianNumber::digits(max(1, (int) ceil(mb_strlen(trim(strip_tags(($featuredPost->body ?: '').' '.$featuredPost->excerpt))) / 900))) }} دقیقه مطالعه</span>--}}
{{--                        </div>--}}
{{--                        <h2><a href="{{ route('posts.show', $featuredPost) }}">{{ $featuredPost->title }}</a></h2>--}}
{{--                        <p>{{ $featuredPost->excerpt }}</p>--}}
{{--                        <a class="btn btn-primary" href="{{ route('posts.show', $featuredPost) }}">مطالعه مقاله</a>--}}
{{--                    </div>--}}
{{--                </article>--}}
{{--            @else--}}
{{--                <div class="articles-empty">--}}
{{--                    <strong>هنوز مقاله‌ای منتشر نشده است.</strong>--}}
{{--                    <p>به‌زودی مطالب تخصصی این بخش اضافه خواهد شد.</p>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="section section-muted articles-list-section" id="articles-list">
        <div class="container articles-layout">
            <aside class="articles-filter-panel">
                <strong>دسته‌بندی‌ها</strong>
                <nav class="articles-category-nav" aria-label="دسته‌بندی مقالات">
                    <a @class(['is-active' => $selectedCategory === '']) href="{{ route('posts.index', array_filter(['q' => $search])) }}">همه</a>
                    @foreach ($categories as $category)
                        <a @class(['is-active' => $selectedCategory === $category]) href="{{ route('posts.index', array_filter(['category' => $category, 'q' => $search])) }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </nav>

                @if ($selectedCategory || $search)
                    <a class="articles-clear-filter" href="{{ route('posts.index') }}">حذف فیلترها</a>
                @endif
            </aside>

            <div class="articles-main">
                <div class="articles-list-head">
                    <div>
                        <span>آخرین مطالب</span>
                        <h2>{{ $selectedCategory ?: 'همه مقالات' }}</h2>
                    </div>
                    <p>{{ \App\Support\PersianNumber::digits($posts->total()) }} مطلب</p>
                </div>

                @if ($posts->count() > 0)
                    <div class="article-grid">
                        @foreach ($posts as $post)
                            <x-site.article-card :post="$post" />
                        @endforeach
                    </div>

                    <div class="pagination-wrap articles-pagination">{{ $posts->withQueryString()->links() }}</div>
                @else
                    <div class="articles-empty">
                        <strong>هنوز مقاله‌ای منتشر نشده است.</strong>
                        <p>به‌زودی مطالب تخصصی این بخش اضافه خواهد شد.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container articles-bottom-cta">
            <div>
                <p class="eyebrow">مشاوره تخصصی</p>
                <h2>برای مشاوره تخصصی در زمینه محصولات آلومینیومی با ما در ارتباط باشید</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('products.index') }}">مشاهده محصولات</a>
            </div>
        </div>
    </section>
</x-layouts.app>
