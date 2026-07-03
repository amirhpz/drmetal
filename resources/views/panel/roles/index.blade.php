@extends('layouts.panel')

@section('title', 'سطوح دسترسی')
@section('heading', 'سطوح دسترسی')
@section('subtitle', 'تعریف نقش‌های قابل اختصاص به کاربران پنل')

@section('actions')
    <x-panel.button :href="route('panel.roles.create')" variant="primary">سطح دسترسی جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>نامک</th>
                        <th>دسترسی‌ها</th>
                        <th>کاربران</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>
                                <strong>{{ $role->name }}</strong>
                                @if ($role->description)
                                    <div class="panel-help">{{ $role->description }}</div>
                                @endif
                            </td>
                            <td dir="ltr">{{ $role->slug }}</td>
                            <td>{{ \App\Support\PersianNumber::digits(count($role->permissions ?? [])) }} دسترسی</td>
                            <td>{{ \App\Support\PersianNumber::digits($role->users_count) }}</td>
                            <td>
                                <x-panel.badge :variant="$role->is_active ? 'success' : 'muted'">
                                    {{ $role->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.roles.edit', $role)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.roles.destroy', $role) }}" onsubmit="return confirm('این سطح دسترسی حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <x-panel.button variant="danger" type="submit">حذف</x-panel.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">هنوز سطح دسترسی تعریف نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $roles->links() }}</div>
    </x-panel.card>
@endsection
