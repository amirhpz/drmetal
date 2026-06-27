@extends('layouts.panel')

@section('title', 'ویرایش دسته‌بندی')
@section('heading', 'ویرایش دسته‌بندی')
@section('subtitle', $category->title)

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.product-categories.update', $category) }}">
        @include('panel.product-categories._form')
    </form>
@endsection
