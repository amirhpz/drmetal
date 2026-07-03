@extends('layouts.panel')

@section('title', 'سطح دسترسی جدید')
@section('heading', 'سطح دسترسی جدید')
@section('subtitle', 'انتخاب بخش‌های قابل دسترسی برای این نقش')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.roles.store') }}">
        @include('panel.roles._form')
    </form>
@endsection
