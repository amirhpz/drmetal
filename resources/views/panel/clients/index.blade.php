@extends('layouts.panel')

@section('title', 'مشتریان')
@section('heading', 'مشتریان')
@section('subtitle', 'مدیریت مشتریان و شرکای صنعتی نمایش داده‌شده در سایت')

@section('actions')
    <x-panel.button :href="route('panel.clients.create')" variant="primary">مشتری جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('panel.clients.index') }}" class="form-grid">
            <div class="form-field">
                <label for="q">جستجو</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" placeholder="نام، نام انگلیسی یا صنعت">
            </div>

            <div class="form-field">
                <label>&nbsp;</label>
                <div class="panel-actions">
                    <x-panel.button variant="primary" type="submit">جستجو</x-panel.button>
                    <x-panel.button :href="route('panel.clients.index')">حذف فیلتر</x-panel.button>
                </div>
            </div>
        </form>
    </x-panel.card>

    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>لوگو</th>
                        <th>نام</th>
                        <th>صنعت</th>
                        <th>ترتیب</th>
                        <th>نمایش</th>
                        <th>ویژه</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td>
                                @if ($client->logo)
                                    <img class="panel-thumb" src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
                                @else
                                    <x-panel.badge>{{ mb_substr($client->name, 0, 1) }}</x-panel.badge>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $client->name }}</strong>
                                @if ($client->english_name)
                                    <div class="panel-help" dir="ltr">{{ $client->english_name }}</div>
                                @endif
                            </td>
                            <td>{{ $client->industry ?: 'ثبت نشده' }}</td>
                            <td>{{ \App\Support\PersianNumber::digits($client->sort_order) }}</td>
                            <td>
                                <x-panel.badge :variant="$client->is_active ? 'success' : 'muted'">
                                    {{ $client->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <x-panel.badge :variant="$client->is_featured ? 'warning' : 'muted'">
                                    {{ $client->is_featured ? 'بله' : 'خیر' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.clients.edit', $client)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.clients.destroy', $client) }}" onsubmit="return confirm('این مشتری حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <x-panel.button variant="danger" type="submit">حذف</x-panel.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">هنوز مشتری ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $clients->links() }}</div>
    </x-panel.card>
@endsection
