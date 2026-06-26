@extends('layouts.admins.app')

@section('style')
<style>
 @media print {
    body * {
        visibility: hidden;
    }

    #printableArea,
    #printableArea * {
        visibility: visible;
    }

    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection

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