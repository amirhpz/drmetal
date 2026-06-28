@extends('layouts.panel')

@section('title', 'داشبورد')
@section('heading', 'داشبورد')
@section('subtitle', 'نمای کلی محتوای عمومی سایت')

@section('content')
    <section class="panel-grid cols-6" style="margin-bottom: 18px;">
        <x-panel.stat :value="$productCount" label="محصول" />
        <x-panel.stat :value="$categoryCount" label="دسته‌بندی" />
        <x-panel.stat :value="$serviceCount" label="خدمت" />
        <x-panel.stat :value="$panelUserCount" label="کاربر پنل" />
        <x-panel.stat :value="$newContactCount" label="پیام جدید" />
        <x-panel.stat :value="$newQuoteCount" label="درخواست قیمت جدید" />
    </section>

    <x-panel.card>
        <x-panel.section-head title="آخرین محصولات">
            <x-panel.button :href="route('panel.products.create')" variant="primary">محصول جدید</x-panel.button>
        </x-panel.section-head>

        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>دسته‌بندی</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestProducts as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->category?->title ?? 'بدون دسته‌بندی' }}</td>
                            <td>
                                <x-panel.badge :variant="$product->is_active ? 'success' : 'muted'">
                                    {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <x-panel.button :href="route('panel.products.edit', $product)">ویرایش</x-panel.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">هنوز محصولی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>
    </x-panel.card>
@endsection
