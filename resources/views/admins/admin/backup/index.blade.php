@extends('layouts.admins.app')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.backup.index')
@endsection

@section('footer_js')
    @include('admins.admin.components.content.backup.js.check_all_js')
@endsection