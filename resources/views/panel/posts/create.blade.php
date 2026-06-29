@extends('layouts.panel')

@section('title', 'پست جدید')
@section('heading', 'پست جدید')
@section('subtitle', 'ایجاد مقاله، خبر یا محتوای آموزشی')

@section('content')
    <form class="post-editor-form" method="POST" action="{{ route('panel.posts.store') }}" enctype="multipart/form-data">
        @include('panel.posts._form')
    </form>
@endsection
