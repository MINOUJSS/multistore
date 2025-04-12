@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('title')
  تسعير الشحن
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.shipping.edit')
@endsection

@section('footer_js')
    @include('users.suppliers.components.content.shipping.js.edit.check_and_uncheck_checkboxes_js')
@endsection