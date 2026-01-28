@extends('layouts.users.store.app')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
    {{ tenant('domain') }} | {{ $product->name }}
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
    @include('stores.sellers.components.content.products.product-details')
@endsection

@section('footer_js')
    @include('stores.sellers.components.navbar.js.navbar_js');
    @include('stores.sellers.components.content.products.js.coupon_js')
    @include('stores.sellers.components.content.products.product-details-js')
    @include('stores.sellers.components.content.products.js.device_fingerprint_js')
@endsection
