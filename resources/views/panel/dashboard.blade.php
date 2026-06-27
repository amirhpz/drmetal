@extends('layouts.panel')

@section('title', 'داشبورد')
@section('heading', 'داشبورد')
@section('subtitle', 'نمای کلی محتوای عمومی سایت')

@section('content')
    <section class="panel-grid cols-5" style="margin-bottom: 18px;">
        <div class="panel-card">
            <strong>{{ $productCount }}</strong>
            <div class="panel-subtitle">محصول</div>
        </div>
        <div class="panel-card">
            <strong>{{ $categoryCount }}</strong>
            <div class="panel-subtitle">دسته‌بندی</div>
        </div>
        <div class="panel-card">
            <strong>{{ $serviceCount }}</strong>
            <div class="panel-subtitle">خدمت</div>
        </div>
        <div class="panel-card">
            <strong>{{ $newContactCount }}</strong>
            <div class="panel-subtitle">پیام جدید</div>
        </div>
        <div class="panel-card">
            <strong>{{ $newQuoteCount }}</strong>
            <div class="panel-subtitle">درخواست قیمت جدید</div>
        </div>
    </section>

    <section class="panel-card">
        <div class="panel-topbar" style="margin-bottom: 10px;">
            <h2 style="font-size: 1.2rem; margin: 0;">آخرین محصولات</h2>
            <a class="btn btn-primary" href="{{ route('panel.products.create') }}">محصول جدید</a>
        </div>

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
                            <span @class(['badge', 'badge-success' => $product->is_active, 'badge-muted' => ! $product->is_active])>
                                {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-muted" href="{{ route('panel.products.edit', $product) }}">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">هنوز محصولی ثبت نشده است.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
