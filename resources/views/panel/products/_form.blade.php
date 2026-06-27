@csrf
@if ($product->exists)
    @method('PUT')
@endif

@php
    $applicationsText = old('applications_text', is_array($product->applications) ? implode(PHP_EOL, $product->applications) : '');
    $specificationsText = old('specifications_text', is_array($product->specifications) ? collect($product->specifications)->map(fn ($value, $key) => $key.': '.$value)->implode(PHP_EOL) : '');
@endphp

<div class="form-grid">
    <div class="form-field">
        <label for="title">عنوان</label>
        <input id="title" name="title" value="{{ old('title', $product->title) }}" required>
        @error('title') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="slug">نامک انگلیسی</label>
        <input id="slug" name="slug" dir="ltr" value="{{ old('slug', $product->slug) }}" placeholder="aluminum-ingot-99-7">
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
        <textarea id="short_description" name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
        @error('short_description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="description">توضیحات کامل</label>
        <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
        @error('description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="featured_image_file">تصویر اصلی محصول</label>
        @if ($product->featured_image)
            <div class="image-preview-row">
                <img src="{{ asset($product->featured_image) }}" alt="{{ $product->title }}">
                <label class="check-row">
                    <input type="checkbox" name="remove_featured_image" value="1">
                    <span>حذف تصویر اصلی فعلی</span>
                </label>
            </div>
        @endif
        <input id="featured_image_file" name="featured_image_file" type="file" accept="image/jpeg,image/png,image/webp">
        <small class="panel-help">فرمت‌های مجاز: JPG، PNG، WEBP. حداکثر حجم فعلی: ۲ مگابایت.</small>
        @error('featured_image_file') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="gallery_files">گالری محصول</label>
        @if ($product->gallery)
            <div class="gallery-preview-grid">
                @foreach ($product->gallery as $galleryImage)
                    <label>
                        <img src="{{ asset($galleryImage) }}" alt="{{ $product->title }}">
                        <span class="check-row">
                            <input type="checkbox" name="remove_gallery_images[]" value="{{ $galleryImage }}">
                            <span>حذف</span>
                        </span>
                    </label>
                @endforeach
            </div>
        @endif
        <input id="gallery_files" name="gallery_files[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
        <small class="panel-help">حداکثر ۸ تصویر در هر بار بارگذاری. حجم هر تصویر حداکثر ۲ مگابایت است.</small>
        @error('gallery_files') <span class="error-text">{{ $message }}</span> @enderror
        @error('gallery_files.*') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="grade">گرید</label>
        <input id="grade" name="grade" value="{{ old('grade', $product->grade) }}">
        @error('grade') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="purity">خلوص</label>
        <input id="purity" name="purity" value="{{ old('purity', $product->purity) }}">
        @error('purity') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="weight">وزن</label>
        <input id="weight" name="weight" value="{{ old('weight', $product->weight) }}">
        @error('weight') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="dimensions">ابعاد</label>
        <input id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}">
        @error('dimensions') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="packaging">بسته‌بندی</label>
        <input id="packaging" name="packaging" value="{{ old('packaging', $product->packaging) }}">
        @error('packaging') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="minimum_order_quantity">حداقل سفارش</label>
        <input id="minimum_order_quantity" name="minimum_order_quantity" value="{{ old('minimum_order_quantity', $product->minimum_order_quantity) }}">
        @error('minimum_order_quantity') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="applications_text">کاربردها، هر خط یک مورد</label>
        <textarea id="applications_text" name="applications_text">{{ $applicationsText }}</textarea>
        @error('applications_text') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="specifications_text">مشخصات فنی، هر خط با قالب کلید: مقدار</label>
        <textarea id="specifications_text" name="specifications_text" dir="ltr">{{ $specificationsText }}</textarea>
        @error('specifications_text') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label class="check-row">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
            <span>نمایش در سایت</span>
        </label>
    </div>

    <div class="form-field">
        <label class="check-row">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
            <span>محصول ویژه</span>
        </label>
    </div>

    <div class="form-field">
        <label for="meta_title">عنوان سئو</label>
        <input id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
        @error('meta_title') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="meta_description">توضیح سئو</label>
        <textarea id="meta_description" name="meta_description">{{ old('meta_description', $product->meta_description) }}</textarea>
        @error('meta_description') <span class="error-text">{{ $message }}</span> @enderror
    </div>
</div>

<div class="panel-actions" style="margin-top: 18px;">
    <button class="btn btn-primary" type="submit">ذخیره</button>
    <a class="btn btn-muted" href="{{ route('panel.products.index') }}">بازگشت</a>
</div>
