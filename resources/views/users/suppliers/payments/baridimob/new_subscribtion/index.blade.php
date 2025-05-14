@extends('layouts.users.dashboard.app')

{{-- @section('css')
    <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/order-plan-step.css">
@endsection --}}

{{-- @section('header_js')
    <script type="text/javascript" src="{{asset('asset/users/dashboard')}}/js/order-plan-step.js"></script>
@endsection --}}

@section('title')
    الدفع عن طريق baridimob
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
 @include('users.suppliers.components.content.payments.baridimob.new_subscribtion.index')
@endsection

{{-- @section('footer_js')
    @include('users.suppliers.components.content.subscription.confirmation_js')
@endsection --}}