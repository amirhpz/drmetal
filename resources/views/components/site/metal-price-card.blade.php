@props(['price'])

<article @class(['price-card', 'is-up' => $price->isUp(), 'is-down' => $price->isDown(), 'is-stale' => $price->is_stale])>
    <div class="price-card-head">
        <div>
            <span class="symbol">{{ $price->symbol }}</span>
            <h3>{{ $price->name }}</h3>
        </div>
        <span class="price-status">{{ $price->is_stale ? 'آخرین داده' : 'به‌روز' }}</span>
    </div>
    <div class="price-value">
        <strong>{{ $price->formattedPrice() }}</strong>
        <p>{{ $price->unit }}</p>
    </div>
    <div class="price-meta">
        <span>{{ $price->formattedChangePercent() }}</span>
        <span>{{ $price->isUp() ? 'رشد بازار' : ($price->isDown() ? 'افت بازار' : 'بدون تغییر') }}</span>
    </div>
</article>
