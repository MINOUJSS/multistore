@extends('layouts.admins.app')

@section('title', 'تفاصيل وإدارة خطة البائع - لوحة التحكم')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.seller_plans.show')
@endsection
