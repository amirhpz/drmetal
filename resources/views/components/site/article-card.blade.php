@props(['post', 'featured' => false])

@php
    $readingMinutes = max(1, (int) ceil(mb_strlen(trim(strip_tags(($post->body ?: '').' '.$post->excerpt))) / 900));
@endphp

<article @class(['article-card', 'is-featured' => $featured])>
    <a class="article-card-media" href="{{ route('posts.show', $post) }}" aria-label="مطالعه مقاله {{ $post->title }}">
        @if ($post->featured_image)
            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
        @else
            <span>{{ $post->category ?: 'Dr Metal' }}</span>
        @endif
    </a>

    <div class="article-card-body">
        <div class="article-meta">
            <span>{{ $post->category ?: 'مقاله' }}</span>
            @if ($post->published_at)
                <time datetime="{{ $post->published_at->toDateString() }}">{{ \App\Support\PersianDate::date($post->published_at->timezone('Asia/Tehran')) }}</time>
            @endif
        </div>

        <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>

        @if ($post->excerpt)
            <p>{{ $post->excerpt }}</p>
        @endif

        <a class="article-read-link" href="{{ route('posts.show', $post) }}">مطالعه مقاله</a>
    </div>
</article>
