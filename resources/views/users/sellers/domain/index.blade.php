@extends('layouts.users.dashboard.app')

@section('title')
  إدارة الدومين المخصص
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
    @include('users.sellers.components.content.domain.index')
@endsection
