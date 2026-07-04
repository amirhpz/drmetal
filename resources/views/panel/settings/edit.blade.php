@extends('layouts.panel')

@section('title', 'تنظیمات سایت')
@section('heading', 'تنظیمات سایت')
@section('subtitle', 'مدیریت اطلاعات برند، تماس، سئو و محتوای پایه سایت')

@section('content')
    @php($oldSettings = old('settings', []))

    <form method="POST" action="{{ route('panel.settings.update') }}" class="product-form" enctype="multipart/form-data">
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
                        @php($nestedFieldName = str_replace('.', '][', $field['key']))
                        <div @class(['form-field', 'is-wide' => $field['type'] === 'textarea' || $field['type'] === 'image'])>
                            <label for="{{ $field['key'] }}">{{ $field['label'] }}</label>
                            @if ($field['type'] === 'textarea')
                                <textarea id="{{ $field['key'] }}" name="settings[{{ $field['key'] }}]" rows="4">{{ $value }}</textarea>
                            @elseif ($field['type'] === 'image')
                                <div class="upload-card">
                                    <div class="upload-card-head">
                                        <div>
                                            <h3>{{ $field['label'] }}</h3>
                                            <p>فایل جدید را انتخاب کنید یا تصویر فعلی را نگه دارید.</p>
                                        </div>
                                        <x-panel.badge>{{ $field['key'] === 'company.favicon' ? 'ICO / PNG / WEBP' : 'JPG / PNG / WEBP' }}</x-panel.badge>
                                    </div>

                                    @if ($value)
                                        <div class="current-image-card">
                                            <img src="{{ asset($value) }}" alt="{{ $field['label'] }}">
                                            <label class="check-row">
                                                <input type="checkbox" name="remove_files[{{ $nestedFieldName }}]" value="1">
                                                <span>حذف فایل فعلی هنگام ذخیره</span>
                                            </label>
                                        </div>
                                    @endif

                                    <label class="upload-dropzone" for="{{ $field['key'] }}" data-upload-zone>
                                        <input
                                            id="{{ $field['key'] }}"
                                            name="files[{{ $nestedFieldName }}]"
                                            type="file"
                                            accept="{{ $field['key'] === 'company.favicon' ? 'image/x-icon,image/vnd.microsoft.icon,image/png,image/jpeg,image/webp' : 'image/jpeg,image/png,image/webp' }}"
                                            data-preview-target="{{ str_replace('.', '-', $field['key']) }}-preview"
                                        >
                                        <span class="upload-icon">+</span>
                                        <strong>انتخاب فایل</strong>
                                        <small>{{ $field['key'] === 'company.favicon' ? 'حداکثر ۱ مگابایت' : 'حداکثر ۲ مگابایت' }}</small>
                                    </label>

                                    <div class="upload-preview-grid single" id="{{ str_replace('.', '-', $field['key']) }}-preview" aria-live="polite"></div>
                                </div>
                            @else
                                <input id="{{ $field['key'] }}" name="settings[{{ $field['key'] }}]" value="{{ $value }}">
                            @endif
                            @error('settings.*') <span class="error-text">{{ $message }}</span> @enderror
                            @error('files.'.$field['key']) <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <x-panel.form-actions :back="route('panel.dashboard')" />
    </form>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('input[type="file"][data-preview-target]').forEach((input) => {
            input.addEventListener('change', () => {
                const target = document.getElementById(input.dataset.previewTarget);

                if (!target) {
                    return;
                }

                target.innerHTML = '';

                Array.from(input.files || []).slice(0, 1).forEach((file) => {
                    if (!file.type.startsWith('image/') && !file.name.toLowerCase().endsWith('.ico')) {
                        return;
                    }

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const item = document.createElement('div');
                        item.className = 'upload-preview-item';

                        const image = document.createElement('img');
                        image.src = reader.result;
                        image.alt = file.name;

                        const caption = document.createElement('span');
                        caption.textContent = file.name;

                        item.append(image, caption);
                        target.append(item);
                    });
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endpush
