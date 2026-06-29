@extends('layouts.panel')

@section('title', 'ویرایش پست')
@section('heading', 'ویرایش پست')
@section('subtitle', $post->title)

@section('content')
    <form class="post-editor-form" method="POST" action="{{ route('panel.posts.update', $post) }}" enctype="multipart/form-data">
        @include('panel.posts._form')
    </form>
@endsection
