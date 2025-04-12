@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
الصفحة الطلبات المتروكة
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.orders_abandoned.index')
@endsection
@section('footer_js')
  @include('users.suppliers.components.content.orders_abandoned.js.get_order_data_js')
  @include('users.suppliers.components.content.orders_abandoned.js.unlock_phone_number_js')
  @include('users.suppliers.components.content.orders_abandoned.js.delete_order_js')
  @include('users.suppliers.components.content.orders_abandoned.js.search_order_js')
  @include('users.suppliers.components.content.orders_abandoned.js.change_order_statu_js')
@endsection