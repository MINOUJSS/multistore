@extends('layouts.admins.app')

@section('meta')
   <meta name="csrf-token" content="{{ csrf_token() }}"> 
@endsection

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.disputes.show')
@endsection

@section('footer_js')
@include('admins.admin.components.content.disputes.js.chat_box_js')  
@endsection