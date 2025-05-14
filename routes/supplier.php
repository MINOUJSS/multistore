<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChargilyPayController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Users\Suppliers\SupplierController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Users\Suppliers\SupplierAppsController;
use App\Http\Controllers\Users\Suppliers\SupplierPageController;
use App\Http\Controllers\Users\Suppliers\SupplierPlanController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderController;
use App\Http\Controllers\Users\Suppliers\SupplierWalletController;
use App\Http\Controllers\Users\Suppliers\SupplierBillingController;
use App\Http\Controllers\Users\Suppliers\SupplierPaymentController;
use App\Http\Controllers\Users\Suppliers\SupplierProductController;
use App\Http\Controllers\Users\Suppliers\SupplierSettingController;
use App\Http\Controllers\Users\Suppliers\Auth\NewPasswordController;
use App\Http\Controllers\Users\Suppliers\SupplierShippingController;
use App\Http\Controllers\Users\Suppliers\SupplierAttributeController;
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
                Route::post('/supplier-panel/settings/theme-update/{user_id}',[SupplierSettingController::class,'theme_update'])->name('theme-update');
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
                Route::get('/supplier-panel/filter-products',[SupplierProductController::class,'filterProducts'])->name('product.filterProducts');
                // supplier attribute routes
                Route::post('/supplier-panel/attributes/create',[SupplierAttributeController::class,'create'])->name('attribute.create_attribute');
                Route::post('/supplier-panel/attributes/user/{id}',[SupplierAttributeController::class,'get_user_attributes'])->name('attribute.get_user_attribute');
                Route::delete('/supplier-panel/attributes/delete/{id}',[SupplierAttributeController::class,'delete_attribute'])->name('attribute.delete_attribute');
                //supplier orders routes
                Route::get('/supplier-panel/orders',[SupplierOrderController::class,'index'])->name('orders'); 
                Route::get('/supplier-panel/order/{id}',[SupplierOrderController::class,'order'])->name('order');
                Route::delete('/supplier-panel/order/delete/{id}',[SupplierOrderController::class,'delete_order'])->name('order.delete');                
                Route::get('/supplier-panel/filter-orders',[SupplierOrderController::class,'filterOrders'])->name('order.filterOrders'); 
                Route::post('/supplier-panel/update-order-status', [SupplierOrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');       
                //supplier orders abandoned routes
                Route::get('/supplier-panel/orders-abandoned',[SupplierOrderAbandonedController::class,'index'])->name('orders-abandoned');
                Route::get('/supplier-panel/order-abandoned/{id}',[SupplierOrderAbandonedController::class,'order'])->name('order-abandoned');
                Route::delete('/supplier-panel/order-abadoned/delete/{id}',[SupplierOrderAbandonedController::class,'delete_order'])->name('order-abandoned.delete');
                Route::get('/supplier-panel/filter-orders-abandoned',[SupplierOrderAbandonedController::class,'filterOrders'])->name('order.filterOrdersAbandoned');
                Route::post('/supplier-panel/update-order-abandoned-status', [SupplierOrderAbandonedController::class, 'updateOrderStatus'])->name('order.updateOrderAbandonedStatus');
                //unlock phone number
                Route::post('/supplier-panel/order/unlock-phone-number/{order_id}',[SupplierOrderController::class,'unlock_phone_number'])->name('order.unlock-phone-number');
                Route::post('/supplier-panel/order-abandoned/unlock-phone-number/{order_id}',[SupplierOrderAbandonedController::class,'unlock_phone_number'])->name('order-abandoned.unlock-phone-number');
                //supplier shipping routes
                Route::get('/supplier-panel/shipping',[SupplierShippingController::class,'index'])->name('shipping');
                Route::get('/supplier-panel/shipping/pricing/edit',[SupplierShippingController::class,'edit'])->name('shipping.edit');
                Route::post('/supplier-panel/shipping/pricing/update',[SupplierShippingController::class,'update'])->name('shipping.update');
                //supplier shipping company routes
                Route::post('/supplier-panel/shipping-company/create',[SupplierShippingController::class,'add_shipping_company'])->name('shipping-company.create');
                Route::delete('/supplier-panel/shipping-company/delete/{id}',[SupplierShippingController::class,'delete_shipping_company'])->name('shipping-company.delete');
                Route::post('/supplier-panel/update-shipping-status', [SupplierShippingController::class, 'updateShippingStatus'])->name('shipping-company.update-status');
                //supplier application routes
                Route::get('/supplier-panel/apps',[SupplierAppsController::class,'index'])->name('apps');
                Route::get('/supplier-panel/apps/google-analytics',[SupplierAppsController::class,'google_analytics'])->name('app.google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/store',[SupplierAppsController::class,'store_google_analytics'])->name('app.store-google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/update/{id}',[SupplierAppsController::class,'update_google_analytics'])->name('app.update-google-analytics');
                Route::delete('/supplier-panel/apps/google-analytics/delete/{id}',[SupplierAppsController::class,'delete_google_analytics'])->name('app.delete-google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/get',[SupplierAppsController::class,'get_google_analytics'])->name('app.get-google-analytics');
                Route::get('/supplier-panel/apps/facebook-pixel',[SupplierAppsController::class,'facebook_pixel'])->name('app.facebook-pixel');
                Route::post('/supplier-panel/apps/facebook-pixel/store',[SupplierAppsController::class,'store_facebook_pixel'])->name('app.store-facebook-pixel');
                Route::post('/supplier-panel/apps/facebook-pixel/update/{id}',[SupplierAppsController::class,'update_facebook_pixel'])->name('app.update-facebook-pixel');
                Route::delete('/supplier-panel/apps/facebook-pixel/delete/{id}',[SupplierAppsController::class,'delete_facebook_pixel'])->name('app.delete-facebook-pixel');
                Route::get('/supplier-panel/apps/tiktok-pixel',[SupplierAppsController::class,'tiktok_pixel'])->name('app.tiktok-pixel');
                Route::post('/supplier-panel/apps/tiktok-pixel/store',[SupplierAppsController::class,'store_tiktok_pixel'])->name('app.store-tiktok-pixel');
                Route::post('/supplier-panel/apps/tiktok-pixel/update/{id}',[SupplierAppsController::class,'update_tiktok_pixel'])->name('app.update-tiktok-pixel');
                Route::delete('/supplier-panel/apps/tiktok-pixel/delete/{id}',[SupplierAppsController::class,'delete_tiktok_pixel'])->name('app.delete-tiktok-pixel');
                Route::get('/supplier-panel/apps/google-sheet',[SupplierAppsController::class,'google_sheet'])->name('app.google-sheet');
                Route::post('/supplier-panel/apps/google-sheet/store',[SupplierAppsController::class,'store_google_sheets'])->name('app.store-google-sheet');
                Route::post('/supplier-panel/apps/google-sheet/update/{id}',[SupplierAppsController::class,'update_google_sheets'])->name('app.update-google-sheet');
                Route::delete('/supplier-panel/apps/google-sheet/delete/{id}',[SupplierAppsController::class,'delete_google_sheets'])->name('app.delete-google-sheet');
                Route::get('/supplier-panel/apps/telegram-notifications',[SupplierAppsController::class,'telegram_notifications'])->name('app.telegram-notifications');
                Route::post('/supplier-panel/apps/telegram/store', [SupplierAppsController::class, 'store_telegram_notification'])->name('app.store-telegram-notification');
                Route::post('/supplier-panel/apps/telegram/update/{id}', [SupplierAppsController::class, 'update_telegram_notification'])->name('app.update-telegram-notification');
                Route::delete('/supplier-panel/apps/telegram/delete/{id}', [SupplierAppsController::class, 'delete_telegram_notification'])->name('app.delete-telegram-notification');
                //supplier billing routes
                Route::get('/supplier-panel/billing',[SupplierBillingController::class,'index'])->name('billing');
                Route::get('/supplier-panel/billing/invoice/create', [SupplierBillingController::class, 'create'])->name('billing.invoice.create');
                Route::get('/supplier-panel/billing/invoice/{id}', [SupplierBillingController::class, 'show'])->name('billing.invoice.show');
                Route::post('/supplier-panel/billing/pay/invoice/{id}/redirect', [SupplierBillingController::class, 'invoice_redirect'])->name('billing.invoice.redirect');
                Route::post('/supplier-panel/billing/pay/invoice', [SupplierBillingController::class, 'pay_invoice'])->name('billing.invoice.pay');
                Route::delete('/supplier-panel/billing/invoice/{invoice}/delete-proof', [SupplierBillingController::class, 'deleteProof'])->name('billing.invoice.deleteProof');
                //Wallet Routes
                Route::get('/supplier-panel/wallet',[SupplierWalletController::class,'index'])->name('wallet');
                // Route::post('/supplier-panel/wallet/charge',[SupplierWalletController::class,'charge'])->name('wallet.charge');
                Route::get('/supplier-panel/wallet/addition/{id}', [SupplierWalletController::class, 'showAddition'])->name('get_wallet');
                Route::post('/supplier-panel/wallet/recharge/baridimob', [SupplierWalletController::class, 'payWithBaridiMob'])->name('wallet.recharge.baridimob');
                Route::post('/supplier-panel/wallet/recharge/ccp', [SupplierWalletController::class, 'payWithCcp'])->name('wallet.recharge.ccp');
                //supplier pay subscription routes here
                Route::get('/supplier-panel/subscription',[SupplierSubscriptionController::class, 'index'])->name('subscription');
            Route::post('/supplier-panel/subscription/pay_method/redirect',[SupplierSubscriptionController::class,'redirect'])->name('subscription.paymethod.redirect');
            Route::post('/supplier-panel/subscription/pay/baridimob', [SupplierSubscriptionController::class, 'baridimob'])->name('subscription.payment.baridimob');
            Route::post('/supplier-panel/subscription/pay/ccp', [SupplierSubscriptionController::class, 'ccp'])->name('subscription.payment.ccp');
            Route::post('/supplier-panel/subscription/pay/wallet', [SupplierSubscriptionController::class, 'wallet'])->name('subscription.payment.wallet');
                //Page Routes
                Route::put('/supplier-panel/page/update/{id}',[SupplierPageController::class,'update'])->name('page.update');

            });
            Route::post('/supplier-panel/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
            //subscription routes here
            Route::post('/supplier-panel/subscription/pay/new-subscription/baridimob',[SupplierSubscriptionController::class,'new_subscription_by_baridimob'])->name('new.subscription.payment.baridimob');
            Route::post('/supplier-panel/subscription/pay/new-subscription/ccp',[SupplierSubscriptionController::class,'new_subscription_by_ccp'])->name('new.subscription.payment.ccp');
            Route::get('/supplier-panel/subscription/confirmation',[SupplierSubscriptionController::class, 'confirmation'])->name('subscription.confirmation');
            Route::post('/supplier-panel/order/plan/{id}',[SupplierSubscriptionController::class,'order_plan'])->name('subscription.order.plan');
            
            //supplier plan routes here
            Route::get('/supplier-panel/plan-pricing/{plan_id}',[SupplierPlanController::class, 'plan_pricing'])->name('plan_pricing');
            //supplier plan Authorization routes here
            Route::get('/supplier-panel/plan-authorization/{plan_id}',[SupplierPlanController::class, 'plan_authorization'])->name('plan_authorization');
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