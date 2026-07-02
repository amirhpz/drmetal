@extends('layouts.panel')

@section('title', 'درخواست‌های قیمت')
@section('heading', 'درخواست‌های قیمت')
@section('subtitle', 'پیگیری درخواست‌های ثبت‌شده از صفحه محصولات')

@section('content')
    <x-panel.card style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('panel.quote-requests.index') }}" class="form-grid">
            <div class="form-field">
                <label for="q">جستجو</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" placeholder="نام، شرکت، تلفن یا محصول">
            </div>

            <div class="form-field">
                <label for="status">وضعیت</label>
                <select id="status" name="status">
                    <option value="">همه وضعیت‌ها</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-field is-wide">
                <div class="panel-actions">
                    <x-panel.button variant="primary" type="submit">اعمال فیلتر</x-panel.button>
                    <x-panel.button :href="route('panel.quote-requests.index')">حذف فیلتر</x-panel.button>
                </div>
            </div>
        </form>
    </x-panel.card>

    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>درخواست‌دهنده</th>
                        <th>محصول</th>
                        <th>مقدار</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quoteRequests as $quoteRequest)
                        <tr>
                            <td>
                                <strong>{{ $quoteRequest->contact_person }}</strong>
                                <div class="panel-help">{{ $quoteRequest->company_name ?: 'بدون نام شرکت' }} / {{ $quoteRequest->phone }}</div>
                            </td>
                            <td>{{ $quoteRequest->product?->title ?? 'محصول حذف شده' }}</td>
                            <td>{{ $quoteRequest->quantity ?: 'ثبت نشده' }}</td>
                            <td>
                                <x-panel.badge :variant="$quoteRequest->status === 'new' ? 'warning' : 'muted'">
                                    {{ $quoteRequest->statusLabel() }}
                                </x-panel.badge>
                            </td>
                            <td>{{ \App\Support\PersianNumber::digits($quoteRequest->created_at->format('Y-m-d H:i')) }}</td>
                            <td>
                                <x-panel.button :href="route('panel.quote-requests.show', $quoteRequest)">مشاهده</x-panel.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">هنوز درخواست قیمتی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $quoteRequests->links() }}</div>
    </x-panel.card>
@endsection
