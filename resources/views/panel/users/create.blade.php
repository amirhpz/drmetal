@extends('layouts.panel')

@section('title', 'کاربر جدید')
@section('heading', 'کاربر جدید')
@section('subtitle', 'ایجاد کاربر و تعیین دسترسی پنل')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.users.store') }}">
        @include('panel.users._form')
    </form>
@endsection
