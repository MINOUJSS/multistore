@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  الصفحة تعديل الطلبات
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.orders.edit_order')
@endsection
@section('footer_js')
@include('users.suppliers.components.content.orders.js.edit_js.get_shipping_cost_js')
@include('users.suppliers.components.content.orders.js.edit_js.edit_js')
  {{-- @include('users.suppliers.components.content.orders.js.get_order_data_js')
  @include('users.suppliers.components.content.orders.js.unlock_phone_number_js')
  @include('users.suppliers.components.content.orders.js.delete_order_js')
  @include('users.suppliers.components.content.orders.js.search_order_js')
  @include('users.suppliers.components.content.orders.js.change_order_statu_js')
  @include('users.suppliers.components.content.orders.js.block_customer_js') --}}
@endsection