@extends('layouts.panel')

@section('title', 'محصولات')
@section('heading', 'محصولات')
@section('subtitle', 'مدیریت محصولات قابل نمایش در وب‌سایت')

@section('actions')
    <a class="btn btn-primary" href="{{ route('panel.products.create') }}">محصول جدید</a>
@endsection

@section('content')
    <section class="panel-card">
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
                                <span class="badge badge-muted">بدون تصویر</span>
                            @endif
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category?->title ?? 'بدون دسته‌بندی' }}</td>
                        <td dir="ltr">{{ $product->slug }}</td>
                        <td>{{ $product->is_featured ? 'بله' : 'خیر' }}</td>
                        <td>
                            <span @class(['badge', 'badge-success' => $product->is_active, 'badge-muted' => ! $product->is_active])>
                                {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <div class="panel-actions">
                                <a class="btn btn-muted" href="{{ route('panel.products.edit', $product) }}">ویرایش</a>
                                <form method="POST" action="{{ route('panel.products.destroy', $product) }}" onsubmit="return confirm('این محصول حذف شود؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">حذف</button>
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

        <div class="pagination">{{ $products->links() }}</div>
    </section>
@endsection
