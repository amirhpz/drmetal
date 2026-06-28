@props([
    'href' => null,
    'variant' => 'muted',
    'type' => 'button',
])

@php($class = 'btn btn-'.$variant)

@if ($href)
    <a {{ $attributes->merge(['class' => $class, 'href' => $href]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $class, 'type' => $type]) }}>
        {{ $slot }}
    </button>
@endif
