@csrf
@if ($user->exists)
    @method('PUT')
@endif

<div class="form-grid">
    <div class="form-field">
        <label for="name">نام</label>
        <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="email">ایمیل</label>
        <input id="email" name="email" type="email" dir="ltr" value="{{ old('email', $user->email) }}" required>
        @error('email') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="password">رمز عبور{{ $user->exists ? ' جدید' : '' }}</label>
        <input id="password" name="password" type="password" autocomplete="new-password" @required(! $user->exists)>
        @if ($user->exists)
            <span class="panel-help">اگر نمی‌خواهید رمز عبور تغییر کند، این فیلد را خالی بگذارید.</span>
        @endif
        @error('password') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="password_confirmation">تکرار رمز عبور</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" @required(! $user->exists)>
    </div>

    <div class="form-field is-wide">
        <label class="check-row">
            <input type="checkbox" name="is_panel_user" value="1" @checked(old('is_panel_user', $user->is_panel_user ?? true)) @disabled(auth()->user()->is($user))>
            <span>اجازه ورود به پنل مدیریت</span>
        </label>

        @if (auth()->user()->is($user))
            <input type="hidden" name="is_panel_user" value="1">
            <span class="panel-help">برای جلوگیری از قفل شدن پنل، دسترسی حساب فعلی از همین فرم قابل حذف نیست.</span>
        @else
            <span class="panel-help">با غیرفعال کردن این گزینه، کاربر همچنان در جدول کاربران باقی می‌ماند اما دیگر نمی‌تواند وارد پنل شود.</span>
        @endif

        @error('is_panel_user') <span class="error-text">{{ $message }}</span> @enderror
    </div>
</div>

<div class="panel-actions" style="margin-top: 18px;">
    <button class="btn btn-primary" type="submit">ذخیره</button>
    <a class="btn btn-muted" href="{{ route('panel.users.index') }}">بازگشت</a>
</div>
