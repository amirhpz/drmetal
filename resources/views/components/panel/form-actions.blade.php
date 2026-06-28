@props(['back' => null, 'submit' => 'ذخیره'])

<div class="panel-actions" style="margin-top: 18px;">
    <x-panel.button variant="primary" type="submit">{{ $submit }}</x-panel.button>
    @if ($back)
        <x-panel.button :href="$back">بازگشت</x-panel.button>
    @endif
    {{ $slot }}
</div>
