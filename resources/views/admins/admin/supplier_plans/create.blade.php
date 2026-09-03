@extends('layouts.admins.app')

@section('title', 'إضافة خطة مورد جديدة - لوحة التحكم')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.supplier_plans.create')
@endsection
