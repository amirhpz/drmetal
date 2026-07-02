@props(['product'])

<article class="card product-card">
    @if ($product->featured_image)
        <img class="product-card-image" src="{{ asset($product->featured_image) }}" alt="{{ $product->title }}">
    @else
        <div class="visual-placeholder" aria-hidden="true">
            <span>{{ $product->grade ?: $product->purity ?: $product->category?->title ?: 'AL' }}</span>
        </div>
    @endif
    <div class="card-body">
{{--        <div class="product-card-kicker">{{ $product->category?->title ?? 'محصول صنعتی' }}</div>--}}
        <h3>{{ $product->title }}</h3>
        <div class="card-actions">
            <a class="btn btn-secondary" href="{{ route('products.show', $product) }}">جزئیات بیشتر</a>
        </div>
    </div>
</article>
