@extends('layouts.panel')

@section('title', 'محصول جدید')
@section('heading', 'محصول جدید')
@section('subtitle', 'ایجاد محصول برای نمایش عمومی سایت')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.products.store') }}" enctype="multipart/form-data">
        @include('panel.products._form')
    </form>
@endsection
