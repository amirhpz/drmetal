@extends('layouts.panel')

@section('title', 'کاربران پنل')
@section('heading', 'کاربران پنل')
@section('subtitle', 'مدیریت کاربران و دسترسی ورود به پنل مدیریت')

@section('actions')
    <x-panel.button :href="route('panel.users.create')" variant="primary">کاربر جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('panel.users.index') }}" class="form-grid">
            <div class="form-field">
                <label for="q">جستجو</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" placeholder="نام یا ایمیل">
            </div>

            <div class="form-field">
                <label for="access">نوع دسترسی</label>
                <select id="access" name="access">
                    <option value="">همه کاربران</option>
                    <option value="panel" @selected($filters['access'] === 'panel')>دارای دسترسی پنل</option>
                    <option value="regular" @selected($filters['access'] === 'regular')>بدون دسترسی پنل</option>
                </select>
            </div>

            <div class="form-field is-wide">
                <div class="panel-actions">
                    <x-panel.button variant="primary" type="submit">اعمال فیلتر</x-panel.button>
                    <x-panel.button :href="route('panel.users.index')">حذف فیلتر</x-panel.button>
                </div>
            </div>
        </form>
    </x-panel.card>

    <x-panel.card>
        <div class="panel-help" style="margin-bottom: 12px;">
            تعداد کاربران دارای دسترسی پنل: {{ $panelUserCount }}
        </div>

        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>دسترسی پنل</th>
                        <th>سطح دسترسی</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                                @if (auth()->user()->is($user))
                                    <x-panel.badge>حساب فعلی</x-panel.badge>
                                @endif
                            </td>
                            <td dir="ltr">{{ $user->email }}</td>
                            <td>
                                <x-panel.badge :variant="$user->is_panel_user ? 'success' : 'muted'">
                                    {{ $user->is_panel_user ? 'دارد' : 'ندارد' }}
                                </x-panel.badge>
                            </td>
                            <td>{{ $user->panelRole?->name ?? ($user->is_panel_user ? 'دسترسی کامل' : 'ندارد') }}</td>
                            <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.users.edit', $user)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.users.destroy', $user) }}" onsubmit="return confirm('این کاربر حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" @if (auth()->user()->is($user)) disabled @endif>حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">کاربری با این فیلتر پیدا نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $users->links() }}</div>
    </x-panel.card>
@endsection
