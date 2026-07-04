<x-layouts.app :meta-title="$metaTitle" :meta-description="$metaDescription" page-class="articles-page article-detail-page">
    <section class="article-detail-hero">
        <div class="container article-detail-hero-grid">
            <div class="article-detail-heading">
                <a class="detail-back-link" href="{{ route('posts.index') }}">بازگشت به مقالات</a>
                <h1>{{ $post->title }}</h1>
            </div>
        </div>
    </section>

    <section class="section article-body-section">
        <div class="container article-detail-layout">
            <aside class="article-sidebar">
                <div class="article-sidebar-card article-info-card">
                    <strong>اطلاعات مقاله</strong>
                    <dl>
                        <div>
                            <dt>دسته‌بندی</dt>
                            <dd>{{ $post->category ?: 'مقاله دکتر متال' }}</dd>
                        </div>
                        @if ($post->author_name)
                            <div>
                                <dt>نویسنده</dt>
                                <dd>{{ $post->author_name }}</dd>
                            </div>
                        @endif
                        @if ($post->published_at)
                            <div>
                                <dt>انتشار</dt>
                                <dd><time datetime="{{ $post->published_at->toDateString() }}">{{ \App\Support\PersianDate::date($post->published_at->timezone('Asia/Tehran')) }}</time></dd>
                            </div>
                        @endif
                        <div>
                            <dt>زمان مطالعه</dt>
                            <dd>{{ \App\Support\PersianNumber::digits($readingMinutes) }} دقیقه</dd>
                        </div>
                    </dl>
                    @if ($post->excerpt)
                        <p>{{ $post->excerpt }}</p>
                    @endif
                </div>

                @if ($tocItems->isNotEmpty())
                    <nav class="article-toc" aria-label="فهرست مقاله">
                        <strong>فهرست مقاله</strong>
                        @foreach ($tocItems as $item)
                            <a href="#{{ $item['id'] }}">{{ $item['text'] }}</a>
                        @endforeach
                    </nav>
                @endif

                @if ($relatedPosts->isNotEmpty())
                    <div class="article-sidebar-card article-sidebar-related">
                        <strong>مقالات مرتبط</strong>
                        <div class="sidebar-related-list">
                            @foreach ($relatedPosts as $relatedPost)
                                <a href="{{ route('posts.show', $relatedPost) }}">
                                    @if ($relatedPost->featured_image)
                                        <img src="{{ asset($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" loading="lazy">
                                    @else
                                        <span>{{ $relatedPost->category ?: 'Dr Metal' }}</span>
                                    @endif
                                    <small>{{ $relatedPost->category ?: 'مقاله' }}</small>
                                    <b>{{ $relatedPost->title }}</b>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

            <article class="article-content">
                @if ($post->featured_image)
                    <img class="article-cover-image article-content-cover" src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
                @else
                    <div class="article-cover-placeholder article-content-cover" aria-hidden="true">
                        <span>{{ $post->category ?: 'Dr Metal' }}</span>
                    </div>
                @endif

                <div class="article-content-body">
                    @if ($articleHtml)
                        {!! $articleHtml !!}
                    @else
                        @forelse ($articleBlocks as $block)
                            @if ($block['type'] === 'h2')
                                <h2 id="{{ $block['id'] }}">{{ $block['text'] }}</h2>
                            @elseif ($block['type'] === 'h3')
                                <h3 id="{{ $block['id'] }}">{{ $block['text'] }}</h3>
                            @else
                                <p>{!! nl2br(e($block['text'])) !!}</p>
                            @endif
                        @empty
                            <p>{{ $post->excerpt }}</p>
                        @endforelse
                    @endif
                </div>
            </article>
        </div>
    </section>

    <button class="article-floating-cta" type="button" data-quote-modal-open>درخواست همکاری</button>

    @if ($relatedPosts->isNotEmpty())
        <section class="section section-muted related-articles related-articles-mobile">
            <div class="container">
                <x-site.section-heading
                    title="مقالات مرتبط"
                    description="مطالبی نزدیک به همین موضوع برای ادامه مطالعه."
                />
                <div class="article-grid">
                    @foreach ($relatedPosts as $relatedPost)
                        <x-site.article-card :post="$relatedPost" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container articles-bottom-cta">
            <div>
                <p class="eyebrow">همکاری با دکتر متال</p>
                <h2>برای مشاوره تخصصی در زمینه محصولات آلومینیومی با ما در ارتباط باشید</h2>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('contact.index') }}">تماس با ما</a>
                <a class="btn btn-secondary" href="{{ route('products.index') }}">مشاهده محصولات</a>
            </div>
        </div>
    </section>
</x-layouts.app>
