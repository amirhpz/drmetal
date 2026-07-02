@extends('layouts.panel')

@section('title', 'پست‌ها')
@section('heading', 'پست‌ها')
@section('subtitle', 'مدیریت مقاله‌ها، اخبار و محتوای آموزشی سایت')

@section('actions')
    <x-panel.button :href="route('panel.posts.create')" variant="primary">پست جدید</x-panel.button>
@endsection

@section('content')
    <x-panel.card style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('panel.posts.index') }}" class="form-grid">
            <div class="form-field">
                <label for="q">جستجو</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" placeholder="عنوان، نامک یا دسته‌بندی">
            </div>

            <div class="form-field">
                <label for="status">وضعیت</label>
                <select id="status" name="status">
                    <option value="">همه پست‌ها</option>
                    <option value="active" @selected($filters['status'] === 'active')>فعال</option>
                    <option value="inactive" @selected($filters['status'] === 'inactive')>غیرفعال</option>
                    <option value="published" @selected($filters['status'] === 'published')>منتشرشده</option>
                    <option value="draft" @selected($filters['status'] === 'draft')>پیش‌نویس</option>
                    <option value="featured" @selected($filters['status'] === 'featured')>ویژه</option>
                </select>
            </div>

            <div class="form-field">
                <label for="post_category_id">دسته‌بندی</label>
                <select id="post_category_id" name="post_category_id">
                    <option value="">همه دسته‌بندی‌ها</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $filters['post_category_id'] === (string) $category->id)>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-field is-wide">
                <div class="panel-actions">
                    <x-panel.button variant="primary" type="submit">اعمال فیلتر</x-panel.button>
                    <x-panel.button :href="route('panel.posts.index')">حذف فیلتر</x-panel.button>
                </div>
            </div>
        </form>
    </x-panel.card>

    <x-panel.card>
        <x-panel.table-wrap>
            <table class="panel-table">
                <thead>
                    <tr>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>دسته‌بندی</th>
                        <th>انتشار</th>
                        <th>وضعیت</th>
                        <th>ویژه</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->featured_image)
                                    <img class="panel-thumb" src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <x-panel.badge>بدون تصویر</x-panel.badge>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                <div class="panel-help" dir="ltr">{{ $post->slug }}</div>
                            </td>
                            <td>{{ $post->postCategory?->title ?? ($post->category ?: 'بدون دسته‌بندی') }}</td>
                            <td>
                                @if ($post->published_at)
                                    {{ \App\Support\PersianNumber::digits($post->published_at->format('Y-m-d H:i')) }}
                                @else
                                    <x-panel.badge>پیش‌نویس</x-panel.badge>
                                @endif
                            </td>
                            <td>
                                <x-panel.badge :variant="$post->is_active ? 'success' : 'muted'">
                                    {{ $post->is_active ? 'فعال' : 'غیرفعال' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <x-panel.badge :variant="$post->is_featured ? 'warning' : 'muted'">
                                    {{ $post->is_featured ? 'بله' : 'خیر' }}
                                </x-panel.badge>
                            </td>
                            <td>
                                <div class="panel-actions">
                                    <x-panel.button :href="route('panel.posts.edit', $post)">ویرایش</x-panel.button>
                                    <form method="POST" action="{{ route('panel.posts.destroy', $post) }}" onsubmit="return confirm('این پست حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <x-panel.button variant="danger" type="submit">حذف</x-panel.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">هنوز پستی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-panel.table-wrap>

        <div class="pagination">{{ $posts->links() }}</div>
    </x-panel.card>
@endsection
