@extends('layouts.users.store.app')
@section('title')
   {{tenant('domain')}} | الرئيسية
@endsection

@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.cart')
@endsection

@section('content')
    @include('stores.suppliers.components.content.index.index')
@endsection
