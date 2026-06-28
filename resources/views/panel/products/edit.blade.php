@extends('layouts.panel')

@section('title', 'ویرایش محصول')
@section('heading', 'ویرایش محصول')
@section('subtitle', $product->title)

@section('content')
    <form class="product-editor-form" method="POST" action="{{ route('panel.products.update', $product) }}" enctype="multipart/form-data">
        @include('panel.products._form')
    </form>
@endsection
