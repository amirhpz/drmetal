@props(['class' => ''])

<section {{ $attributes->merge(['class' => trim('panel-card '.$class)]) }}>
    {{ $slot }}
</section>
