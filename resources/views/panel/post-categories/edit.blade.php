@extends('layouts.panel')

@section('title', 'ویرایش دسته‌بندی مقاله')
@section('heading', 'ویرایش دسته‌بندی مقاله')
@section('subtitle', $category->title)

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.post-categories.update', $category) }}">
        @include('panel.post-categories._form')
    </form>
@endsection
