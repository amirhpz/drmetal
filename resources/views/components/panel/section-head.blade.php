@props(['title'])

<div class="panel-section-head">
    <h2>{{ $title }}</h2>
    <div class="panel-actions">
        {{ $slot }}
    </div>
</div>
