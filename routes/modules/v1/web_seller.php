<?php

use App\Http\Controllers\ChargilyPayController;
use App\Http\Controllers\Users\CourierdzController;
use App\Http\Controllers\Users\Sellers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Users\Sellers\Auth\NewPasswordController;
use App\Http\Controllers\Users\Sellers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Users\Sellers\Auth\RegistredSellerController;
use App\Http\Controllers\Users\Sellers\SellerAppsController;
use App\Http\Controllers\Users\Sellers\SellerAttributeController;
use App\Http\Controllers\Users\Sellers\SellerBenefitController;
use App\Http\Controllers\Users\Sellers\SellerBillingController;
use App\Http\Controllers\Users\Sellers\SellerCategoriesCouponsController;
use App\Http\Controllers\Users\Sellers\SellerCategoryController;
use App\Http\Controllers\Users\Sellers\SellerController;
use App\Http\Controllers\Users\Sellers\SellerCouponController;
use App\Http\Controllers\Users\Sellers\SellerCustomerBlockListController;
use App\Http\Controllers\Users\Sellers\SellerFqsController;
use App\Http\Controllers\Users\Sellers\SellerOrderAbandonedController;
use App\Http\Controllers\Users\Sellers\SellerOrderController;
use App\Http\Controllers\Users\Sellers\SellerOrderFormController;
use App\Http\Controllers\Users\Sellers\SellerPageController;
use App\Http\Controllers\Users\Sellers\SellerPaymentController;
use App\Http\Controllers\Users\Sellers\SellerPaymentsProofsRefusedController;
use App\Http\Controllers\Users\Sellers\SellerPlanController;
use App\Http\Controllers\Users\Sellers\SellerProductController;
use App\Http\Controllers\Users\Sellers\SellerProductsCouponsController;
use App\Http\Controllers\Users\Sellers\SellerProfileController;
use App\Http\Controllers\Users\Sellers\SellerProofsRefusedChatController;
use App\Http\Controllers\Users\Sellers\SellerSettingController;
use App\Http\Controllers\Users\Sellers\SellerShippingController;
use App\Http\Controllers\Users\Sellers\SellerSliderController;
use App\Http\Controllers\Users\Sellers\SellerSubscriptionController;
use App\Http\Controllers\Users\Sellers\SellerWalletController;
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
        Route::name('seller.')->group(function () {
            Route::middleware('auth')->group(function () {
                // unusing routes withoute verification payment
                Route::middleware('verifysellerpaiment')->group(function () {
                    Route::get('/seller-panel', [SellerController::class, 'index'])->name('index');
                    Route::get('/seller-panel/admin', [SellerController::class, 'index'])->name('admin');
                    Route::get('/seller-panel/dashboard', [SellerController::class, 'index'])->name('dashboard');
                    // get wilaya data
                    Route::get('/seller-panel/get-wilaya-data/{id}', [SellerController::class, 'get_wilaya_data'])->name('get-wilaya-data');
                    // get dayra
                    Route::post('/seller-panel/get-dayras/', [SellerController::class, 'get_dayras'])->name('get-dayras');
                    // get baladia
                    Route::post('seller-panel/get-baladias/', [SellerController::class, 'get_baladias'])->name('get-baladias');
                    // seller profile routes
                    Route::get('/seller-panel/profile', [SellerProfileController::class, 'index'])->name('profile');
                    Route::post('/seller-panel/profile/update', [SellerProfileController::class, 'update'])->name('profile.update');
                    // seller password routes
                    Route::post('/seller-panel/profile/password/update', [SellerProfileController::class, 'update_password'])->name('profile.password.update');
                    // suuplier create or update chargily pay settings
                    Route::post('/seller-panel/profile/chargily/update', [SellerProfileController::class, 'create_or_update_chargily_settings'])->name('profile.chargily-settings.update');
                    Route::delete('/seller-panel/profile/chargily/delete', [SellerProfileController::class, 'delete_chargily_settings'])->name('profile.chargily-settings.delete');
                    // suuplier create or update bank settings
                    Route::post('/seller-panel/profile/bank/update', [SellerProfileController::class, 'create_or_update_bank_settings'])->name('profile.bank-settings.update');
                    Route::delete('/seller-panel/profile/bank/delete', [SellerProfileController::class, 'delete_bank_settings'])->name('profile.bank-settings.delete');
                    // /seller update-avatar
                    Route::post('/seller-panel/profile/update-avatar', [SellerProfileController::class, 'update_avatar'])->name('profile.update-avatar');
                    // seller settings routes
                    Route::get('/seller-panel/settings', [SellerSettingController::class, 'index'])->name('settings');
                    Route::post('/seller-panel/settings/theme-update/{user_id}', [SellerSettingController::class, 'theme_update'])->name('theme-update');
                    Route::put('/seller-panel/settings/update', [SellerSettingController::class, 'update'])->name('settings.update');
                    Route::get('/seller-panel/clear-tab-flag', function () {
                        session()->forget('activate_store_tab');
                        session()->forget('activate_security_tab');
                        session()->forget('activate_chargily_tab');

                        return response()->json(['success' => true]);
                    })->name('clear.tab.flag');
                    // seller products routes
                    Route::get('/seller-panel/products', [SellerProductController::class, 'index'])->name('products');
                    Route::post('/seller-panel/product/create', [SellerProductController::class, 'create'])->name('product.create');
                    Route::get('/seller-panel/product/edit/{id}', [SellerProductController::class, 'edit'])->name('product.edit');
                    Route::post('/seller-panel/product/update/{id}', [SellerProductController::class, 'update'])->name('product.update');
                    Route::delete('/seller-panel/product/delete/{id}', [SellerProductController::class, 'delete'])->name('product.delete');
                    Route::delete('/seller-panel/product/image/delete/{id}', [SellerProductController::class, 'delete_product_image'])->name('product.delete_product_image');
                    Route::delete('/seller-panel/product/video/delete/{id}', [SellerProductController::class, 'delete_product_video'])->name('product.delete_product_video');
                    Route::delete('/seller-panel/product/variant/delete/{id}', [SellerProductController::class, 'delete_product_variation'])->name('product.delete_product_variation');
                    Route::delete('/seller-panel/product/discount/delete/{id}', [SellerProductController::class, 'delete_product_discount'])->name('product.delete_product_discount');
                    Route::delete('/seller-panel/product/attributes/delete/{id}', [SellerProductController::class, 'delete_product_attribute'])->name('product.delete_product_attribute');
                    Route::get('/seller-panel/product/get-json-data/{id}', [SellerProductController::class, 'get_json_data'])->name('product.get_json_data');
                    Route::get('/seller-panel/filter-products', [SellerProductController::class, 'filterProducts'])->name('product.filterProducts');
                    // seller coupons routes
                    Route::get('/seller-panel/coupons', [SellerCouponController::class, 'index'])->name('coupons');
                    Route::post('/seller-panel/coupons/store', [SellerCouponController::class, 'store'])->name('coupons.store');
                    Route::get('/seller-panel/coupons/{id}/edit', [SellerCouponController::class, 'edit'])->name('coupons.edit');
                    Route::put('/seller-panel/coupons/{id}/update', [SellerCouponController::class, 'update'])->name('coupons.update');
                    Route::delete('/seller-panel/coupons/destroy/{id}', [SellerCouponController::class, 'destroy'])->name('coupons.destroy');
                    // seller products coupons
                    Route::get('/seller-panel/products-coupons', [SellerProductsCouponsController::class, 'index'])->name('products-coupons');
                    Route::post('/seller-panel/products-coupons/store', [SellerProductsCouponsController::class, 'store'])->name('products-coupons.store');
                    Route::delete('/seller-panel/products-coupons/destroy/{id}', [SellerProductsCouponsController::class, 'destroy'])->name('products-coupons.destroy');
                    // seller categories coupons
                    Route::get('/seller-panel/categories-coupons', [SellerCategoriesCouponsController::class, 'index'])->name('categories-coupons');
                    Route::post('/seller-panel/categories-coupons/store', [SellerCategoriesCouponsController::class, 'store'])->name('categories-coupons.store');
                    Route::delete('/seller-panel/categories-coupons/destroy/{id}', [SellerCategoriesCouponsController::class, 'destroy'])->name('categories-coupons.destroy');
                    // Route::resource('/seller-panel/coupons',[SellerCouponController::class,'index'])->name('coupons');
                    Route::get('/seller-panel/coupons/filter', [SellerCouponController::class, 'filter'])->name('coupons.filter');
                    Route::get('/seller-panel/coupons/list', [SellerCouponController::class, 'list'])->name('coupons.list');
                    // seller attribute routes
                    Route::post('/seller-panel/attributes/create', [SellerAttributeController::class, 'create'])->name('attribute.create_attribute');
                    Route::post('/seller-panel/attributes/user/{id}', [SellerAttributeController::class, 'get_user_attributes'])->name('attribute.get_user_attribute');
                    Route::delete('/seller-panel/attributes/delete/{id}', [SellerAttributeController::class, 'delete_attribute'])->name('attribute.delete_attribute');
                    // seller orders routes
                    Route::get('/seller-panel/orders', [SellerOrderController::class, 'index'])->name('orders');
                    Route::get('/seller-panel/order/{id}', [SellerOrderController::class, 'order'])->name('order');
                    Route::delete('/seller-panel/order/delete/{id}', [SellerOrderController::class, 'delete_order'])->name('order.delete');
                    Route::get('/seller-panel/filter-orders', [SellerOrderController::class, 'filterOrders'])->name('order.filterOrders');
                    Route::post('/seller-panel/update-order-status', [SellerOrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');
                    Route::post('/seller-panel/update-confirmation-status', [SellerOrderController::class, 'updateConfirmationStatus'])->name('order.updateConfirmationStatus');
                    Route::post('/seller-panel/order/{order}/accept-payment', [SellerOrderController::class, 'acceptPayment'])->name('order.acceptPayment');
                    Route::post('/seller-panel/order/{order}/reject-payment', [SellerOrderController::class, 'rejectPayment'])->name('order.rejectPayment');

                    Route::get('/seller-panel/order/edit/{id}', [SellerOrderController::class, 'edit_order'])->name('order.edit');
                    Route::put('/seller-panel/order/update/{id}', [SellerOrderController::class, 'update_order'])->name('order.update');
                    // seller order details routes
                    Route::get('/seller-panel/delete-order-item/{id}', [SellerOrderController::class, 'order_item_delete'])->name('order-item.delete');
                    Route::delete('/seller-panel/order-item/delete/{id}', [SellerOrderController::class, 'deleteItem'])->name('order.item.delete');
                    // seller orders abandoned routes
                    Route::get('/seller-panel/orders-abandoned', [SellerOrderAbandonedController::class, 'index'])->name('orders-abandoned');
                    Route::get('/seller-panel/order-abandoned/{id}', [SellerOrderAbandonedController::class, 'order'])->name('order-abandoned');
                    Route::delete('/seller-panel/order-abadoned/delete/{id}', [SellerOrderAbandonedController::class, 'delete_order'])->name('order-abandoned.delete');
                    Route::get('/seller-panel/filter-orders-abandoned', [SellerOrderAbandonedController::class, 'filterOrders'])->name('order.filterOrdersAbandoned');
                    Route::post('/seller-panel/update-order-abandoned-status', [SellerOrderAbandonedController::class, 'updateOrderStatus'])->name('order.updateOrderAbandonedStatus');
                    Route::post('/seller-panel/order-abandoned/move-to-order', [SellerOrderAbandonedController::class, 'move_to_order'])->name('order.move_to_order');
                    // traking order
                    Route::get('/seller-panel/order/tracking/{id}', [SellerOrderController::class, 'tracking_order'])->name('order.tracking');
                    Route::get('/seller-panel/order/tracking/delete/{id}', [SellerOrderController::class, 'delete_tracking_order'])->name('order.delete-tracking');
                    // unlock phone number
                    Route::post('/seller-panel/order/unlock-phone-number/{order_id}', [SellerOrderController::class, 'unlock_phone_number'])->name('order.unlock-phone-number');
                    Route::post('/seller-panel/order-abandoned/unlock-phone-number/{order_id}', [SellerOrderAbandonedController::class, 'unlock_phone_number'])->name('order-abandoned.unlock-phone-number');
                    // seller customer block list routes
                    Route::get('/seller-panel/customer-block-list', [SellerCustomerBlockListController::class, 'index'])->name('customer-block-list');
                    Route::post('/seller-panel/customer-block-list/create/{order_id}', [SellerCustomerBlockListController::class, 'create'])->name('customer-block-list.create');
                    Route::post('/seller-panel/customer-block-list/is-blocked/{id}', [SellerCustomerBlockListController::class, 'is_blocked'])->name('customer-block-list.is-blocked');
                    // seller shipping routes
                    Route::get('/seller-panel/shipping', [SellerShippingController::class, 'index'])->name('shipping');
                    Route::get('/seller-panel/shipping/pricing/edit', [SellerShippingController::class, 'edit'])->name('shipping.edit');
                    Route::post('/seller-panel/shipping/pricing/update', [SellerShippingController::class, 'update'])->name('shipping.update');
                    Route::post('/seller-panel/shipping/get-shipping-cost', [SellerShippingController::class, 'get_shipping_cost'])->name('shipping.get-shipping-cost');
                    // seller shipping company routes
                    Route::post('/seller-panel/shipping-company/create', [SellerShippingController::class, 'add_shipping_company'])->name('shipping-company.create');
                    Route::delete('/seller-panel/shipping-company/delete/{id}', [SellerShippingController::class, 'delete_shipping_company'])->name('shipping-company.delete');
                    Route::post('/seller-panel/update-shipping-status', [SellerShippingController::class, 'updateShippingStatus'])->name('shipping-company.update-status');
                    // courier dz routes
                    Route::post('/seller-panel/courier-dz/test-credentials', [CourierdzController::class, 'testCredentials'])->name('courier-dz.testCredentials');
                    Route::post('/seller-panel/courier-dz/createOrder', [CourierdzController::class, 'createOrder'])->name('courier-dz.createOrder');

                    // seller application routes
                    Route::get('/seller-panel/apps', [SellerAppsController::class, 'index'])->name('apps');
                    // google analitycs
                    Route::get('/seller-panel/apps/google-analytics', [SellerAppsController::class, 'google_analytics'])->name('app.google-analytics');
                    Route::post('/seller-panel/apps/google-analytics/store', [SellerAppsController::class, 'store_google_analytics'])->name('app.store-google-analytics');
                    Route::post('/seller-panel/apps/google-analytics/update/{id}', [SellerAppsController::class, 'update_google_analytics'])->name('app.update-google-analytics');
                    Route::delete('/seller-panel/apps/google-analytics/delete/{id}', [SellerAppsController::class, 'delete_google_analytics'])->name('app.delete-google-analytics');
                    Route::post('/seller-panel/apps/google-analytics/get', [SellerAppsController::class, 'get_google_analytics'])->name('app.get-google-analytics');
                    // facebook pixl
                    Route::get('/seller-panel/apps/facebook-pixel', [SellerAppsController::class, 'facebook_pixel'])->name('app.facebook-pixel');
                    Route::post('/seller-panel/apps/facebook-pixel/store', [SellerAppsController::class, 'store_facebook_pixel'])->name('app.store-facebook-pixel');
                    Route::post('/seller-panel/apps/facebook-pixel/update/{id}', [SellerAppsController::class, 'update_facebook_pixel'])->name('app.update-facebook-pixel');
                    Route::delete('/seller-panel/apps/facebook-pixel/delete/{id}', [SellerAppsController::class, 'delete_facebook_pixel'])->name('app.delete-facebook-pixel');
                    // tiktok pixle
                    Route::get('/seller-panel/apps/tiktok-pixel', [SellerAppsController::class, 'tiktok_pixel'])->name('app.tiktok-pixel');
                    Route::post('/seller-panel/apps/tiktok-pixel/store', [SellerAppsController::class, 'store_tiktok_pixel'])->name('app.store-tiktok-pixel');
                    Route::post('/seller-panel/apps/tiktok-pixel/update/{id}', [SellerAppsController::class, 'update_tiktok_pixel'])->name('app.update-tiktok-pixel');
                    Route::delete('/seller-panel/apps/tiktok-pixel/delete/{id}', [SellerAppsController::class, 'delete_tiktok_pixel'])->name('app.delete-tiktok-pixel');
                    // google sheet
                    Route::get('/seller-panel/apps/google-sheet', [SellerAppsController::class, 'google_sheet'])->name('app.google-sheet');
                    Route::post('/seller-panel/apps/google-sheet/store', [SellerAppsController::class, 'store_google_sheets'])->name('app.store-google-sheet');
                    Route::post('/seller-panel/apps/google-sheet/update/{id}', [SellerAppsController::class, 'update_google_sheets'])->name('app.update-google-sheet');
                    Route::delete('/seller-panel/apps/google-sheet/delete/{id}', [SellerAppsController::class, 'delete_google_sheets'])->name('app.delete-google-sheet');
                    // telegrarm notification
                    Route::get('/seller-panel/apps/telegram-notifications', [SellerAppsController::class, 'telegram_notifications'])->name('app.telegram-notifications');
                    Route::post('/seller-panel/apps/telegram/store', [SellerAppsController::class, 'store_telegram_notification'])->name('app.store-telegram-notification');
                    Route::post('/seller-panel/apps/telegram/update/{id}', [SellerAppsController::class, 'update_telegram_notification'])->name('app.update-telegram-notification');
                    Route::delete('/seller-panel/apps/telegram/delete/{id}', [SellerAppsController::class, 'delete_telegram_notification'])->name('app.delete-telegram-notification');
                    // clarity
                    Route::get('/seller-panel/apps/clarity', [SellerAppsController::class, 'clarity'])->name('app.clarity');
                    Route::post('/seller-panel/apps/clarity/store', [SellerAppsController::class, 'store_clarity'])->name('app.store-clarity');
                    Route::post('/seller-panel/apps/clarity/update/{id}', [SellerAppsController::class, 'update_clarity'])->name('app.update-clarity');
                    Route::delete('/seller-panel/apps/clarity/delete/{id}', [SellerAppsController::class, 'delete_clarity'])->name('app.delete-clarity');
                    // seller billing routes
                    Route::get('/seller-panel/billing', [SellerBillingController::class, 'index'])->name('billing');
                    Route::get('/seller-panel/billing/invoice/create', [SellerBillingController::class, 'create'])->name('billing.invoice.create');
                    Route::get('/seller-panel/billing/invoice/{id}', [SellerBillingController::class, 'show'])->name('billing.invoice.show');
                    Route::post('/seller-panel/billing/pay/invoice/{id}/redirect', [SellerBillingController::class, 'invoice_redirect'])->name('billing.invoice.redirect');
                    Route::post('/seller-panel/billing/pay/invoice', [SellerBillingController::class, 'pay_invoice'])->name('billing.invoice.pay');
                    Route::delete('/seller-panel/billing/invoice/{invoice}/delete-proof', [SellerBillingController::class, 'deleteProof'])->name('billing.invoice.deleteProof');
                    // sellere payments_proofs_refuseds
                    Route::get('/seller-panel/payments-proofs-refuseds', [SellerPaymentsProofsRefusedController::class, 'index'])->name('payments_proofs_refuseds');
                    Route::get('/seller-panel/payments-proofs-refused/{id}/show', [SellerPaymentsProofsRefusedController::class, 'show'])->name('payments_proofs_refused.show');
                    // seller proofs refused messages routes
                    Route::prefix('/seller-panel/proofs-refused/{proofId}/chat')->name('proofs.refused.chat.')->group(function () {
                        Route::get('/', [SellerProofsRefusedChatController::class, 'index'])->name('index');
                        Route::get('/get_messages', [SellerProofsRefusedChatController::class, 'getMessages'])->name('get_messages');
                        Route::post('/read', [SellerProofsRefusedChatController::class, 'readMessages'])->name('read');
                        Route::post('/send', [SellerProofsRefusedChatController::class, 'sendMessage'])->name('send');
                        Route::get('/fetch', [SellerProofsRefusedChatController::class, 'fetchMessages'])->name('fetch');
                    });

                    // Wallet Routes
                    Route::get('/seller-panel/wallet', [SellerWalletController::class, 'index'])->name('wallet');
                    // Route::post('/seller-panel/wallet/charge',[SellerWalletController::class,'charge'])->name('wallet.charge');
                    Route::get('/seller-panel/wallet/addition/{id}', [SellerWalletController::class, 'showAddition'])->name('get_wallet');
                    Route::post('/seller-panel/wallet/recharge/baridimob', [SellerWalletController::class, 'payWithBaridiMob'])->name('wallet.recharge.baridimob');
                    Route::post('/seller-panel/wallet/recharge/ccp', [SellerWalletController::class, 'payWithCcp'])->name('wallet.recharge.ccp');
                    // seller pay subscription routes here
                    Route::get('/seller-panel/subscription', [SellerSubscriptionController::class, 'index'])->name('subscription');
                    Route::post('/seller-panel/subscription/pay_method/redirect', [SellerSubscriptionController::class, 'redirect'])->name('subscription.paymethod.redirect');
                    Route::post('/seller-panel/subscription/pay/baridimob', [SellerSubscriptionController::class, 'baridimob'])->name('subscription.payment.baridimob');
                    Route::post('/seller-panel/subscription/pay/ccp', [SellerSubscriptionController::class, 'ccp'])->name('subscription.payment.ccp');
                    Route::post('/seller-panel/subscription/pay/wallet', [SellerSubscriptionController::class, 'wallet'])->name('subscription.payment.wallet');
                    // Page Routes
                    Route::put('/seller-panel/page/update/{id}', [SellerPageController::class, 'update'])->name('page.update');
                    // fqs section routes
                    // Route::get('/seller-panel/page/fqs', [SellerFqsController::class, 'index'])->name('page.fqs');
                    Route::get('/seller-panel/page/section/faqs', [SellerFqsController::class, 'index'])->name('faqs.index');
                    Route::post('/seller-panel/page/section/faqs', [SellerFqsController::class, 'store'])->name('faqs.store');
                    Route::get('/seller-panel/page/section/faqs/{sellerFqa}/edit', [SellerFqsController::class, 'edit'])->name('faqs.edit');
                    Route::put('/seller-panel/page/section/faqs/{sellerFqa}/update', [SellerFqsController::class, 'update'])->name('faqs.update');
                    Route::delete('/seller-panel/page/section/faqs/{sellerFqa}/delete', [SellerFqsController::class, 'destroy'])->name('faqs.destroy');
                    Route::post('/seller-panel/page/section/faqs/status/update', [SellerFqsController::class, 'updateStatus'])->name('faqs.updateStatus');
                    // slider section routes
                    Route::get('/seller-panel/page/section/sliders', [SellerSliderController::class, 'index'])->name('sliders.index');
                    Route::post('/seller-panel/page/section/sliders', [SellerSliderController::class, 'store'])->name('sliders.store');
                    Route::get('/seller-panel/page/section/sliders/{sellerSlider}/edit', [SellerSliderController::class, 'edit'])->name('sliders.edit');
                    Route::put('/seller-panel/page/section/sliders/{sellerSlider}/update', [SellerSliderController::class, 'update'])->name('sliders.update');
                    Route::delete('/seller-panel/page/section/sliders/{sellerSlider}/delete', [SellerSliderController::class, 'destroy'])->name('sliders.destroy');
                    Route::post('/seller-panel/page/section/sliders/status/update', [SellerSliderController::class, 'updateStatus'])->name('sliders.updateStatus');
                    // category section routes
                    Route::get('/seller-panel/page/section/categories', [SellerCategoryController::class, 'index'])->name('categories.index');
                    Route::post('/seller-panel/page/section/global/categories', [SellerCategoryController::class, 'storeGlobalCategory'])->name('categories.global.store');
                    Route::get('/seller-panel/page/section/global/categories/{sellerCategory}/edit', [SellerCategoryController::class, 'globaledit'])->name('categories.global.edit');
                    Route::get('/seller-panel/page/section/store/categories/{sellerCategory}/edit', [SellerCategoryController::class, 'storeedit'])->name('categories.store.edit');
                    Route::put('/seller-panel/page/section/global/categories/{sellerCategory}/update', [SellerCategoryController::class, 'globalupdate'])->name('categories.global.update');
                    Route::delete('/seller-panel/page/section/global/categories/{sellerCategory}/delete', [SellerCategoryController::class, 'globaldestroy'])->name('categories.global.destroy');
                    Route::post('/seller-panel/page/section/store/categories', [SellerCategoryController::class, 'storeStoreCategory'])->name('categories.store.store');
                    Route::put('/seller-panel/page/section/store/categories/{sellerCategory}/update', [SellerCategoryController::class, 'storeupdate'])->name('categories.store.update');
                    Route::delete('/seller-panel/page/section/store/categories/{sellerCategory}/delete', [SellerCategoryController::class, 'storedestroy'])->name('categories.store.destroy');
                    Route::post('/seller-panel/page/section/categories/status/update', [SellerCategoryController::class, 'updateStatus'])->name('categories.updateStatus');
                    // benefits section routes
                    Route::get('/seller-panel/page/section/benefits/elements/', [SellerBenefitController::class, 'index'])->name('benefits.element.index');
                    Route::post('/seller-panel/page/section/benefits/elements/', [SellerBenefitController::class, 'store'])->name('benefits.element.store');
                    Route::get('/seller-panel/page/section/benefits/elements/{id}/edit', [SellerBenefitController::class, 'edit'])->name('benefits.element.edit');
                    Route::put('/seller-panel/page/section/benefits/elements/{id}/update', [SellerBenefitController::class, 'update'])->name('benefits.element.update');
                    Route::delete('/seller-panel/page/section/benefits/elements/{id}/delete', [SellerBenefitController::class, 'destroy'])->name('benefits.element.destroy');
                    Route::get('/seller-panel/page/section/benefits/{id}/edit', [SellerBenefitController::class, 'benefitsEdit'])->name('benefits.edit');
                    Route::put('/seller-panel/page/section/benefits/{id}/update', [SellerBenefitController::class, 'benefitsUpdate'])->name('benefits.update');
                    Route::post('/seller-panel/page/section/benefits/status/update', [SellerBenefitController::class, 'updateStatus'])->name('benefits.updateStatus');
                    // order_form section routes
                    Route::get('/seller-panel/page/section/order-form', [SellerOrderFormController::class, 'index'])->name('order-form.index');
                    Route::post('/seller-panel/page/section/order-form/update-order-form', [SellerOrderFormController::class, 'updateOrderForm'])->name('order-form.update-order-form');
                });
                Route::post('/seller-panel/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
                // subscription routes here
                Route::post('/seller-panel/subscription/pay/new-subscription/baridimob', [SellerSubscriptionController::class, 'new_subscription_by_baridimob'])->name('new.subscription.payment.baridimob');
                Route::post('/seller-panel/subscription/pay/new-subscription/ccp', [SellerSubscriptionController::class, 'new_subscription_by_ccp'])->name('new.subscription.payment.ccp');
                Route::get('/seller-panel/subscription/confirmation', [SellerSubscriptionController::class, 'confirmation'])->name('subscription.confirmation')->middleware('SellersRedirectSubscriber');
                Route::post('/seller-panel/order/plan/{id}', [SellerSubscriptionController::class, 'order_plan'])->name('subscription.order.plan');

                // seller plan routes here
                Route::get('/seller-panel/plan-pricing/{plan_id}', [SellerPlanController::class, 'plan_pricing'])->name('plan_pricing');
                // seller plan Authorization routes here
                Route::get('/seller-panel/plan-authorization/{plan_id}', [SellerPlanController::class, 'plan_authorization'])->name('plan_authorization');
                // seller payment routes here
                Route::post('/seller-panel/payment/redirect', [SellerPaymentController::class, 'redirect'])->name('payment.redirect');
                Route::get('/seller-panel/payment/algerian_credit_card', [SellerPaymentController::class, 'algerian_credit_card'])->name('payment.algerian_credit_card');
                Route::get('/seller-panel/payment/baridimob', [SellerPaymentController::class, 'baridimob'])->name('payment.baridimob');
                Route::get('/seller-panel/payment/ccp', [SellerPaymentController::class, 'ccp'])->name('payment.ccp');
                // //chargily routes
                // Route::post('seller-panel/chargilypay/redirect', [ChargilyPayController::class, 'redirect'])->name('chargilypay.redirect');
                // Route::get('seller-panel/chargilypay/back', [ChargilyPayController::class, 'back'])->name('chargilypay.back');
            });
            // chargily routes
            Route::post('seller-panel/chargilypay/redirect', [ChargilyPayController::class, 'redirect'])->name('chargilypay.redirect');
            Route::get('seller-panel/chargilypay/back', [ChargilyPayController::class, 'back'])->name('chargilypay.back');
            // authentication routes here
            Route::middleware('guest')->group(function () {
                Route::get('/seller-panel/register', [RegistredSellerController::class, 'create'])->name('register');
                Route::post('/seller-panel/register', [RegistredSellerController::class, 'store']);
                Route::get('/seller-panel/login', [AuthenticatedSessionController::class, 'create'])->name('login');
                Route::post('/seller-panel/login', [AuthenticatedSessionController::class, 'login']);
                // forget password routes here
                Route::get('/seller-panel/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
                Route::post('/seller-panel/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
                Route::post('/seller-panel/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
                // chargily webhook routes here
                // Route::post('seller-panel/chargilypay/webhook', [ChargilyPayController::class, 'webhook'])->name('chargilypay.webhook_endpoint');
            });
        });
    });
}
