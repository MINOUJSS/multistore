<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantsController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
    Route::get('/',[TenantsController::class,'index'])->name('store');
    // store pages
    Route::get('/about',[TenantsController::class,'about'])->name('about');
    Route::get('/privacy-policy',[TenantsController::class,'privacy_policy'])->name('privacy-policy');
    Route::get('/terms-of-use',[TenantsController::class,'terms_of_use'])->name('terms-of-use');
    Route::get('/contact-us',[TenantsController::class,'contact_us'])->name('contact-us');
    Route::get('/exchange-policy',[TenantsController::class,'exchange_policy'])->name('exchange-policy');
    Route::get('/shipping-policy',[TenantsController::class,'shipping_policy'])->name('shipping-policy');
    Route::get('/payment-policy',[TenantsController::class,'payment_policy'])->name('payment-policy');
    Route::get('/faq',[TenantsController::class,'faq'])->name('faq');
    Route::get('/categories',[TenantsController::class,'categories'])->name('categories');
    //store products
    Route::get('/products',[TenantsController::class,'products'])->name('products');
    Route::get('/product/{id}',[TenantsController::class,'product'])->name('product');
    Route::get('/products-by-category/{id}',[TenantsController::class,'products_by_category'])->name('products-by-category');
    //store cart
    Route::get('/cart',[TenantsController::class,'cart'])->name('cart');
    //store checkout
    Route::get('/checkout',[TenantsController::class,'checkout'])->name('checkout');
    //store checkout
    Route::get('/checkout/success',[TenantsController::class,'checkout_success'])->name('checkout-success');
    //store checkout
    Route::get('/checkout/cancel',[TenantsController::class,'checkout_cancel'])->name('checkout-cancel');
    //order
    Route::get('/order',[TenantsController::class,'order'])->name('order');
    //get dayra response 
    Route::post('/get-dayras/{wilaya_id}',[TenantsController::class,'get_dayras'])->name('get-dayras');
     //get baladia response 
     Route::post('/get-baladias/{dayra_id}',[TenantsController::class,'get_baladias'])->name('get-baladias');
    


});

// Route::get('/', function () {
//     dd(\App\Models\User::all());
//     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
// });
