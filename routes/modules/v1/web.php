<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChargilyPayController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\SiteDisputeController;
use App\Http\Controllers\Users\Suppliers\TelegramController;
use Illuminate\Support\Facades\Route;

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

        // telegram api routes
        Route::get('/test/api/setwebhook', [TelegramController::class, 'setWebhook'])->name('setwebhook');
        Route::post('/test/api/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');
        // Route::get('/test/api/get-supplier-chat-id',[TelegramController::class,'getSupplierChatId'])->name('getsupplierchatid');

        // chargily routes
        Route::post('chargilypay/redirect', [ChargilyPayController::class, 'redirect'])->name('chargilypay.redirect');
        Route::get('chargilypay/back', [ChargilyPayController::class, 'back'])->name('chargilypay.back');
        Route::post('chargilypay/webhook', [ChargilyPayController::class, 'webhook'])->name('chargilypay.webhook_endpoint');
        // site routes
        Route::name('site.')->group(function () {
            Route::get('/', [SiteController::class, 'index'])->name('index');
            Route::get('/show_suppliers_plans', [SiteController::class, 'show_suppliers_plans'])->name('show_suppliers_plans');
            Route::get('/show_sellers_plans', [SiteController::class, 'show_sellers_plans'])->name('show_sellers_plans');
            Route::get('/show_shipers_plans', [SiteController::class, 'show_shipers_plans'])->name('show_shipers_plans');
            Route::get('/show_affiliate_marketers_plans', [SiteController::class, 'show_affiliate_marketers_plans'])->name('show_affiliate_marketers_plans');
            // disputes routes
            Route::get('/dispute/create', [SiteDisputeController::class, 'create'])->name('dispute.create');
            Route::post('/dispute/store', [SiteDisputeController::class, 'store'])->name('dispute.store');
            Route::get('/dispute/track/{token}', [SiteDisputeController::class, 'track'])->name('dispute.track');
            Route::post('/dispute/{token}/reply', [SiteDisputeController::class, 'reply'])->name('dispute.reply');
            Route::get('/dispute/{token}/messages', [SiteDisputeController::class, 'fetchMessages']);
        });
    });
}
