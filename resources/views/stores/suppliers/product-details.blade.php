@extends('layouts.users.store.app')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
    {{ tenant('domain') }} | {{ $product->name }}
@endsection

@section('style')
    @if (has_supplier_settings(tenant('id')))
        @include('stores.suppliers.theme.all')
    @endif
@endsection
@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.v1.cart')
@endsection

@section('content')
    @include('stores.suppliers.components.content.products.product-details')
@endsection

@section('footer_js')
    @include('stores.suppliers.components.navbar.js.navbar_js');
    @include('stores.suppliers.components.content.products.js.coupon_js')
    @include('stores.suppliers.components.content.products.product-details-js')
    @include('stores.suppliers.components.content.products.js.device_fingerprint_js')
@endsection
