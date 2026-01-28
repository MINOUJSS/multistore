@extends('layouts.users.dashboard.app')

{{-- @section('css')
    <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/order-plan-step.css">
@endsection --}}

{{-- @section('header_js')
    <script type="text/javascript" src="{{asset('asset/users/dashboard')}}/js/order-plan-step.js"></script>
@endsection --}}

@section('title')
    الدفع عن طريق رصيدي في المنصة
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
 @include('users.sellers.components.content.payments.wallet.index')
@endsection