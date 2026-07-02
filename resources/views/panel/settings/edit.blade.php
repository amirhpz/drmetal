@extends('layouts.panel')

@section('title', 'تنظیمات سایت')
@section('heading', 'تنظیمات سایت')
@section('subtitle', 'مدیریت اطلاعات برند، تماس، سئو و محتوای پایه سایت')

@section('content')
    @php($oldSettings = old('settings', []))

    <form method="POST" action="{{ route('panel.settings.update') }}" class="product-form">
        @csrf
        @method('PUT')

        @foreach ($definitions as $group)
            <section class="product-form-section">
                <div class="product-form-section-head compact">
                    <div>
                        <h2>{{ $group['title'] }}</h2>
                        <p>{{ $group['description'] }}</p>
                    </div>
                </div>

                <div class="form-grid">
                    @foreach ($group['fields'] as $field)
                        @php($storedValue = $settings[$field['key']] ?? null)
                        @php($value = $oldSettings[$field['key']] ?? ((! blank($storedValue) || ! array_key_exists('default', $field)) ? $storedValue : $field['default']) ?? '')
                        <div @class(['form-field', 'is-wide' => $field['type'] === 'textarea'])>
                            <label for="{{ $field['key'] }}">{{ $field['label'] }}</label>
                            @if ($field['type'] === 'textarea')
                                <textarea id="{{ $field['key'] }}" name="settings[{{ $field['key'] }}]" rows="4">{{ $value }}</textarea>
                            @else
                                <input id="{{ $field['key'] }}" name="settings[{{ $field['key'] }}]" value="{{ $value }}">
                            @endif
                            @error('settings.*') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <x-panel.form-actions :back="route('panel.dashboard')" />
    </form>
@endsection
