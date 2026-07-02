@extends('layouts.panel')

@section('title', 'دسته‌بندی مقاله جدید')
@section('heading', 'دسته‌بندی مقاله جدید')
@section('subtitle', 'ایجاد دسته‌بندی قابل استفاده برای پست‌ها و مقالات')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.post-categories.store') }}">
        @include('panel.post-categories._form')
    </form>
@endsection
