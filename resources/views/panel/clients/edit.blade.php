@extends('layouts.panel')

@section('title', 'ویرایش مشتری')
@section('heading', 'ویرایش مشتری')
@section('subtitle', $client->name)

@section('content')
    <form method="POST" action="{{ route('panel.clients.update', $client) }}" enctype="multipart/form-data">
        @include('panel.clients._form')
    </form>
@endsection
