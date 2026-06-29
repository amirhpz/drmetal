<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="posts-hero">
        <div class="container posts-hero-grid">
            <div>
                <p class="eyebrow">مقالات و اخبار دکتر متال</p>
                <h1>دانش متالورژی، بازار فلزات و تجربه صنعتی در یک مسیر قابل مطالعه</h1>
                <p>یادداشت‌ها و خبرهای دکتر متال درباره آلومینیوم، فلزات رنگین، تولید صنعتی، کیفیت و روندهای مهم بازار.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#latest-posts">مشاهده مطالب</a>
                    <a class="btn btn-secondary" href="{{ route('contact.index') }}">ارتباط با دکتر متال</a>
                </div>
            </div>

            <aside class="posts-hero-panel" aria-label="خلاصه بخش مقالات">
                <span>Dr Metal Journal</span>
                <strong>{{ $posts->total() ?: '۰' }}</strong>
                <p>مطلب منتشر شده برای دسترسی سریع مشتریان صنعتی و مخاطبان تخصصی.</p>
            </aside>
        </div>
    </section>

    @if ($featuredPosts->isNotEmpty())
        <section class="section tight-section">
            <div class="container">
                <x-site.section-heading
                    eyebrow="مطالب منتخب"
                    title="خواندنی‌های پیشنهادی"
                    description="مطالبی که برای شناخت بهتر فعالیت، تخصص و بازار هدف دکتر متال برجسته شده‌اند."
                />

                <div class="featured-post-grid">
                    @foreach ($featuredPosts as $post)
                        <article class="post-card post-card-featured">
                            <a class="post-card-media" href="{{ route('posts.show', $post) }}" aria-label="{{ $post->title }}">
                                @if ($post->featured_image)
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <span>{{ $post->category ?: 'Dr Metal' }}</span>
                                @endif
                            </a>
                            <div class="post-card-body">
                                <div class="post-meta">
                                    <span>{{ $post->category ?: 'مقاله' }}</span>
                                    <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->timezone('Asia/Tehran')->format('Y/m/d') }}</time>
                                </div>
                                <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
                                <p>{{ $post->excerpt }}</p>
                                <a class="post-read-link" href="{{ route('posts.show', $post) }}">ادامه مطلب</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section section-muted" id="latest-posts">
        <div class="container">
            <div class="section-title-row">
                <x-site.section-heading
                    eyebrow="آخرین مطالب"
                    title="مقالات و خبرها"
                    description="همه مطالب منتشر شده به ترتیب اولویت و زمان انتشار نمایش داده می‌شوند."
                />
                <span>{{ $posts->total() }} مطلب</span>
            </div>

            @if ($posts->count() > 0)
                <div class="post-grid">
                    @foreach ($posts as $post)
                        <article class="post-card">
                            <a class="post-card-media" href="{{ route('posts.show', $post) }}" aria-label="{{ $post->title }}">
                                @if ($post->featured_image)
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <span>{{ $post->category ?: 'Dr Metal' }}</span>
                                @endif
                            </a>
                            <div class="post-card-body">
                                <div class="post-meta">
                                    <span>{{ $post->category ?: 'مقاله' }}</span>
                                    <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->timezone('Asia/Tehran')->format('Y/m/d') }}</time>
                                </div>
                                <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
                                <p>{{ $post->excerpt }}</p>
                                <a class="post-read-link" href="{{ route('posts.show', $post) }}">ادامه مطلب</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pagination-wrap">{{ $posts->links() }}</div>
            @else
                <div class="empty-state">هنوز مطلبی منتشر نشده است.</div>
            @endif
        </div>
    </section>

    <section class="section">
        <div class="container final-cta">
            <div>
                <p class="eyebrow">همکاری صنعتی</p>
                <h2>برای دریافت مشاوره درباره تامین آلومینیوم و فلزات رنگین با ما در ارتباط باشید.</h2>
            </div>
            <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
        </div>
    </section>
</x-layouts.app>
