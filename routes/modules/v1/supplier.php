<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChargilyPayController;
use App\Http\Controllers\Users\CourierdzController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Users\Suppliers\SupplierController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Users\Suppliers\SupplierFqsController;
use App\Http\Controllers\Users\Suppliers\SupplierAppsController;
use App\Http\Controllers\Users\Suppliers\SupplierPageController;
use App\Http\Controllers\Users\Suppliers\SupplierPlanController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderController;
use App\Http\Controllers\Users\Suppliers\SupplierCouponController;
use App\Http\Controllers\Users\Suppliers\SupplierSliderController;
use App\Http\Controllers\Users\Suppliers\SupplierWalletController;
use App\Http\Controllers\Users\Suppliers\SupplierBenefitController;
use App\Http\Controllers\Users\Suppliers\SupplierBillingController;
use App\Http\Controllers\Users\Suppliers\SupplierPaymentController;
use App\Http\Controllers\Users\Suppliers\SupplierProductController;
use App\Http\Controllers\Users\Suppliers\SupplierProfileController;
use App\Http\Controllers\Users\Suppliers\SupplierSettingController;
use App\Http\Controllers\Users\Suppliers\Auth\NewPasswordController;
use App\Http\Controllers\Users\Suppliers\SupplierCategoryController;
use App\Http\Controllers\Users\Suppliers\SupplierShippingController;
use App\Http\Controllers\Users\Suppliers\SupplierAttributeController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderFormController;
use App\Http\Controllers\Users\Suppliers\SupplierSubscriptionController;
use App\Http\Controllers\Users\Suppliers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Users\Suppliers\Auth\RegistredSupplierController;
use App\Http\Controllers\Users\Suppliers\SupplierOrderAbandonedController;
use App\Http\Controllers\Users\Suppliers\SupplierProductsCouponsController;
use App\Http\Controllers\Users\Suppliers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Users\Suppliers\SupplierCategoriesCouponsController;
use App\Http\Controllers\Users\Suppliers\SupplierCustomerBlockListController;
use App\Http\Controllers\Users\Suppliers\SupplierProofsRefusedChatController;
use App\Http\Controllers\Users\Suppliers\SupplierPaymentsProofsRefusedController;

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
    // dashboard routes here
    Route::name('supplier.')->group(function () {
        Route::middleware('auth')->group(function () {
            // unusing routes withoute verification payment
            Route::middleware('verifysupplierpaiment')->group(function () {
                Route::get('/supplier-panel', [SupplierController::class, 'index'])->name('index');
                Route::get('/supplier-panel/admin', [SupplierController::class, 'index'])->name('admin');
                Route::get('/supplier-panel/dashboard', [SupplierController::class, 'index'])->name('dashboard');
                // get wilaya data
                Route::get('/supplier-panel/get-wilaya-data/{id}', [SupplierController::class, 'get_wilaya_data'])->name('get-wilaya-data');
                // get dayra
                Route::post('/supplier-panel/get-dayras/', [SupplierController::class, 'get_dayras'])->name('get-dayras');
                // get baladia
                Route::post('supplier-panel/get-baladias/', [SupplierController::class, 'get_baladias'])->name('get-baladias');
                // supplier profile routes
                Route::get('/supplier-panel/profile', [SupplierProfileController::class, 'index'])->name('profile');
                Route::post('/supplier-panel/profile/update', [SupplierProfileController::class, 'update'])->name('profile.update');
                // supplier password routes
                Route::post('/supplier-panel/profile/password/update', [SupplierProfileController::class, 'update_password'])->name('profile.password.update');
                // suuplier create or update chargily pay settings
                Route::post('/supplier-panel/profile/chargily/update', [SupplierProfileController::class, 'create_or_update_chargily_settings'])->name('profile.chargily-settings.update');
                Route::delete('/supplier-panel/profile/chargily/delete', [SupplierProfileController::class, 'delete_chargily_settings'])->name('profile.chargily-settings.delete');
                // suuplier create or update bank settings
                Route::post('/supplier-panel/profile/bank/update', [SupplierProfileController::class, 'create_or_update_bank_settings'])->name('profile.bank-settings.update');
                Route::delete('/supplier-panel/profile/bank/delete', [SupplierProfileController::class, 'delete_bank_settings'])->name('profile.bank-settings.delete');
                // /supplier update-avatar
                Route::post('/supplier-panel/profile/update-avatar', [SupplierProfileController::class, 'update_avatar'])->name('profile.update-avatar');
                // supplier settings routes
                Route::get('/supplier-panel/settings', [SupplierSettingController::class, 'index'])->name('settings');
                Route::post('/supplier-panel/settings/theme-update/{user_id}', [SupplierSettingController::class, 'theme_update'])->name('theme-update');
                Route::put('/supplier-panel/settings/update', [SupplierSettingController::class, 'update'])->name('settings.update');
                Route::get('/supplier-panel/clear-tab-flag', function () {
                    session()->forget('activate_store_tab');
                    session()->forget('activate_security_tab');
                    session()->forget('activate_chargily_tab');

                    return response()->json(['success' => true]);
                })->name('clear.tab.flag');
                // supplier products routes
                Route::get('/supplier-panel/products', [SupplierProductController::class, 'index'])->name('products');
                Route::post('/supplier-panel/product/create', [SupplierProductController::class, 'create'])->name('product.create');
                Route::get('/supplier-panel/product/edit/{id}', [SupplierProductController::class, 'edit'])->name('product.edit');
                Route::post('/supplier-panel/product/update/{id}', [SupplierProductController::class, 'update'])->name('product.update');
                Route::delete('/supplier-panel/product/delete/{id}', [SupplierProductController::class, 'delete'])->name('product.delete');
                Route::delete('/supplier-panel/product/image/delete/{id}', [SupplierProductController::class, 'delete_product_image'])->name('product.delete_product_image');
                Route::delete('/supplier-panel/product/video/delete/{id}', [SupplierProductController::class, 'delete_product_video'])->name('product.delete_product_video');
                Route::delete('/supplier-panel/product/variant/delete/{id}', [SupplierProductController::class, 'delete_product_variation'])->name('product.delete_product_variation');
                Route::delete('/supplier-panel/product/discount/delete/{id}', [SupplierProductController::class, 'delete_product_discount'])->name('product.delete_product_discount');
                Route::delete('/supplier-panel/product/attributes/delete/{id}', [SupplierProductController::class, 'delete_product_attribute'])->name('product.delete_product_attribute');
                Route::get('/supplier-panel/product/get-json-data/{id}', [SupplierProductController::class, 'get_json_data'])->name('product.get_json_data');
                Route::get('/supplier-panel/filter-products', [SupplierProductController::class, 'filterProducts'])->name('product.filterProducts');
                // supplier coupons routes
                Route::get('/supplier-panel/coupons', [SupplierCouponController::class, 'index'])->name('coupons');
                Route::post('/supplier-panel/coupons/store', [SupplierCouponController::class, 'store'])->name('coupons.store');
                Route::get('/supplier-panel/coupons/{id}/edit', [SupplierCouponController::class, 'edit'])->name('coupons.edit');
                Route::put('/supplier-panel/coupons/{id}/update', [SupplierCouponController::class, 'update'])->name('coupons.update');
                Route::delete('/supplier-panel/coupons/destroy/{id}', [SupplierCouponController::class, 'destroy'])->name('coupons.destroy');
                // supplier products coupons
                Route::get('/supplier-panel/products-coupons', [SupplierProductsCouponsController::class, 'index'])->name('products-coupons');
                Route::post('/supplier-panel/products-coupons/store', [SupplierProductsCouponsController::class, 'store'])->name('products-coupons.store');
                Route::delete('/supplier-panel/products-coupons/destroy/{id}', [SupplierProductsCouponsController::class, 'destroy'])->name('products-coupons.destroy');
                // supplier categories coupons
                Route::get('/supplier-panel/categories-coupons', [SupplierCategoriesCouponsController::class, 'index'])->name('categories-coupons');
                Route::post('/supplier-panel/categories-coupons/store', [SupplierCategoriesCouponsController::class, 'store'])->name('categories-coupons.store');
                Route::delete('/supplier-panel/categories-coupons/destroy/{id}', [SupplierCategoriesCouponsController::class, 'destroy'])->name('categories-coupons.destroy');
                // Route::resource('/supplier-panel/coupons',[SupplierCouponController::class,'index'])->name('coupons');
                Route::get('/supplier-panel/coupons/filter', [SupplierCouponController::class, 'filter'])->name('coupons.filter');
                Route::get('/supplier-panel/coupons/list', [SupplierCouponController::class, 'list'])->name('coupons.list');
                // supplier attribute routes
                Route::post('/supplier-panel/attributes/create', [SupplierAttributeController::class, 'create'])->name('attribute.create_attribute');
                Route::post('/supplier-panel/attributes/user/{id}', [SupplierAttributeController::class, 'get_user_attributes'])->name('attribute.get_user_attribute');
                Route::delete('/supplier-panel/attributes/delete/{id}', [SupplierAttributeController::class, 'delete_attribute'])->name('attribute.delete_attribute');
                // supplier orders routes
                Route::get('/supplier-panel/orders', [SupplierOrderController::class, 'index'])->name('orders');
                Route::get('/supplier-panel/order/{id}', [SupplierOrderController::class, 'order'])->name('order');
                Route::delete('/supplier-panel/order/delete/{id}', [SupplierOrderController::class, 'delete_order'])->name('order.delete');
                Route::get('/supplier-panel/filter-orders', [SupplierOrderController::class, 'filterOrders'])->name('order.filterOrders');
                Route::post('/supplier-panel/update-order-status', [SupplierOrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');
                Route::post('/supplier-panel/update-confirmation-status', [SupplierOrderController::class, 'updateConfirmationStatus'])->name('order.updateConfirmationStatus');
                Route::post('/supplier-panel/order/{order}/accept-payment', [SupplierOrderController::class, 'acceptPayment'])->name('order.acceptPayment');
                Route::post('/supplier-panel/order/{order}/reject-payment', [SupplierOrderController::class, 'rejectPayment'])->name('order.rejectPayment');

                Route::get('/supplier-panel/order/edit/{id}', [SupplierOrderController::class, 'edit_order'])->name('order.edit');
                Route::put('/supplier-panel/order/update/{id}', [SupplierOrderController::class, 'update_order'])->name('order.update');
                // supplier order details routes
                Route::get('/supplier-panel/delete-order-item/{id}', [SupplierOrderController::class, 'order_item_delete'])->name('order-item.delete');
                Route::delete('/supplier-panel/order-item/delete/{id}', [SupplierOrderController::class, 'deleteItem'])->name('order.item.delete');
                // supplier orders abandoned routes
                Route::get('/supplier-panel/orders-abandoned', [SupplierOrderAbandonedController::class, 'index'])->name('orders-abandoned');
                Route::get('/supplier-panel/order-abandoned/{id}', [SupplierOrderAbandonedController::class, 'order'])->name('order-abandoned');
                Route::delete('/supplier-panel/order-abadoned/delete/{id}', [SupplierOrderAbandonedController::class, 'delete_order'])->name('order-abandoned.delete');
                Route::get('/supplier-panel/filter-orders-abandoned', [SupplierOrderAbandonedController::class, 'filterOrders'])->name('order.filterOrdersAbandoned');
                Route::post('/supplier-panel/update-order-abandoned-status', [SupplierOrderAbandonedController::class, 'updateOrderStatus'])->name('order.updateOrderAbandonedStatus');
                Route::post('/supplier-panel/order-abandoned/move-to-order', [SupplierOrderAbandonedController::class, 'move_to_order'])->name('order.move_to_order');
                // traking order
                Route::get('/supplier-panel/order/tracking/{id}', [SupplierOrderController::class, 'tracking_order'])->name('order.tracking');
                Route::get('/supplier-panel/order/tracking/delete/{id}', [SupplierOrderController::class, 'delete_tracking_order'])->name('order.delete-tracking');
                // unlock phone number
                Route::post('/supplier-panel/order/unlock-phone-number/{order_id}', [SupplierOrderController::class, 'unlock_phone_number'])->name('order.unlock-phone-number');
                Route::post('/supplier-panel/order-abandoned/unlock-phone-number/{order_id}', [SupplierOrderAbandonedController::class, 'unlock_phone_number'])->name('order-abandoned.unlock-phone-number');
                // supplier customer block list routes
                Route::get('/supplier-panel/customer-block-list', [SupplierCustomerBlockListController::class, 'index'])->name('customer-block-list');
                Route::post('/supplier-panel/customer-block-list/create/{order_id}', [SupplierCustomerBlockListController::class, 'create'])->name('customer-block-list.create');
                Route::post('/supplier-panel/customer-block-list/is-blocked/{id}', [SupplierCustomerBlockListController::class, 'is_blocked'])->name('customer-block-list.is-blocked');
                // supplier shipping routes
                Route::get('/supplier-panel/shipping', [SupplierShippingController::class, 'index'])->name('shipping');
                Route::get('/supplier-panel/shipping/pricing/edit', [SupplierShippingController::class, 'edit'])->name('shipping.edit');
                Route::post('/supplier-panel/shipping/pricing/update', [SupplierShippingController::class, 'update'])->name('shipping.update');
                Route::post('/supplier-panel/shipping/get-shipping-cost', [SupplierShippingController::class, 'get_shipping_cost'])->name('shipping.get-shipping-cost');
                // supplier shipping company routes
                Route::post('/supplier-panel/shipping-company/create', [SupplierShippingController::class, 'add_shipping_company'])->name('shipping-company.create');
                Route::delete('/supplier-panel/shipping-company/delete/{id}', [SupplierShippingController::class, 'delete_shipping_company'])->name('shipping-company.delete');
                Route::post('/supplier-panel/update-shipping-status', [SupplierShippingController::class, 'updateShippingStatus'])->name('shipping-company.update-status');
                // courier dz routes
                Route::post('/supplier-panel/courier-dz/test-credentials', [CourierdzController::class, 'testCredentials'])->name('courier-dz.testCredentials');
                Route::post('/supplier-panel/courier-dz/createOrder', [CourierdzController::class, 'createOrder'])->name('courier-dz.createOrder');

                // supplier application routes
                Route::get('/supplier-panel/apps', [SupplierAppsController::class, 'index'])->name('apps');
                // google analitycs
                Route::get('/supplier-panel/apps/google-analytics', [SupplierAppsController::class, 'google_analytics'])->name('app.google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/store', [SupplierAppsController::class, 'store_google_analytics'])->name('app.store-google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/update/{id}', [SupplierAppsController::class, 'update_google_analytics'])->name('app.update-google-analytics');
                Route::delete('/supplier-panel/apps/google-analytics/delete/{id}', [SupplierAppsController::class, 'delete_google_analytics'])->name('app.delete-google-analytics');
                Route::post('/supplier-panel/apps/google-analytics/get', [SupplierAppsController::class, 'get_google_analytics'])->name('app.get-google-analytics');
                // facebook pixl
                Route::get('/supplier-panel/apps/facebook-pixel', [SupplierAppsController::class, 'facebook_pixel'])->name('app.facebook-pixel');
                Route::post('/supplier-panel/apps/facebook-pixel/store', [SupplierAppsController::class, 'store_facebook_pixel'])->name('app.store-facebook-pixel');
                Route::post('/supplier-panel/apps/facebook-pixel/update/{id}', [SupplierAppsController::class, 'update_facebook_pixel'])->name('app.update-facebook-pixel');
                Route::delete('/supplier-panel/apps/facebook-pixel/delete/{id}', [SupplierAppsController::class, 'delete_facebook_pixel'])->name('app.delete-facebook-pixel');
                // tiktok pixle
                Route::get('/supplier-panel/apps/tiktok-pixel', [SupplierAppsController::class, 'tiktok_pixel'])->name('app.tiktok-pixel');
                Route::post('/supplier-panel/apps/tiktok-pixel/store', [SupplierAppsController::class, 'store_tiktok_pixel'])->name('app.store-tiktok-pixel');
                Route::post('/supplier-panel/apps/tiktok-pixel/update/{id}', [SupplierAppsController::class, 'update_tiktok_pixel'])->name('app.update-tiktok-pixel');
                Route::delete('/supplier-panel/apps/tiktok-pixel/delete/{id}', [SupplierAppsController::class, 'delete_tiktok_pixel'])->name('app.delete-tiktok-pixel');
                // google sheet
                Route::get('/supplier-panel/apps/google-sheet', [SupplierAppsController::class, 'google_sheet'])->name('app.google-sheet');
                Route::post('/supplier-panel/apps/google-sheet/store', [SupplierAppsController::class, 'store_google_sheets'])->name('app.store-google-sheet');
                Route::post('/supplier-panel/apps/google-sheet/update/{id}', [SupplierAppsController::class, 'update_google_sheets'])->name('app.update-google-sheet');
                Route::delete('/supplier-panel/apps/google-sheet/delete/{id}', [SupplierAppsController::class, 'delete_google_sheets'])->name('app.delete-google-sheet');
                // telegrarm notification
                Route::get('/supplier-panel/apps/telegram-notifications', [SupplierAppsController::class, 'telegram_notifications'])->name('app.telegram-notifications');
                Route::post('/supplier-panel/apps/telegram/store', [SupplierAppsController::class, 'store_telegram_notification'])->name('app.store-telegram-notification');
                Route::post('/supplier-panel/apps/telegram/update/{id}', [SupplierAppsController::class, 'update_telegram_notification'])->name('app.update-telegram-notification');
                Route::delete('/supplier-panel/apps/telegram/delete/{id}', [SupplierAppsController::class, 'delete_telegram_notification'])->name('app.delete-telegram-notification');
                // clarity
                Route::get('/supplier-panel/apps/clarity', [SupplierAppsController::class, 'clarity'])->name('app.clarity');
                Route::post('/supplier-panel/apps/clarity/store', [SupplierAppsController::class, 'store_clarity'])->name('app.store-clarity');
                Route::post('/supplier-panel/apps/clarity/update/{id}', [SupplierAppsController::class, 'update_clarity'])->name('app.update-clarity');
                Route::delete('/supplier-panel/apps/clarity/delete/{id}', [SupplierAppsController::class, 'delete_clarity'])->name('app.delete-clarity');
                // supplier billing routes
                Route::get('/supplier-panel/billing', [SupplierBillingController::class, 'index'])->name('billing');
                Route::get('/supplier-panel/billing/invoice/create', [SupplierBillingController::class, 'create'])->name('billing.invoice.create');
                Route::get('/supplier-panel/billing/invoice/{id}', [SupplierBillingController::class, 'show'])->name('billing.invoice.show');
                Route::post('/supplier-panel/billing/pay/invoice/{id}/redirect', [SupplierBillingController::class, 'invoice_redirect'])->name('billing.invoice.redirect');
                Route::post('/supplier-panel/billing/pay/invoice', [SupplierBillingController::class, 'pay_invoice'])->name('billing.invoice.pay');
                Route::delete('/supplier-panel/billing/invoice/{invoice}/delete-proof', [SupplierBillingController::class, 'deleteProof'])->name('billing.invoice.deleteProof');
                //suppliere payments_proofs_refuseds
                Route::get('/supplier-panel/payments-proofs-refuseds', [SupplierPaymentsProofsRefusedController::class, 'index'])->name('payments_proofs_refuseds');
                Route::get('/supplier-panel/payments-proofs-refused/{id}/show', [SupplierPaymentsProofsRefusedController::class, 'show'])->name('payments_proofs_refused.show');
                //supplier proofs refused messages routes
                Route::prefix('/supplier-panel/proofs-refused/{proofId}/chat')->name('proofs.refused.chat.')->group(function () {
                    Route::get('/', [SupplierProofsRefusedChatController::class, 'index'])->name('index');
                    Route::get('/get_messages', [SupplierProofsRefusedChatController::class, 'getMessages'])->name('get_messages');
                    Route::post('/read', [SupplierProofsRefusedChatController::class, 'readMessages'])->name('read');
                    Route::post('/send', [SupplierProofsRefusedChatController::class, 'sendMessage'])->name('send');
                    Route::get('/fetch', [SupplierProofsRefusedChatController::class, 'fetchMessages'])->name('fetch');
                });
                
                // Wallet Routes
                Route::get('/supplier-panel/wallet', [SupplierWalletController::class, 'index'])->name('wallet');
                // Route::post('/supplier-panel/wallet/charge',[SupplierWalletController::class,'charge'])->name('wallet.charge');
                Route::get('/supplier-panel/wallet/addition/{id}', [SupplierWalletController::class, 'showAddition'])->name('get_wallet');
                Route::post('/supplier-panel/wallet/recharge/baridimob', [SupplierWalletController::class, 'payWithBaridiMob'])->name('wallet.recharge.baridimob');
                Route::post('/supplier-panel/wallet/recharge/ccp', [SupplierWalletController::class, 'payWithCcp'])->name('wallet.recharge.ccp');
                // supplier pay subscription routes here
                Route::get('/supplier-panel/subscription', [SupplierSubscriptionController::class, 'index'])->name('subscription');
                Route::post('/supplier-panel/subscription/pay_method/redirect', [SupplierSubscriptionController::class, 'redirect'])->name('subscription.paymethod.redirect');
                Route::post('/supplier-panel/subscription/pay/baridimob', [SupplierSubscriptionController::class, 'baridimob'])->name('subscription.payment.baridimob');
                Route::post('/supplier-panel/subscription/pay/ccp', [SupplierSubscriptionController::class, 'ccp'])->name('subscription.payment.ccp');
                Route::post('/supplier-panel/subscription/pay/wallet', [SupplierSubscriptionController::class, 'wallet'])->name('subscription.payment.wallet');
                // Page Routes
                Route::put('/supplier-panel/page/update/{id}', [SupplierPageController::class, 'update'])->name('page.update');
                // fqs section routes
                // Route::get('/supplier-panel/page/fqs', [SupplierFqsController::class, 'index'])->name('page.fqs');
                Route::get('/supplier-panel/page/section/faqs', [SupplierFqsController::class, 'index'])->name('faqs.index');
                Route::post('/supplier-panel/page/section/faqs', [SupplierFqsController::class, 'store'])->name('faqs.store');
                Route::get('/supplier-panel/page/section/faqs/{supplierFqa}/edit', [SupplierFqsController::class, 'edit'])->name('faqs.edit');
                Route::put('/supplier-panel/page/section/faqs/{supplierFqa}/update', [SupplierFqsController::class, 'update'])->name('faqs.update');
                Route::delete('/supplier-panel/page/section/faqs/{supplierFqa}/delete', [SupplierFqsController::class, 'destroy'])->name('faqs.destroy');
                Route::post('/supplier-panel/page/section/faqs/status/update', [SupplierFqsController::class, 'updateStatus'])->name('faqs.updateStatus');
                // slider section routes
                Route::get('/supplier-panel/page/section/sliders', [SupplierSliderController::class, 'index'])->name('sliders.index');
                Route::post('/supplier-panel/page/section/sliders', [SupplierSliderController::class, 'store'])->name('sliders.store');
                Route::get('/supplier-panel/page/section/sliders/{supplierSlider}/edit', [SupplierSliderController::class, 'edit'])->name('sliders.edit');
                Route::put('/supplier-panel/page/section/sliders/{supplierSlider}/update', [SupplierSliderController::class, 'update'])->name('sliders.update');
                Route::delete('/supplier-panel/page/section/sliders/{supplierSlider}/delete', [SupplierSliderController::class, 'destroy'])->name('sliders.destroy');
                Route::post('/supplier-panel/page/section/sliders/status/update', [SupplierSliderController::class, 'updateStatus'])->name('sliders.updateStatus');
                // category section routes
                Route::get('/supplier-panel/page/section/categories', [SupplierCategoryController::class, 'index'])->name('categories.index');
                Route::post('/supplier-panel/page/section/global/categories', [SupplierCategoryController::class, 'storeGlobalCategory'])->name('categories.global.store');
                Route::get('/supplier-panel/page/section/global/categories/{supplierCategory}/edit', [SupplierCategoryController::class, 'globaledit'])->name('categories.global.edit');
                Route::get('/supplier-panel/page/section/store/categories/{supplierCategory}/edit', [SupplierCategoryController::class, 'storeedit'])->name('categories.store.edit');
                Route::put('/supplier-panel/page/section/global/categories/{supplierCategory}/update', [SupplierCategoryController::class, 'globalupdate'])->name('categories.global.update');
                Route::delete('/supplier-panel/page/section/global/categories/{supplierCategory}/delete', [SupplierCategoryController::class, 'globaldestroy'])->name('categories.global.destroy');
                Route::post('/supplier-panel/page/section/store/categories', [SupplierCategoryController::class, 'storeStoreCategory'])->name('categories.store.store');
                Route::put('/supplier-panel/page/section/store/categories/{supplierCategory}/update', [SupplierCategoryController::class, 'storeupdate'])->name('categories.store.update');
                Route::delete('/supplier-panel/page/section/store/categories/{supplierCategory}/delete', [SupplierCategoryController::class, 'storedestroy'])->name('categories.store.destroy');
                Route::post('/supplier-panel/page/section/categories/status/update', [SupplierCategoryController::class, 'updateStatus'])->name('categories.updateStatus');
                // benefits section routes
                Route::get('/supplier-panel/page/section/benefits/elements/', [SupplierBenefitController::class, 'index'])->name('benefits.element.index');
                Route::post('/supplier-panel/page/section/benefits/elements/', [SupplierBenefitController::class, 'store'])->name('benefits.element.store');
                Route::get('/supplier-panel/page/section/benefits/elements/{id}/edit', [SupplierBenefitController::class, 'edit'])->name('benefits.element.edit');
                Route::put('/supplier-panel/page/section/benefits/elements/{id}/update', [SupplierBenefitController::class, 'update'])->name('benefits.element.update');
                Route::delete('/supplier-panel/page/section/benefits/elements/{id}/delete', [SupplierBenefitController::class, 'destroy'])->name('benefits.element.destroy');
                Route::get('/supplier-panel/page/section/benefits/{id}/edit', [SupplierBenefitController::class, 'benefitsEdit'])->name('benefits.edit');
                Route::put('/supplier-panel/page/section/benefits/{id}/update', [SupplierBenefitController::class, 'benefitsUpdate'])->name('benefits.update');
                Route::post('/supplier-panel/page/section/benefits/status/update', [SupplierBenefitController::class, 'updateStatus'])->name('benefits.updateStatus');
                // order_form section routes
                Route::get('/supplier-panel/page/section/order-form', [SupplierOrderFormController::class, 'index'])->name('order-form.index');
                Route::post('/supplier-panel/page/section/order-form/update-order-form', [SupplierOrderFormController::class, 'updateOrderForm'])->name('order-form.update-order-form');
            });
            Route::post('/supplier-panel/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
            // subscription routes here
            Route::post('/supplier-panel/subscription/pay/new-subscription/baridimob', [SupplierSubscriptionController::class, 'new_subscription_by_baridimob'])->name('new.subscription.payment.baridimob');
            Route::post('/supplier-panel/subscription/pay/new-subscription/ccp', [SupplierSubscriptionController::class, 'new_subscription_by_ccp'])->name('new.subscription.payment.ccp');
            Route::get('/supplier-panel/subscription/confirmation', [SupplierSubscriptionController::class, 'confirmation'])->name('subscription.confirmation')->middleware('SuppliersRedirectSubscriber');
            Route::post('/supplier-panel/order/plan/{id}', [SupplierSubscriptionController::class, 'order_plan'])->name('subscription.order.plan');

            // supplier plan routes here
            Route::get('/supplier-panel/plan-pricing/{plan_id}', [SupplierPlanController::class, 'plan_pricing'])->name('plan_pricing');
            // supplier plan Authorization routes here
            Route::get('/supplier-panel/plan-authorization/{plan_id}', [SupplierPlanController::class, 'plan_authorization'])->name('plan_authorization');
            // supplier payment routes here
            Route::post('/supplier-panel/payment/redirect', [SupplierPaymentController::class, 'redirect'])->name('payment.redirect');
            Route::get('/supplier-panel/payment/algerian_credit_card', [SupplierPaymentController::class, 'algerian_credit_card'])->name('payment.algerian_credit_card');
            Route::get('/supplier-panel/payment/baridimob', [SupplierPaymentController::class, 'baridimob'])->name('payment.baridimob');
            Route::get('/supplier-panel/payment/ccp', [SupplierPaymentController::class, 'ccp'])->name('payment.ccp');
            // //chargily routes
            // Route::post('supplier-panel/chargilypay/redirect', [ChargilyPayController::class, 'redirect'])->name('chargilypay.redirect');
            // Route::get('supplier-panel/chargilypay/back', [ChargilyPayController::class, 'back'])->name('chargilypay.back');
        });
        // chargily routes
        Route::post('supplier-panel/chargilypay/redirect', [ChargilyPayController::class, 'redirect'])->name('chargilypay.redirect');
        Route::get('supplier-panel/chargilypay/back', [ChargilyPayController::class, 'back'])->name('chargilypay.back');
        // authentication routes here
        Route::middleware('guest')->group(function () {
            Route::get('/supplier-panel/register', [RegistredSupplierController::class, 'create'])->name('register');
            Route::post('/supplier-panel/register', [RegistredSupplierController::class, 'store']);
            Route::get('/supplier-panel/login', [AuthenticatedSessionController::class, 'create'])->name('login');
            Route::post('/supplier-panel/login', [AuthenticatedSessionController::class, 'login']);
            // forget password routes here
            Route::get('/supplier-panel/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
            Route::post('/supplier-panel/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
            Route::post('/supplier-panel/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
            // chargily webhook routes here
            // Route::post('supplier-panel/chargilypay/webhook', [ChargilyPayController::class, 'webhook'])->name('chargilypay.webhook_endpoint');
        });
    });
    // store routes here
});
