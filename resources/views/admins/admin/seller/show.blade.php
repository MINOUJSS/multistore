@extends('layouts.admins.app')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.seller.show')
@endsection

@section('footer_js')
    @include('admins.admin.components.content.seller.js.show.approve_seller_js')
@endsection