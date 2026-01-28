@extends('layouts.users.store.app')
@section('title')
    {{ tenant('domain') }} | الدفع
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
    @include('stores.sellers.components.content.payments.chargily.index')
@endsection

@section('footer-js')
    @include('stores.sellers.components.navbar.js.navbar_js');
    @include('stores.sellers.components.content.payments.chargily.js.index-js')
@endsection
