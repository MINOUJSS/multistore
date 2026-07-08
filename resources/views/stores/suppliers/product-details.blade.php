@extends('layouts.users.store.app')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
    {{ tenant('domain') }} | {{ $product->name }}
@endsection

@section('style')
    @if (has_supplier_settings(tenant('id')))
        @include('stores.suppliers.theme.all')
    @endif
        <style>
        img {
            max-width: 100%;
            height: auto;
        }
      /* start  */
      #carouselExampleIndicators .carousel-inner {
    height: 450px; /* ارتفاع موحد */
}

#carouselExampleIndicators .carousel-item {
    height: 450px;
}

#carouselExampleIndicators .product-carousel-img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* يظهر الصورة كاملة */
    object-position: center;
    background: #f8f9fa; /* خلفية للمساحات الفارغة */
}
/* .carousel-image-wrapper{
    height:450px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff;
} */
/*media*/
#carouselExampleIndicators .carousel-inner,
#carouselExampleIndicators .carousel-item {
    height: 450px;
}

@media (max-width: 768px) {
    #carouselExampleIndicators .carousel-inner,
    #carouselExampleIndicators .carousel-item {
        height: 280px;
    }
}
/* end  */
    </style>
@endsection
@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.v1.cart')
@endsection

@section('content')
    @include('stores.suppliers.components.content.products.product-details')
@endsection

@section('footer_js')
    @include('stores.suppliers.components.navbar.js.navbar_js');
    @include('stores.suppliers.components.content.products.js.coupon_js')
    @include('stores.suppliers.components.content.products.product-details-js')
    @include('stores.suppliers.components.content.products.js.device_fingerprint_js')
    @include('stores.suppliers.components.content.products.js.floating-buy-bar-js')
@endsection
