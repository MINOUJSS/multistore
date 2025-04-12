@extends('layouts.users.dashboard.app')

@section('title')
    الإشتراك
@endsection

@section('style')
<style>
/* تخصيص الباقة المفعلة */
.active-plan {
    border: 3px solid #28a745; /* إضافة حدود خضراء */
    background-color: #f4fdf4; /* خلفية فاتحة */
    box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2); /* تأثير الظل */
}

.active-plan .card-header {
    background-color: #28a745; /* تغيير لون الرأس إلى الأخضر */
    color: white; /* النص باللون الأبيض */
}

.active-plan .btn-success {
    background-color: #218838; /* زر الاشتراك بألوان متناسقة */
    border-color: #1e7e34;
}

.active-plan .list-group-item {
    background-color: #f4fdf4; /* خلفية فاتحة للمميزات */
}
</style>

@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
@include('users.suppliers.components.content.subscription.index')
@endsection