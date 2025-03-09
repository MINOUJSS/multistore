<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChargilyPayController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Users\Suppliers\SupplierController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Users\Suppliers\SupplierAppsController;
use App\Http\Controllers\Users\Suppliers\SupplierPlanController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderController;
use App\Http\Controllers\Users\Suppliers\SupplierPaymentController;
use App\Http\Controllers\Users\Suppliers\SupplierProductController;
use App\Http\Controllers\Users\Suppliers\SupplierSettingController;
use App\Http\Controllers\Users\Suppliers\Auth\NewPasswordController;
use App\Http\Controllers\Users\Suppliers\SupplierShippingController;
use App\Http\Controllers\Users\Suppliers\SupplierAttributeController;
use App\Http\Controllers\Users\Suppliers\SupplierStoreDesignController;
use App\Http\Controllers\Users\Suppliers\SupplierSubscriptionController;
use App\Http\Controllers\Users\Suppliers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Users\Suppliers\Auth\RegistredSupplierController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderAbandonedController;
use App\Http\Controllers\Users\Suppliers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Supplier Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    //dashboard routes here
    Route::name('supplier.')->group(function(){
        Route::middleware('auth')->group(function () {
            //unusing routes withoute verification payment
            Route::middleware('verifysupplierpaiment')->group(function () {
                Route::get('/supplier-panel',[SupplierController::class,'index'])->name('index');
                Route::get('/supplier-panel/admin',[SupplierController::class,'index'])->name('admin');
                Route::get('/supplier-panel/dashboard',[SupplierController::class,'index'])->name('dashboard'); 
                //supplier settings routes
                Route::get('/supplier-panel/settings',[SupplierSettingController::class,'index'])->name('settings');
                //supplier products routes
                Route::get('/supplier-panel/products',[SupplierProductController::class,'index'])->name('products'); 
                Route::post('/supplier-panel/product/create',[SupplierProductController::class,'create'])->name('product.create');
                Route::get('/supplier-panel/product/edit/{id}',[SupplierProductController::class,'edit'])->name('product.edit');
                Route::post('/supplier-panel/product/update/{id}',[SupplierProductController::class,'update'])->name('product.update');
                Route::delete('/supplier-panel/product/delete/{id}',[SupplierProductController::class,'delete'])->name('product.delete');
                Route::delete('/supplier-panel/product/image/delete/{id}',[SupplierProductController::class,'delete_product_image'])->name('product.delete_product_image');
                Route::delete('/supplier-panel/product/variant/delete/{id}',[SupplierProductController::class,'delete_product_variation'])->name('product.delete_product_variation');
                Route::delete('/supplier-panel/product/discount/delete/{id}',[SupplierProductController::class,'delete_product_discount'])->name('product.delete_product_discount');
                Route::delete('/supplier-panel/product/attributes/delete/{id}',[SupplierProductController::class,'delete_product_attribute'])->name('product.delete_product_attribute');
                // supplier attribute routes
                Route::post('/supplier-panel/attributes/create',[SupplierAttributeController::class,'create'])->name('attribute.create_attribute');
                Route::post('/supplier-panel/attributes/user/{id}',[SupplierAttributeController::class,'get_user_attributes'])->name('attribute.get_user_attribute');
                Route::delete('/supplier-panel/attributes/delete/{id}',[SupplierAttributeController::class,'delete_attribute'])->name('attribute.delete_attribute');
                //supplier orders routes
                Route::get('/supplier-panel/orders',[SupplierOrderController::class,'index'])->name('orders'); 
                Route::get('/supplier-panel/order/{id}',[SupplierOrderController::class,'order'])->name('order');
                //supplier order abandoned routes
                Route::get('/supplier-panel/orders-abandoned',[SupplierOrderAbandonedController::class,'index'])->name('orders-abandoned');
                //supplier shipping routes
                Route::get('/supplier-panel/shipping',[SupplierShippingController::class,'index'])->name('shipping');
                //supplier application routes
                Route::get('/supplier-panel/apps',[SupplierAppsController::class,'index'])->name('apps');
                //supplier design routes
                Route::get('/supplier-panel/store-design',[SupplierStoreDesignController::class,'index'])->name('store-design');
                Route::post('/supplier-panel/store-design/theme-update/{user_id}',[SupplierStoreDesignController::class,'theme_update'])->name('theme-update');
            });
            Route::post('/supplier-panel/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
            //subscription routes here
            Route::get('/supplier-panel/subscription',[SupplierSubscriptionController::class, 'index'])->name('subscription');
            Route::get('/supplier-panel/subscription/confirmation',[SupplierSubscriptionController::class, 'confirmation'])->name('subscription.confirmation');
            //supplier plan routes here
            Route::get('/supplier-panel/plan-pricing/{plan_id}',[SupplierPlanController::class, 'plan_pricing'])->name('plan_pricing');
            //supplier payment routes here
            Route::post('/supplier-panel/payment/redirect',[SupplierPaymentController::class, 'redirect'])->name('payment.redirect');
            Route::get('/supplier-panel/payment/algerian_credit_card',[SupplierPaymentController::class, 'algerian_credit_card'])->name('payment.algerian_credit_card');
            Route::get('/supplier-panel/payment/baridimob',[SupplierPaymentController::class, 'baridimob'])->name('payment.baridimob');
            Route::get('/supplier-panel/payment/ccp',[SupplierPaymentController::class, 'ccp'])->name('payment.ccp');
               //chargily routes
    Route::post('supplier-panel/chargilypay/redirect', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
    Route::get('supplier-panel/chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
        });
    //authentication routes here
    Route::middleware('guest')->group(function () {
    Route::get('/supplier-panel/register',[RegistredSupplierController::class,'create'])->name('register');
    Route::post('/supplier-panel/register', [RegistredSupplierController::class, 'store']);
    Route::get('/supplier-panel/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/supplier-panel/login', [AuthenticatedSessionController::class, 'login']);
    //forget password routes here
    Route::get('/supplier-panel/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/supplier-panel/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/supplier-panel/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    //chargily webhook routes here
    Route::post('supplier-panel/chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");
    });
    });
    //store routes here
    
});