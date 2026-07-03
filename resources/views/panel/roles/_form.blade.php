@csrf
@if ($role->exists)
    @method('PUT')
@endif

@php($selectedPermissions = old('permissions', $role->permissions ?? []))

<div class="form-grid">
    <div class="form-field">
        <label for="name">عنوان سطح دسترسی</label>
        <input id="name" name="name" value="{{ old('name', $role->name) }}" required placeholder="مثلا مدیر محتوا">
        @error('name') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="slug">نامک انگلیسی</label>
        <input id="slug" name="slug" dir="ltr" value="{{ old('slug', $role->slug) }}" placeholder="content-manager">
        @error('slug') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field is-wide">
        <label for="description">توضیحات</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
        @error('description') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="sort_order">ترتیب نمایش</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $role->sort_order ?? 0) }}">
        @error('sort_order') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label class="check-row">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $role->is_active ?? true))>
            <span>فعال</span>
        </label>
    </div>

    <div class="form-field is-wide">
        <label>بخش‌های قابل دسترسی</label>
        <div class="permission-grid">
            @foreach ($permissions as $key => $permission)
                <label class="permission-card">
                    <input type="checkbox" name="permissions[]" value="{{ $key }}" @checked(in_array($key, $selectedPermissions, true))>
                    <span>
                        <strong>{{ $permission['label'] }}</strong>
                        <small>{{ $permission['description'] }}</small>
                    </span>
                </label>
            @endforeach
        </div>
        @error('permissions') <span class="error-text">{{ $message }}</span> @enderror
        @error('permissions.*') <span class="error-text">{{ $message }}</span> @enderror
    </div>
</div>

<x-panel.form-actions :back="route('panel.roles.index')" />
