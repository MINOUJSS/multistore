@extends('layouts.admins.app')

@section('title')
    {{ __('إدارة الحسابات البنكية للمنصة') }}
@endsection

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.bank_accounts.index')
@endsection
