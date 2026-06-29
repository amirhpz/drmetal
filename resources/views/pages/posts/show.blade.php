<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription">
    <section class="post-detail-hero">
        <div class="container post-detail-hero-grid">
            <div>
                <a class="detail-back-link" href="{{ route('posts.index') }}">بازگشت به مقالات</a>
                <p class="eyebrow">{{ $post->category ?: 'مقاله دکتر متال' }}</p>
                <h1>{{ $post->title }}</h1>
                <p>{{ $post->excerpt }}</p>
                <div class="post-detail-meta">
                    @if ($post->author_name)
                        <span>{{ $post->author_name }}</span>
                    @endif
                    <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->timezone('Asia/Tehran')->format('Y/m/d') }}</time>
                </div>
            </div>

            <aside class="post-detail-aside">
                <span>دسته‌بندی</span>
                <strong>{{ $post->category ?: 'مقاله' }}</strong>
                <p>مطالب دکتر متال با تمرکز بر کاربرد صنعتی، تصمیم‌گیری بهتر و انتقال تجربه تخصصی منتشر می‌شوند.</p>
            </aside>
        </div>
    </section>

    @if ($post->featured_image)
        <section class="post-cover-section">
            <div class="container">
                <img class="post-cover-image" src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
            </div>
        </section>
    @endif

    <section class="section post-content-section">
        <div class="container post-content-layout">
            <article class="post-content">
                {!! nl2br(e($post->body ?: $post->excerpt)) !!}
            </article>

            <aside class="post-sidebar">
                <div class="post-sidebar-card">
                    <strong>دکتر متال</strong>
                    <p>طراحی، تولید، بهینه‌سازی و تامین محصولات آلومینیومی و فلزات رنگین با رویکرد دانش‌پایه.</p>
                    <a class="btn btn-secondary" href="{{ route('contact.index') }}#quote">درخواست همکاری</a>
                </div>
            </aside>
        </div>
    </section>

    @if ($relatedPosts->isNotEmpty())
        <section class="section section-muted">
            <div class="container">
                <x-site.section-heading title="مطالب مرتبط" />
                <div class="post-grid">
                    @foreach ($relatedPosts as $relatedPost)
                        <article class="post-card">
                            <a class="post-card-media" href="{{ route('posts.show', $relatedPost) }}" aria-label="{{ $relatedPost->title }}">
                                @if ($relatedPost->featured_image)
                                    <img src="{{ asset($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}">
                                @else
                                    <span>{{ $relatedPost->category ?: 'Dr Metal' }}</span>
                                @endif
                            </a>
                            <div class="post-card-body">
                                <div class="post-meta">
                                    <span>{{ $relatedPost->category ?: 'مقاله' }}</span>
                                    <time datetime="{{ $relatedPost->published_at?->toDateString() }}">{{ $relatedPost->published_at?->timezone('Asia/Tehran')->format('Y/m/d') }}</time>
                                </div>
                                <h2><a href="{{ route('posts.show', $relatedPost) }}">{{ $relatedPost->title }}</a></h2>
                                <p>{{ $relatedPost->excerpt }}</p>
                                <a class="post-read-link" href="{{ route('posts.show', $relatedPost) }}">ادامه مطلب</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
