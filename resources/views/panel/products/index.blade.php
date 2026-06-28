@extends('layouts.panel')

@section('title', 'محصولات')
@section('heading', 'محصولات')
@section('subtitle', 'مدیریت محصولات قابل نمایش در وب‌سایت')

@section('actions')
    <x-panel.button :href="route('panel.products.create')" variant="primary">محصول جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>دسته‌بندی</th>
                        <th>نامک</th>
                        <th>ویژه</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if ($product->featured_image)
                                    <img class="panel-thumb" src="{{ asset($product->featured_image) }}" alt="{{ $product->title }}">
                                @else
                                    <x-panel.badge>بدون تصویر</x-panel.badge>
                                @endif
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->category?->title ?? 'بدون دسته‌بندی' }}</td>
                            <td dir="ltr">{{ $product->slug }}</td>
                            <td>
                                <x-panel.badge :variant="$product->is_featured ? 'warning' : 'muted'">
                                    {{ $product->is_featured ? 'بله' : 'خیر' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <x-panel.badge :variant="$product->is_active ? 'success' : 'muted'">
                                    {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.products.edit', $product)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.products.destroy', $product) }}" onsubmit="return confirm('این محصول حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <x-panel.button variant="danger" type="submit">حذف</x-panel.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">هنوز محصولی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $products->links() }}</div>
    </x-panel.card>
@endsection
