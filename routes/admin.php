<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\Admin\AdminController;
use App\Http\Controllers\Admins\Admin\SettingController;
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
            });
        });
    });
}