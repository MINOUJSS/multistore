@extends('layouts.admins.app')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.disputes.index')
@endsection
@section('footer_js')
    @include('admins.admin.components.content.disputes.js.delete_dispute_js')  
@endsection