@extends('layouts.panel')

@section('title', 'دسته‌بندی محصولات')
@section('heading', 'دسته‌بندی محصولات')
@section('subtitle', 'مدیریت گروه‌های محصولات برای نمایش عمومی سایت')

@section('actions')
    <a class="btn btn-primary" href="{{ route('panel.product-categories.create') }}">دسته‌بندی جدید</a>
@endsection

@section('content')
    <section class="panel-card">
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
                            <span @class(['badge', 'badge-success' => $category->is_active, 'badge-muted' => ! $category->is_active])>
                                {{ $category->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <div class="panel-actions">
                                <a class="btn btn-muted" href="{{ route('panel.product-categories.edit', $category) }}">ویرایش</a>
                                <form method="POST" action="{{ route('panel.product-categories.destroy', $category) }}" onsubmit="return confirm('این دسته‌بندی حذف شود؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">حذف</button>
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

        <div class="pagination">{{ $categories->links() }}</div>
    </section>
@endsection
