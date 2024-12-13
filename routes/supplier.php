<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChargilyPayController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Users\Suppliers\SupplierController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Users\Suppliers\SupplierPlanController;
use App\Http\Controllers\Users\Suppliers\SupplierPaymentController;
use App\Http\Controllers\Users\Suppliers\Auth\NewPasswordController;
use App\Http\Controllers\Users\Suppliers\SupplierSubscriptionController;
use App\Http\Controllers\Users\Suppliers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Users\Suppliers\Auth\RegistredSupplierController;
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
                Route::get('/admin',[SupplierController::class,'index'])->name('admin');
                Route::get('/supplier/dashboard',[SupplierController::class,'index'])->name('dashboard');
                Route::post('/supplier/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout'); 
                  
            });
            //subscription routes here
            Route::get('/supplier/subscription',[SupplierSubscriptionController::class, 'index'])->name('subscription');
            Route::get('/supplier/subscription/confirmation',[SupplierSubscriptionController::class, 'confirmation'])->name('subscription.confirmation');
            //supplier plan routes here
            Route::get('/supplier/plan-pricing/{plan_id}',[SupplierPlanController::class, 'plan_pricing'])->name('plan_pricing');
            //supplier payment routes here
            Route::post('/supplier/payment/redirect',[SupplierPaymentController::class, 'redirect'])->name('payment.redirect');
            Route::get('/supplier/payment/algerian_credit_card',[SupplierPaymentController::class, 'algerian_credit_card'])->name('payment.algerian_credit_card');
            Route::get('/supplier/payment/baridimob',[SupplierPaymentController::class, 'baridimob'])->name('payment.baridimob');
            Route::get('/supplier/payment/ccp',[SupplierPaymentController::class, 'ccp'])->name('payment.ccp');
        });
    //authentication routes here
    Route::middleware('guest')->group(function () {
    Route::get('/supplier/register',[RegistredSupplierController::class,'create'])->name('register');
    Route::post('/supplier/register', [RegistredSupplierController::class, 'store']);
    Route::get('/supplier/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/supplier/login', [AuthenticatedSessionController::class, 'login']);
    //forget password routes here
    Route::get('/supplier/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/supplier/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/supplier/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/supplier/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    //chargily routes
    Route::post('supplier/chargilypay/redirect', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
    Route::get('supplier/chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
    Route::post('supplier/chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");
    });
    });
    //store routes here

});