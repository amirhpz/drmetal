@csrf
@if ($category->exists)
    @method('PUT')
@endif

<div class="form-grid">
    <div class="form-field">
        <label for="title">عنوان</label>
        <input id="title" name="title" value="{{ old('title', $category->title) }}" required>
        @error('title') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="slug">نامک انگلیسی</label>
        <input id="slug" name="slug" dir="ltr" value="{{ old('slug', $category->slug) }}" placeholder="aluminum-ingots">
        @error('slug') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="description">توضیحات</label>
        <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
        @error('description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="sort_order">ترتیب نمایش</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
        @error('sort_order') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label class="check-row">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
            <span>نمایش در سایت</span>
        </label>
    </div>

    <div class="form-field">
        <label for="meta_title">عنوان سئو</label>
        <input id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}">
        @error('meta_title') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="meta_description">توضیح سئو</label>
        <textarea id="meta_description" name="meta_description">{{ old('meta_description', $category->meta_description) }}</textarea>
        @error('meta_description') <span class="error-text">{{ $message }}</span> @enderror
    </div>
</div>

<x-panel.form-actions :back="route('panel.product-categories.index')" />
