@extends('layouts.admins.app')

@section('title', 'إضافة خطة بائع جديدة - لوحة التحكم')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.seller_plans.create')
@endsection
