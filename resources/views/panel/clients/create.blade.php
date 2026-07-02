@extends('layouts.panel')

@section('title', 'مشتری جدید')
@section('heading', 'مشتری جدید')
@section('subtitle', 'افزودن مشتری یا شریک صنعتی')

@section('content')
    <form method="POST" action="{{ route('panel.clients.store') }}" enctype="multipart/form-data">
        @include('panel.clients._form')
    </form>
@endsection
