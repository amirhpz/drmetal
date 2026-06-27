@props(['eyebrow' => null, 'title', 'description' => null])

<div class="section-heading">
    @if ($eyebrow)
        <span>{{ $eyebrow }}</span>
    @endif
    <h2>{{ $title }}</h2>
    @if ($description)
        <p>{{ $description }}</p>
    @endif
</div>
