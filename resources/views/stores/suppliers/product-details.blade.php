@extends('layouts.users.store.app')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
   {{tenant('domain')}} | {{$product->name}}
@endsection

@section('style')
    @if(has_supplier_settings(tenant('id')))
        <style>
            /* this is the defaulte theme */
.search-box,.cart-badge,.footer
{
    background-color: {{get_store_parimary_color(tenant('id'))}} !important;
}
.item-details a
{
    color:{{get_store_body_text_color(tenant('id'))}};
}
.footer,.footer-footer a,.footer-li a,.footer-li a:hover
{
    color: {{get_store_footer_text_color(tenant('id'))}};
}
        </style>     
    @endif
@endsection
@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.cart')
@endsection

@section('content')
    @include('stores.suppliers.components.content.products.product-details')
@endsection

@section('footer-js')
    @include('stores.suppliers.components.content.products.product-details-js')
@endsection