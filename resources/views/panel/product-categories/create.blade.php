@extends('layouts.panel')

@section('title', 'دسته‌بندی جدید')
@section('heading', 'دسته‌بندی جدید')
@section('subtitle', 'ایجاد دسته‌بندی قابل استفاده برای محصولات')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.product-categories.store') }}">
        @include('panel.product-categories._form')
    </form>
@endsection
