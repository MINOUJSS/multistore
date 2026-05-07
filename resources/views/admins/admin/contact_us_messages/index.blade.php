@extends('layouts.admins.app')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.contact_us_messages.index')
@endsection

@section('footer_js')
    @include('admins.admin.components.content.contact_us_messages.js.delete_contact_message_js')
    @include('admins.admin.components.content.contact_us_messages.js.search_message_js')
@endsection