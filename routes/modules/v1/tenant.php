<?php

declare(strict_types=1);

use App\Http\Controllers\Tenants\TenantsController;
use App\Services\Users\Suppliers\GoogleSheetService;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::name('tenant.')->group(function () {
        // Route::get('/', function () {
        //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
        // });
        Route::middleware('StoreVisibility')->group(function () {
            Route::get('/', [TenantsController::class, 'index'])->name('store');
            // store pages
            Route::get('/about', [TenantsController::class, 'about'])->name('about');
            Route::get('/privacy-policy', [TenantsController::class, 'privacy_policy'])->name('privacy-policy');
            Route::get('/terms-of-use', [TenantsController::class, 'terms_of_use'])->name('terms-of-use');
            Route::get('/contact-us', [TenantsController::class, 'contact_us'])->name('contact-us');
            Route::get('/exchange-policy', [TenantsController::class, 'exchange_policy'])->name('exchange-policy');
            Route::get('/shipping-policy', [TenantsController::class, 'shipping_policy'])->name('shipping-policy');
            Route::get('/payment-policy', [TenantsController::class, 'payment_policy'])->name('payment-policy');
            Route::get('/faq', [TenantsController::class, 'faq'])->name('faq');
            Route::get('/categories', [TenantsController::class, 'categories'])->name('categories');
            // store products
            Route::get('/products', [TenantsController::class, 'products'])->name('products');
            Route::get('/product/{id}', [TenantsController::class, 'product'])->name('product');
            Route::get('/products-by-category/{id}', [TenantsController::class, 'products_by_category'])->name('products-by-category');
            Route::get('/products/products-search', [TenantsController::class, 'products_search'])->name('products-search');
            // store cart
            Route::get('/cart', [TenantsController::class, 'cart'])->name('cart');
            // store checkout
            Route::get('/checkout', [TenantsController::class, 'checkout'])->name('checkout');
            // store checkout
            Route::post('/order_with_items', [TenantsController::class, 'order_with_items'])->name('order-with-items')->middleware('BlockFakeOrder');
            // store checkout
            Route::get('/checkout/success', [TenantsController::class, 'checkout_success'])->name('checkout-success');
            // store checkout
            Route::get('/checkout/cancel', [TenantsController::class, 'checkout_cancel'])->name('checkout-cancel');
            // store payments
            Route::get('/payments/chargily_pay/{order_id}', [TenantsController::class, 'show_chargily_pay'])->name('payments.show_chargily_pay')->middleware('ChargilyPayOk');
            Route::post('/payments/chargily_pay/pay', [TenantsController::class, 'chargily_pay'])->name('payments.chargily_pay');
            Route::get('/payments/verments_pay/{order_id}', [TenantsController::class, 'show_verments_pay'])->name('payments.show_verments_pay')->middleware('VermentPayOk');
            Route::post('/payments/verments_pay/pay', [TenantsController::class, 'verments_pay'])->name('payments.verments_pay');
            // order
            Route::post('/order', [TenantsController::class, 'order'])->name('order')->middleware('BlockFakeOrder');
            // order abandoned
            Route::post('/order-abandoned', [TenantsController::class, 'order_abandoned'])->name('order-abandoned');
            // thanks
            Route::get('/thanks', [TenantsController::class, 'thanks'])->name('thanks');
            // cart
            Route::post('/add-to-cart', [TenantsController::class, 'add_to_cart'])->name('add-to-cart');
            Route::get('/remove-from-cart/{id}', [TenantsController::class, 'remove_from_cart'])->name('remove-from-cart');
            Route::get('/remove-from-cart-variation/{item_id}/{variation_id}/{attribute_id}', [TenantsController::class, 'remove_from_cart_variation'])->name('remove-from-cart-variation');
            Route::get('/remove-all-from-cart', [TenantsController::class, 'remove_all_from_cart'])->name('remove-all-from-cart');
            Route::get('/update-quantity/increment/{id}/{variation_id}/{attribute_id}', [TenantsController::class, 'increment'])->name('update-quantity.increment');
            Route::get('/update-quantity/decrement/{id}/{variation_id}/{attribute_id}', [TenantsController::class, 'decrement'])->name('update-quantity.decrement');
            Route::post('/update-cart-quantity', [TenantsController::class, 'updateQuantity'])->name('update-cart-quantity');
            // get dayra response
            Route::post('/get-dayras/{wilaya_id}', [TenantsController::class, 'get_dayras'])->name('get-dayras');
            // get wilaya data
            Route::post('get-wilaya-data/{wilaya_id}', [TenantsController::class, 'get_wilaya_data'])->name('get-wilaya-data');
            // get wilaya data
            Route::post('get-dayra-data/{dayra_id}', [TenantsController::class, 'get_dayra_data'])->name('get-dayra-data');
            // get baladia response
            Route::post('/get-baladias/{dayra_id}', [TenantsController::class, 'get_baladias'])->name('get-baladias');
            // get shipping price
            Route::post('/get-shipping-prices/{wilaya_id}', [TenantsController::class, 'get_shipping_prices'])->name('get-shipping-prices');
            // fetch coupon
            Route::get('/coupons/fetch-coupon', [TenantsController::class, 'fetchCoupon'])->name('coupons.fetchCoupon');
            // fetch coupon in product details
            Route::get('/coupons/product/fetch-coupon', [TenantsController::class, 'productFetchCoupon'])->name('coupons.product.fetchCoupon');

            Route::get('/test-sheet', function (GoogleSheetService $sheet) {
                $result = $sheet->addOrder([
                    'id' => 'test_'.time(),
                    'customerName' => 'Test Customer',
                    'total' => 100.50,
                ]);

                dd($result);
            });
            // ----end tenant group name
        });
    });
});

// Route::get('/', function () {
//     dd(\App\Models\User::all());
//     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
// });
