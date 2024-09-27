<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Users\Suppliers\SupplierController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
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
    //your routes here
    Route::name('supplier.')->group(function(){
        Route::get('/dashboard',[SupplierController::class,'dashboard'])->name('dashboard');
    //authentication routes here
    Route::middleware('guest')->group(function () {
    Route::get('/register',[RegistredSupplierController::class,'create'])->name('register');
    Route::post('register', [RegistredSupplierController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });
    });
    
});