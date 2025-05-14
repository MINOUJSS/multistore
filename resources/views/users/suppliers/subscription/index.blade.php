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
/*----------------------------*/
.subscription-option {
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}

.subscription-option:hover {
    background-color: #f8f9fa;
}

.subscription-option input[type="radio"] {
    cursor: pointer;
}

.subscription-option.active,
.subscription-option input[type="radio"]:checked + span {
    background-color: #e6f7ff;
    font-weight: bold;
    color: #007bff;
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