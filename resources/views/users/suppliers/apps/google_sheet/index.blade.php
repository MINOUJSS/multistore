@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  google sheet 
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.apps.google_sheet.index')
@endsection

@section('footer_js')
@include('users.suppliers.components.content.apps.google_sheet.js.store_sheet_js')
@include('users.suppliers.components.content.apps.google_sheet.js.update_sheet_js')
@include('users.suppliers.components.content.apps.google_sheet.js.delete_sheet_js')
@endsection