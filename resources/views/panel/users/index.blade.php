@extends('layouts.panel')

@section('title', 'کاربران پنل')
@section('heading', 'کاربران پنل')
@section('subtitle', 'مدیریت کاربران و دسترسی ورود به پنل مدیریت')

@section('actions')
    <a class="btn btn-primary" href="{{ route('panel.users.create') }}">کاربر جدید</a>
@endsection

@section('content')
    <section class="panel-card" style="margin-bottom: 16px;">
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
                    <button class="btn btn-primary" type="submit">اعمال فیلتر</button>
                    <a class="btn btn-muted" href="{{ route('panel.users.index') }}">حذف فیلتر</a>
                </div>
            </div>
        </form>
    </section>

    <section class="panel-card">
        <div class="panel-help" style="margin-bottom: 12px;">
            تعداد کاربران دارای دسترسی پنل: {{ $panelUserCount }}
        </div>

        <table class="panel-table">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>دسترسی پنل</th>
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
                                <span class="badge badge-muted">حساب فعلی</span>
                            @endif
                        </td>
                        <td dir="ltr">{{ $user->email }}</td>
                        <td>
                            <span @class(['badge', 'badge-success' => $user->is_panel_user, 'badge-muted' => ! $user->is_panel_user])>
                                {{ $user->is_panel_user ? 'دارد' : 'ندارد' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                        <td>
                            <div class="panel-actions">
                                <a class="btn btn-muted" href="{{ route('panel.users.edit', $user) }}">ویرایش</a>
                                <form method="POST" action="{{ route('panel.users.destroy', $user) }}" onsubmit="return confirm('این کاربر حذف شود؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" @disabled(auth()->user()->is($user))>حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">کاربری با این فیلتر پیدا نشد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">{{ $users->links() }}</div>
    </section>
@endsection
