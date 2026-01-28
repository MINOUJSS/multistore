@extends('layouts.users.store.app')
@section('title')
    {{ tenant('domain') }} | الرئيسية
@endsection

@section('style')
    @if (has_seller_settings(tenant('id')))
        @include('stores.sellers.theme.all')
    @endif
    @include('stores.sellers.components.content.index.css.add-to-cart-animation-css')
@endsection
@section('navbar')
    @include('stores.sellers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.sellers.components.cart.v1.cart')
@endsection

@section('content')
    @include('stores.sellers.components.content.index.index')
@endsection

@section('footer_js')
    @include('stores.sellers.components.navbar.js.navbar_js');
    @include('stores.sellers.components.content.index.js.add-to-cart-animation-js')
@endsection
