@extends('layouts.users.store.app')
@section('title')
    {{ tenant('domain') }} | التصنيفات
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
    @if (has_seller_settings(tenant('id')))
        @include('stores.sellers.theme.all')
    @endif
@endsection
@section('navbar')
    @include('stores.sellers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.sellers.components.cart.v1.cart')
@endsection

@section('content')
    @include('stores.sellers.components.content.checkout.index')
@endsection

@section('footer_js')
    @include('stores.sellers.components.navbar.js.navbar_js');
    @include('stores.sellers.components.content.checkout.js.index-js');
    @include('stores.sellers.components.content.checkout.js.coupon_js');
    @include('stores.sellers.components.content.checkout.js.device_fingerprint_js');
@endsection
