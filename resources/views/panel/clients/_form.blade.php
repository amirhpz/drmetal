@csrf
@if ($client->exists)
    @method('PUT')
@endif

<div class="product-form">
    <section class="product-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>اطلاعات مشتری</h2>
                <p>نام، حوزه فعالیت و وضعیت نمایش مشتری را وارد کنید.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="name">نام فارسی</label>
                <input id="name" name="name" value="{{ old('name', $client->name) }}" required placeholder="مثلا بوتان">
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="english_name">نام انگلیسی</label>
                <input id="english_name" name="english_name" dir="ltr" value="{{ old('english_name', $client->english_name) }}" placeholder="Butane">
                @error('english_name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="industry">حوزه فعالیت</label>
                <input id="industry" name="industry" value="{{ old('industry', $client->industry) }}" placeholder="صنعتی، تولیدی، آلومینیوم">
                @error('industry') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="website">وب‌سایت</label>
                <input id="website" name="website" dir="ltr" value="{{ old('website', $client->website) }}" placeholder="https://example.com">
                @error('website') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="sort_order">ترتیب نمایش</label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $client->sort_order ?? 0) }}">
                @error('sort_order') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="publish-options" style="margin-top: 16px;">
            <label class="toggle-card">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $client->is_active ?? true))>
                <span>
                    <strong>فعال</strong>
                    <small>در صفحات عمومی سایت نمایش داده شود.</small>
                </span>
            </label>

            <label class="toggle-card">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $client->is_featured ?? true))>
                <span>
                    <strong>مشتری ویژه</strong>
                    <small>در بخش‌های خلاصه مثل صفحه اصلی نمایش داده شود.</small>
                </span>
            </label>
        </div>
    </section>

    <section class="product-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>لوگو</h2>
                <p>در صورت نبود لوگو، حرف اول نام مشتری به صورت متنی نمایش داده می‌شود.</p>
            </div>
        </div>

        <div class="upload-card">
            <div class="upload-card-head">
                <div>
                    <h3>آپلود لوگوی مشتری</h3>
                    <p>فایل سبک و خوانا برای نمایش در کارت مشتری انتخاب کنید.</p>
                </div>
                <x-panel.badge>JPG / PNG / WEBP</x-panel.badge>
            </div>

            @if ($client->logo)
                <div class="current-image-card">
                    <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
                    <label class="check-row">
                        <input type="checkbox" name="remove_logo" value="1">
                        <span>حذف لوگوی فعلی هنگام ذخیره</span>
                    </label>
                </div>
            @endif

            <label class="upload-dropzone" for="logo_file" data-upload-zone>
                <input id="logo_file" name="logo_file" type="file" accept="image/jpeg,image/png,image/webp" data-preview-target="client-logo-preview">
                <span class="upload-icon">+</span>
                <strong>انتخاب لوگو</strong>
                <small>حداکثر ۲ مگابایت</small>
            </label>

            <div class="upload-preview-grid single" id="client-logo-preview" aria-live="polite"></div>
            @error('logo_file') <span class="error-text">{{ $message }}</span> @enderror
        </div>
    </section>
</div>

<x-panel.form-actions :back="route('panel.clients.index')" />

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
                    if (!file.type.startsWith('image/')) {
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
