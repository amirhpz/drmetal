@extends('layouts.panel')

@section('title', 'دسته‌بندی محصولات')
@section('heading', 'دسته‌بندی محصولات')
@section('subtitle', 'مدیریت گروه‌های محصولات برای نمایش عمومی سایت')

@section('actions')
    <x-panel.button :href="route('panel.product-categories.create')" variant="primary">دسته‌بندی جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>نامک</th>
                        <th>محصولات</th>
                        <th>ترتیب</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td dir="ltr">{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                <x-panel.badge :variant="$category->is_active ? 'success' : 'muted'">
                                    {{ $category->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.product-categories.edit', $category)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.product-categories.destroy', $category) }}" onsubmit="return confirm('این دسته‌بندی حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <x-panel.button variant="danger" type="submit">حذف</x-panel.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">هنوز دسته‌بندی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $categories->links() }}</div>
    </x-panel.card>
@endsection
