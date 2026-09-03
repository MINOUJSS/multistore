@extends('layouts.admins.app')

@section('title', 'تعديل خطة المورد - لوحة التحكم')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.supplier_plans.edit')
@endsection
