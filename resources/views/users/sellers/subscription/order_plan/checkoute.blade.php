@extends('layouts.users.dashboard.app')

@section('title')
    دفع الاشتراك
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
@include('users.sellers.components.content.subscription.order_plan.checkoute')
@endsection