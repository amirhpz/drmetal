@csrf
@if ($post->exists)
    @method('PUT')
@endif

@php($publishedAtValue = old('published_at', $post->published_at?->format('Y-m-d\TH:i')))
@php($bodyValue = old('body', $post->body))
@php($editorBody = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/iu', '', strip_tags($bodyValue ?? '', '<p><br><strong><b><em><i><u><h2><h3><ul><ol><li><blockquote><a>')))
@php($selectedCategoryId = old('post_category_id', $post->post_category_id ?: $categories->firstWhere('title', $post->category)?->id))

<div class="product-form post-form">
    <section class="product-form-section post-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>اطلاعات اصلی پست</h2>
                <p>عنوان، نامک و دسته‌بندی مقاله را تنظیم کنید.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="title">عنوان پست</label>
                <input id="title" name="title" value="{{ old('title', $post->title) }}" required placeholder="مثلا نقش کنترل ترکیب شیمیایی در کیفیت آلومینیوم">
                @error('title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="slug">نامک انگلیسی</label>
                <input id="slug" name="slug" dir="ltr" value="{{ old('slug', $post->slug) }}" placeholder="aluminum-quality-control">
                <span class="panel-help">در صورت خالی بودن، به صورت خودکار ساخته می‌شود.</span>
                @error('slug') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="post_category_id">دسته‌بندی</label>
                <select id="post_category_id" name="post_category_id">
                    <option value="">بدون دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $selectedCategoryId === (string) $category->id)>{{ $category->title }}</option>
                    @endforeach
                </select>
                <span class="panel-help">
                    دسته‌بندی‌ها از بخش
                    <a href="{{ route('panel.post-categories.index') }}">دسته‌بندی مقالات</a>
                    مدیریت می‌شوند.
                </span>
                @error('post_category_id') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="author_name">نویسنده</label>
                <input id="author_name" name="author_name" value="{{ old('author_name', $post->author_name) }}" placeholder="تیم دکتر متال">
                @error('author_name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field is-wide">
                <label for="excerpt">خلاصه پست</label>
                <textarea id="excerpt" name="excerpt" rows="3" placeholder="خلاصه کوتاه برای کارت یا معرفی پست">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    <section class="product-form-section post-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>متن کامل</h2>
                <p>برای تیتر، لیست، نقل‌قول و لینک از ابزارهای ادیتور استفاده کنید.</p>
            </div>
        </div>

        <div class="post-rich-editor" data-quill-editor>
            <div data-quill-surface data-placeholder="متن کامل مقاله یا خبر را وارد کنید"></div>
            <textarea id="body" name="body" data-quill-input>{{ $editorBody }}</textarea>
        </div>
        @error('body') <span class="error-text">{{ $message }}</span> @enderror
    </section>

    <section class="product-form-section post-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>تصویر شاخص</h2>
                <p>تصویر شاخص برای فهرست پست‌ها و نمایش عمومی آینده استفاده می‌شود.</p>
            </div>
        </div>

        <div class="upload-card">
            <div class="upload-card-head">
                <div>
                    <h3>آپلود تصویر پست</h3>
                    <p>تصویر صنعتی، فنی یا مرتبط با موضوع پست انتخاب کنید.</p>
                </div>
                <x-panel.badge>JPG / PNG / WEBP</x-panel.badge>
            </div>

            @if ($post->featured_image)
                <div class="current-image-card">
                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                    <label class="check-row">
                        <input type="checkbox" name="remove_featured_image" value="1">
                        <span>حذف تصویر فعلی هنگام ذخیره</span>
                    </label>
                </div>
            @endif

            <label class="upload-dropzone" for="featured_image_file" data-upload-zone>
                <input id="featured_image_file" name="featured_image_file" type="file" accept="image/jpeg,image/png,image/webp" data-preview-target="post-featured-preview">
                <span class="upload-icon">+</span>
                <strong>انتخاب تصویر شاخص</strong>
                <small>حداکثر ۲ مگابایت</small>
            </label>

            <div class="upload-preview-grid single" id="post-featured-preview" aria-live="polite"></div>
            @error('featured_image_file') <span class="error-text">{{ $message }}</span> @enderror
        </div>
    </section>

    <section class="product-form-section post-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>انتشار و نمایش</h2>
                <p>زمان انتشار، وضعیت نمایش و جایگاه پست را تنظیم کنید.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="published_at">تاریخ و زمان انتشار</label>
                <input id="published_at" name="published_at" type="datetime-local" value="{{ $publishedAtValue }}">
                <span class="panel-help">اگر خالی بماند، پست پیش‌نویس محسوب می‌شود.</span>
                @error('published_at') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="sort_order">ترتیب نمایش</label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}">
                @error('sort_order') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="publish-options" style="margin-top: 16px;">
            <label class="toggle-card">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $post->is_active ?? true))>
                <span>
                    <strong>فعال</strong>
                    <small>در صورت غیرفعال بودن، پست در نمایش عمومی آینده دیده نمی‌شود.</small>
                </span>
            </label>

            <label class="toggle-card">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured ?? false))>
                <span>
                    <strong>پست ویژه</strong>
                    <small>برای نمایش در بخش‌های شاخص آینده استفاده می‌شود.</small>
                </span>
            </label>
        </div>
    </section>

    <section class="product-form-section post-form-section">
        <div class="product-form-section-head compact">
            <div>
                <h2>سئو</h2>
                <p>عنوان و توضیحات متا برای آماده‌سازی نمایش عمومی پست.</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label for="meta_title">عنوان سئو</label>
                <input id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" placeholder="عنوان صفحه در گوگل">
                @error('meta_title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="meta_description">توضیح سئو</label>
                <textarea id="meta_description" name="meta_description" rows="4" placeholder="توضیح کوتاه برای نتایج جستجو">{{ old('meta_description', $post->meta_description) }}</textarea>
                @error('meta_description') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>
</div>

<x-panel.form-actions :back="route('panel.posts.index')" />

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
