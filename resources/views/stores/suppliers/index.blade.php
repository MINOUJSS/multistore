@extends('layouts.users.store.app')
@section('title')
    {{ tenant('domain') }} | الرئيسية
@endsection

@section('style')
    @if (has_supplier_settings(tenant('id')))
        @include('stores.suppliers.theme.all')
    @endif
    @include('stores.suppliers.components.content.index.css.add-to-cart-animation-css')
@endsection
@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.v1.cart')
@endsection

@section('content')
    @include('stores.suppliers.components.content.index.index')
@endsection

@section('footer_js')
    @include('stores.suppliers.components.navbar.js.navbar_js');
    @include('stores.suppliers.components.content.index.js.add-to-cart-animation-js')
@endsection
