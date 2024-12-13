<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\ChargilyPayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        // your actual routes
        // Route::get('/', function () {
        //     return view('welcome');
        // });
        
        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['auth', 'verified'])->name('dashboard');
        
        // Route::middleware('auth')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // });
        
        require __DIR__.'/auth.php';

        //chargily routes
     Route::post('chargilypay/redirect', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
     Route::get('chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
        
        //site routes
        Route::name('site.')->group(function(){
            Route::get('/',[SiteController::class, 'index'])->name('index');
            Route::get('/show_suppliers_plans',[SiteController::class,'show_suppliers_plans'])->name('show_suppliers_plans');
            Route::get('/show_sellers_plans',[SiteController::class,'show_sellers_plans'])->name('show_sellers_plans');
            Route::get('/show_shipers_plans',[SiteController::class,'show_shipers_plans'])->name('show_shipers_plans');
            Route::get('/show_affiliate_marketers_plans',[SiteController::class,'show_affiliate_marketers_plans'])->name('show_affiliate_marketers_plans');
        });

    });
    Route::post('chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");
}
