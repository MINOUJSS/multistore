@extends('layouts.users.store.app')
@section('title')
    {{ tenant('domain') }} | سياسة الخصوصية
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
    @include('stores.suppliers.components.content.pages.privacy_policy.index')
@endsection

@section('footer_js')
        @include('stores.suppliers.components.navbar.js.navbar_js');
@endsection
