@extends('layouts.users.dashboard.app')

@section('title')
    دفع الاشتراك
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
@include('users.suppliers.components.content.subscription.order_plan.checkoute')
@endsection