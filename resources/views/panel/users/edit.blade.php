@extends('layouts.panel')

@section('title', 'ویرایش کاربر')
@section('heading', 'ویرایش کاربر')
@section('subtitle', 'ویرایش اطلاعات کاربر، رمز عبور و دسترسی پنل')

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.users.update', $user) }}">
        @include('panel.users._form')
    </form>
@endsection
