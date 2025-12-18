@extends('layouts.admins.app')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
    @include('admins.admin.components.content.payments_proofs_refused.show')
@endsection

@section('footer_js')
    @include('admins.admin.components.content.payments_proofs_refused.js.chat_box_js')
@endsection