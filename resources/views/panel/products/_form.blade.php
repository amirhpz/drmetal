@csrf
@if ($product->exists)
    @method('PUT')
@endif

@php
    $applicationsText = old('applications_text', is_array($product->applications) ? implode(PHP_EOL, $product->applications) : '');
    $specificationsText = old('specifications_text', is_array($product->specifications) ? collect($product->specifications)->map(fn ($value, $key) => $key.': '.$value)->implode(PHP_EOL) : '');
@endphp

<div class="product-form">
    <section class="product-form-section">
        <div class="product-form-section-head">
            <span class="product-form-step">۱</span>
            <div>
                <h2>اطلاعات اصلی</h2>
                <p>عنوان، دسته‌بندی و توضیحات عمومی محصول را وارد کنید.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="title">عنوان محصول</label>
                <input id="title" name="title" value="{{ old('title', $product->title) }}" required placeholder="مثلا بیلت آلومینیوم 6063">
                @error('title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="slug">نامک انگلیسی</label>
                <input id="slug" name="slug" dir="ltr" value="{{ old('slug', $product->slug) }}" placeholder="aluminum-billet-6063">
                <span class="panel-help">در صورت خالی بودن، به صورت خودکار ساخته می‌شود.</span>
                @error('slug') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="product_category_id">دسته‌بندی</label>
                <select id="product_category_id" name="product_category_id">
                    <option value="">بدون دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('product_category_id', $product->product_category_id) === (string) $category->id)>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('product_category_id') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="sort_order">ترتیب نمایش</label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                @error('sort_order') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field is-wide">
                <label for="short_description">توضیح کوتاه</label>
                <textarea id="short_description" name="short_description" rows="3" placeholder="خلاصه‌ای کوتاه برای کارت محصول و معرفی سریع">{{ old('short_description', $product->short_description) }}</textarea>
                @error('short_description') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field is-wide">
                <label for="description">توضیحات کامل</label>
                <textarea id="description" name="description" rows="6" placeholder="توضیحات کامل محصول، ویژگی‌ها، مزیت‌ها و شرایط تامین">{{ old('description', $product->description) }}</textarea>
                @error('description') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    <section class="product-form-section">
        <div class="product-form-section-head">
            <span class="product-form-step">۲</span>
            <div>
                <h2>تصاویر محصول</h2>
                <p>تصویر اصلی و گالری را با پیش‌نمایش سریع مدیریت کنید.</p>
            </div>
        </div>

        <div class="upload-grid">
            <div class="upload-card">
                <div class="upload-card-head">
                    <div>
                        <h3>تصویر اصلی</h3>
                        <p>برای کارت محصول و صفحه جزئیات استفاده می‌شود.</p>
                    </div>
                    <x-panel.badge>JPG / PNG / WEBP</x-panel.badge>
                </div>

                @if ($product->featured_image)
                    <div class="current-image-card">
                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->title }}">
                        <label class="check-row">
                            <input type="checkbox" name="remove_featured_image" value="1">
                            <span>حذف تصویر فعلی هنگام ذخیره</span>
                        </label>
                    </div>
                @endif

                <label class="upload-dropzone" for="featured_image_file" data-upload-zone>
                    <input id="featured_image_file" name="featured_image_file" type="file" accept="image/jpeg,image/png,image/webp" data-preview-target="featured-preview">
                    <span class="upload-icon">+</span>
                    <strong>انتخاب تصویر اصلی</strong>
                    <small>حداکثر ۲ مگابایت</small>
                </label>

                <div class="upload-preview-grid single" id="featured-preview" aria-live="polite"></div>
                @error('featured_image_file') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="upload-card">
                <div class="upload-card-head">
                    <div>
                        <h3>گالری محصول</h3>
                        <p>برای نمایش چند نمای محصول در صفحه جزئیات.</p>
                    </div>
                    <x-panel.badge>حداکثر ۸ فایل</x-panel.badge>
                </div>

                @if ($product->gallery)
                    <div class="current-gallery-grid">
                        @foreach ($product->gallery as $galleryImage)
                            <label class="current-gallery-item">
                                <img src="{{ asset($galleryImage) }}" alt="{{ $product->title }}">
                                <span class="check-row">
                                    <input type="checkbox" name="remove_gallery_images[]" value="{{ $galleryImage }}">
                                    <span>حذف</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif

                <label class="upload-dropzone" for="gallery_files" data-upload-zone>
                    <input id="gallery_files" name="gallery_files[]" type="file" accept="image/jpeg,image/png,image/webp" multiple data-preview-target="gallery-preview">
                    <span class="upload-icon">+</span>
                    <strong>انتخاب تصاویر گالری</strong>
                    <small>هر تصویر حداکثر ۲ مگابایت</small>
                </label>

                <div class="upload-preview-grid" id="gallery-preview" aria-live="polite"></div>
                @error('gallery_files') <span class="error-text">{{ $message }}</span> @enderror
                @error('gallery_files.*') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    <section class="product-form-section">
        <div class="product-form-section-head">
            <span class="product-form-step">۳</span>
            <div>
                <h2>مشخصات سریع</h2>
                <p>این موارد در کارت‌ها و بخش مشخصات فنی محصول قابل نمایش هستند.</p>
            </div>
        </div>

        <div class="form-grid specs-grid">
            <div class="form-field">
                <label for="grade">گرید</label>
                <input id="grade" name="grade" value="{{ old('grade', $product->grade) }}" placeholder="6063">
                @error('grade') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="purity">خلوص</label>
                <input id="purity" name="purity" value="{{ old('purity', $product->purity) }}" placeholder="99.7%">
                @error('purity') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="weight">وزن</label>
                <input id="weight" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="بر اساس سفارش">
                @error('weight') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="dimensions">ابعاد</label>
                <input id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="بر اساس سفارش">
                @error('dimensions') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="packaging">بسته‌بندی</label>
                <input id="packaging" name="packaging" value="{{ old('packaging', $product->packaging) }}" placeholder="بندیل / پالت">
                @error('packaging') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="minimum_order_quantity">حداقل سفارش</label>
                <input id="minimum_order_quantity" name="minimum_order_quantity" value="{{ old('minimum_order_quantity', $product->minimum_order_quantity) }}" placeholder="مثلا ۱۰ تن">
                @error('minimum_order_quantity') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    <section class="product-form-section">
        <div class="product-form-section-head">
            <span class="product-form-step">۴</span>
            <div>
                <h2>جزئیات فنی و کاربردها</h2>
                <p>هر کاربرد را در یک خط و هر مشخصه فنی را با قالب کلید: مقدار وارد کنید.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="applications_text">کاربردها</label>
                <textarea id="applications_text" name="applications_text" rows="7" placeholder="اکستروژن پروفیل&#10;ریخته‌گری صنعتی">{{ $applicationsText }}</textarea>
                @error('applications_text') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="specifications_text">مشخصات فنی</label>
                <textarea id="specifications_text" name="specifications_text" rows="7" dir="ltr" placeholder="Grade: 6063&#10;Standard: ASTM">{{ $specificationsText }}</textarea>
                @error('specifications_text') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    <section class="product-form-section">
        <div class="product-form-section-head">
            <span class="product-form-step">۵</span>
            <div>
                <h2>نمایش و سئو</h2>
                <p>وضعیت انتشار، محصول ویژه و اطلاعات متای صفحه محصول را تنظیم کنید.</p>
            </div>
        </div>

        <div class="publish-options">
            <label class="toggle-card">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
                <span>
                    <strong>نمایش در سایت</strong>
                    <small>در صورت غیرفعال بودن، محصول در سایت عمومی نمایش داده نمی‌شود.</small>
                </span>
            </label>

            <label class="toggle-card">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
                <span>
                    <strong>محصول ویژه</strong>
                    <small>برای نمایش در بخش محصولات شاخص صفحه اصلی استفاده می‌شود.</small>
                </span>
            </label>
        </div>

        <div class="form-grid" style="margin-top: 16px;">
            <div class="form-field">
                <label for="meta_title">عنوان سئو</label>
                <input id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" placeholder="عنوان صفحه در گوگل">
                @error('meta_title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="meta_description">توضیح سئو</label>
                <textarea id="meta_description" name="meta_description" rows="4" placeholder="توضیح کوتاه برای نتایج جستجو">{{ old('meta_description', $product->meta_description) }}</textarea>
                @error('meta_description') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>
</div>

<x-panel.form-actions :back="route('panel.products.index')" />

@push('scripts')
    <script>
        document.querySelectorAll('input[type="file"][data-preview-target]').forEach((input) => {
            input.addEventListener('change', () => {
                const target = document.getElementById(input.dataset.previewTarget);

                if (!target) {
                    return;
                }

                target.innerHTML = '';

                Array.from(input.files || []).slice(0, 8).forEach((file) => {
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
