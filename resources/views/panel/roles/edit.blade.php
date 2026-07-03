@extends('layouts.panel')

@section('title', 'ویرایش سطح دسترسی')
@section('heading', 'ویرایش سطح دسترسی')
@section('subtitle', $role->name)

@section('content')
    <form class="panel-card" method="POST" action="{{ route('panel.roles.update', $role) }}">
        @include('panel.roles._form')
    </form>
@endsection
