<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\Admin\AdminController;
use App\Http\Controllers\Admins\Admin\SettingController;
use App\Http\Controllers\Admins\Admin\PaymentsController;
use App\Http\Controllers\Admins\Admin\SupplierController;
use App\Http\Controllers\Admins\Admin\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/
// routes/admin.php, api.php or any other central route files you have

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        // your actual routes
        Route::name('admin.')->group(function () {
            Route::middleware('guest')->group(function () {
                Route::get('/ah-login',[AuthenticatedSessionController::class,'create'])->name('login');
                Route::post('/ah-login',[AuthenticatedSessionController::class,'login']);
            });
            Route::middleware('admin')->group(function () {
            Route::get('/ah-admin',[AdminController::class,'index'])->name('dashboard');
            Route::post('/ah-logout',[AuthenticatedSessionController::class,'logout'])->name('logout');
            //setting admin routes here
            Route::get('/ah-admin/settings',[SettingController::class,'index'])->name('settings');
            //suppliers actions
            Route::get('/ah-admin/suppliers',[SupplierController::class,'index'])->name('suppliers');
            Route::delete('/ah-admin/supplier/destroy/{id}',[SupplierController::class,'destroy'])->name('supplier.destroy');
            //payments Routes
            Route::get('/ah-admin/payments/rechage-requests',[PaymentsController::class,'recharge_requests'])->name('payments.recharge_requests');
            Route::patch('/admin/payments/recharge-request/approve/{id}', [PaymentsController::class, 'approve_recharge'])->name('payments.recharge.approve');
            Route::get('/ah-admin/payments/inoices-payments',[PaymentsController::class,'invoices_payments'])->name('payments.invoices_payments');
            Route::patch('/admin/payments/invoice/approve/{id}', [PaymentsController::class, 'approve_invoice_payment'])->name('payments.invoice.approve');
            Route::get('/ah-admin/payments/subscribes-payments',[PaymentsController::class,'subscribes_payments'])->name('payments.subscribes_payments');
            Route::get('/ah-admin/payments/suppliers/subscribes-payments',[PaymentsController::class,'suppliers_subscribes_payments'])->name('payments.suppliers.subscribes_payments');
            Route::patch('/admin/payments/suppliers/subscribe/approve/{id}', [PaymentsController::class, 'approve_suppliers_subscribe_payment'])->name('payments.suppliers.subscribe.approve');
            });
        });
    });
}