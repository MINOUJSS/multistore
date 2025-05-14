@extends('layouts.users.dashboard.app')

@section('css')
    <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/order-plan-step.css">
@endsection

@section('header_js')
    <script type="text/javascript" src="{{asset('asset/users/dashboard')}}/js/order-plan-step.js"></script>
@endsection

@section('style')
<style>
    body {
      background-color: #f8f9fa;
      font-family: 'Tajawal', sans-serif;
    }
    .page-title {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .tab {
      display: none;
      transition: all 0.4s ease-in-out;
    }
    .tab.active {
      display: block;
      animation: fadeIn 0.6s;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .step {
      height: 15px;
      width: 15px;
      margin: 0 5px;
      background-color: #e0e0e0;
      border-radius: 50%;
      display: inline-block;
    }
    .step.active {
      background-color: #0d6efd;
    }
    @media (max-width: 576px) {
      h1, h2 {
        font-size: 1.5rem;
      }
      .form-check-label {
        font-size: 0.9rem;
      }
    }
  </style>
@endsection

@section('title')
    تأكيد الاشتراك
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
@include('users.suppliers.components.content.subscription.confirmation')
@endsection
@section('footer_js')
    @include('users.suppliers.components.content.subscription.confirmation_js')
@endsection