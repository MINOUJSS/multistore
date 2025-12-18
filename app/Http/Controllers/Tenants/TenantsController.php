<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Jobs\Users\Suppliers\sendOrderDataToGoogleSheet;
use App\Jobs\Users\suppliers\sendTelegramInfoAboutOrder;
use App\Models\Baladia;
use App\Models\BenefitSectionElements;
use App\Models\Dayra;
use App\Models\ShippingPrice;
use App\Models\Supplier\SupplierFqa;
use App\Models\Supplier\SupplierOrderAbandoned;
use App\Models\Supplier\SupplierOrderAbandonedItems;
use App\Models\Supplier\SupplierOrderItems;
use App\Models\Supplier\SupplierOrders;
use App\Models\Supplier\SupplierPage;
use App\Models\Supplier\SupplierProductAttributes;
use App\Models\Supplier\SupplierProductImages;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierProductsVisits;
use App\Models\Supplier\SupplierProductVariations;
use App\Models\UserBenefitSection;
use App\Models\userCoupons;
use App\Models\UserSlider;
use App\Models\UserStoreCategory;
use App\Models\UserStoreSetting;
use App\Models\Wilaya;
use App\Services\Users\Suppliers\Cart;
use App\Services\Users\Suppliers\GoogleSheetService;
use App\Services\Users\Suppliers\OrderNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TenantsController extends Controller
{
    // protected $googleSheetService;
    protected $orderNotificationService;

    public function __construct(OrderNotificationService $orderNotificationService)
    {
        // $this->googleSheetService = $googleSheetService;
        $this->orderNotificationService = $orderNotificationService;
    }

    // genral index
    public function index()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $store_settings = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->get();
            $benefit_section = UserBenefitSection::where('user_id', get_user_data(tenant('id'))->id)->first();
            $benefit_elements = BenefitSectionElements::where('benefit_section_id', $benefit_section->id)->orderBy('order', 'asc')->get();
            $sliders = UserSlider::where('user_id', get_user_data(tenant('id'))->id)->orderBy('order', 'asc')->get();
            $slider_status = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->where('key', 'store_section_slider_visibility')->first();
            $faqs_status = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->where('key', 'store_section_faqs_visibility')->first();
            $categories_status = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->where('key', 'store_section_categories_visibility')->first();
            $categories = UserStoreCategory::where('user_id', get_user_data(tenant('id'))->id)->get();
            $products = SupplierProducts::where('supplier_id', get_supplier_data(tenant('id'))->id)->get();
            $faqs = SupplierFqa::where('supplier_id', get_supplier_data(tenant('id'))->id)->get();

            // return idex view with user data
            return view('stores.suppliers.index', compact('sliders', 'slider_status', 'categories', 'categories_status', 'products', 'faqs', 'faqs_status', 'store_settings', 'benefit_section', 'benefit_elements'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // about page
    public function about()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-about')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.about', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // privacy policy page
    public function privacy_policy()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-privacy-policy')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.privacy_policy', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // contact us page
    public function contact_us()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-contact-us')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.contact_us', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // exchange policy page
    public function exchange_policy()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-exchange-policy')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.exchange_and_return_policy', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // payment policy page
    public function payment_policy()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-payment-policy')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.payment_methods', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // shipping policy page
    public function shipping_policy()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-shipping-policy')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.shipping_and_handling', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // terms of use page
    public function terms_of_use()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-terms-of-use')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.terms_of_use', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // faqpage
    public function faq()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $page = SupplierPage::where('slug', tenant_to_slug(tenant('id')).'-faq')->first();

            // return idex view with user data
            return view('stores.suppliers.pages.faq', compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // categories page
    public function categories()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $categories = UserStoreCategory::where('user_id', get_user_data(tenant('id'))->id)->get();

            // return idex view with user data
            return view('stores.suppliers.categories', compact('categories'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // products
    public function products()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $products = SupplierProducts::orderBy('id', 'desc')->where('supplier_id', get_supplier_data(tenant('id'))->id)->get();

            // return idex view with user data
            return view('stores.suppliers.products', compact('products'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // search products
    public function products_search(Request $request)
    {
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            $query = SupplierProducts::query();

            if ($request->category) {
                $query->where('category_id', $request->category);
            }

            if ($request->search) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            }
            $search = $request->search;
            $products = $query->where('supplier_id', get_supplier_data(tenant('id'))->id)->get();

            return view('stores.suppliers.products-search', compact('products', 'search'));
        }
    }

    // product details
    public function product($id, Request $request)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // insert this visit to supplier product visit table

            // get order form setting
            $form_settings = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->where('key', 'store_order_form_settings')->first();
            $order_form = json_decode($form_settings->value);

            $wilayas = ShippingPrice::where('user_id', get_user_data(tenant('id'))->id)->where('shipping_available_to_wilaya', 1)->get();
            $product = SupplierProducts::where('supplier_id', get_supplier_data(tenant('id'))->id)->where('id', $id)->first();
            if (!$product) {
                return abort(404);
            }
            $product_images = SupplierProductImages::where('product_id', $product->id)->get();
            $product_variations = SupplierProductVariations::where('product_id', $product->id)->get();
            $product_attributes = SupplierProductAttributes::where('product_id', $product->id)->get();
            // جلب عنوان IP ومعلومات المتصفح
            $ipAddress = $request->ip();
            $userAgent = $request->header('User-Agent');
            $userId = Auth::check() ? Auth::id() : null;

            // التحقق من عدم تسجيل الزيارة سابقًا لتجنب التكرار غير الضروري
            $existingVisit = SupplierProductsVisits::where('product_id', $id)
                ->where('ip_address', $ipAddress)
                ->whereDate('visited_at', now()->toDateString()) // نفس اليوم
                ->first();
            if (!$existingVisit) {
                // إنشاء سجل جديد
                SupplierProductsVisits::create([
                    'product_id' => $id,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'user_id' => $userId,
                    'visited_at' => now(),
                ]);
                ++$product->view_count;
                $product->save();
            }

            // return idex view with user data
            return view('stores.suppliers.product-details', compact('product', 'order_form', 'wilayas', 'product_images', 'product_variations', 'product_attributes'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // products by category
    public function products_by_category($category_id)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            $products = SupplierProducts::where('supplier_id', get_supplier_data(tenant('id'))->id)->where('category_id', $category_id)->get();

            // return idex view with user data
            return view('stores.suppliers.products-by-category', compact('products'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // cart
    public function cart()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            if (session()->has('cart')) {
                $cart = session('cart');
            } else {
                $cart = new Cart();
            }

            // dd($cart);
            // return idex view with user data
            return view('stores.suppliers.cart');
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    public function decreaseStock($orderItem)
    {
        $product = $orderItem->product;

        // نقص من الكمية الكلية
        $product->decrement('qty', $orderItem->quantity);
        // إذا فيه variation
        if ($orderItem->variation_id != null) {
            $variation = $orderItem->variation;
            $variation->decrement('stock_quantity', $orderItem->quantity);
        }
        // إذا فيه attribute
        if ($orderItem->attribute_id != null) {
            $attribute = $orderItem->attribute;
            $attribute->decrement('stock_quantity', $orderItem->quantity);
        }
    }

    // order
    public function order(Request $request)
    {
        // get supplier plan
        // $supplier=get_supplier_data(tenant('id'));
        // $plan_id=$supplier->plan_subscription->plan_id;
        // التحقق من نوع المستخدم
        if (get_user_data(tenant('id')) && get_user_data(tenant('id'))->type == 'supplier') {
            // التحقق من صحة البيانات
            $validatedData = $request->validate([
                // 'supplier_id' => 'required|exists:suppliers,id',
                // 'user_id' => 'nullable|exists:users,id',
                'name' => 'sometimes|nullable|string|max:255',
                'phone' => 'required|string|regex:/^0[5-7][0-9]{8}$/',
                'address' => 'sometimes|nullable|string|max:500',
                'wilaya' => 'required|integer|exists:wilayas,id',
                // 'dayrea' => 'required|integer|exists:dayreas,id',
                // 'baladia' => 'required|integer|exists:baladias,id',
                'shipping_and_point' => 'required|in:home,descktop',
                'product_id' => 'required|exists:supplier_products,id',
                'product_varition' => 'nullable|exists:supplier_product_variations,id',
                'product_attribute' => 'nullable|exists:supplier_product_attributes,id',
                'qty' => 'required|integer|min:1',
                // 'price' => 'required|numeric|min:0',
                // 'form_total_amount' => 'required|numeric|min:0',
                // 'shipping_cost' => 'required|numeric|min:0',
                'payment_method' => 'required|in:cod,chargily,verments',
            ]);

            try {
                DB::beginTransaction(); // بدء المعاملة
                // delete order abandoned from data base
                $order_abandoned = SupplierOrderAbandoned::where('phone', $request->phone)->first();
                if ($order_abandoned) {
                    $order_abandoned->delete();
                }
                // -----------لمنع الطلبات الوهمية----------------
                // الحصول على بيانات العميل
                $ip = $request->ip();
                $userAgent = $request->header('User-Agent');
                $sessionId = Session::getId();

                // إذا لم يكن هناك بصمة جهاز، توليد واحدة (يفضل جلبها من JS)
                $deviceFingerprint = $request->input('device_fingerprint') ?? Str::uuid()->toString();

                // تقييم أولي لدرجة الخطر
                $riskScore = 0;
                $riskIndicators = [];

                // 1. تحقق من عدد الطلبات السابقة بنفس IP خلال آخر 24 ساعة
                $ordersFromSameIP = SupplierOrders::where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->count();
                if ($ordersFromSameIP > 3) {
                    $riskScore += 40;
                    $riskIndicators[] = 'same_ip_multiple_orders';
                }

                // 2. تحقق من رقم الهاتف إذا كان وهمي
                if (preg_match('/^(\+213|0)(5|6|7)[0-9]{8}$/', $request->phone) === 0) {
                    $riskScore += 50;
                    $riskIndicators[] = 'invalid_phone';
                }

                // 3. تحقق من عدد الطلبات من نفس البصمة
                $ordersFromSameDevice = SupplierOrders::where('device_fingerprint', $deviceFingerprint)
                    ->where('created_at', '>=', now()->subDay())
                    ->count();
                if ($ordersFromSameDevice > 2) {
                    $riskScore += 30;
                    $riskIndicators[] = 'same_device_multiple_orders';
                }

                // تحديد حالة الاحتيال بناءً على درجة الخطر
                $fraudStatus = 'approved';
                if ($riskScore >= 70) {
                    $fraudStatus = 'under_review';
                }
                if ($riskScore >= 90) {
                    $fraudStatus = 'rejected';
                }
                // ------------نهاية إجراءات لمنع الطلبات الوهمية------------------
                // get product data
                $product = SupplierProducts::findOrfail($request->product_id);
                // get product attribute data
                if ($request->product_attribute != null) {
                    $p_attribute = SupplierProductAttributes::findOrfail($request->product_attribute);
                    $additional_price = $p_attribute->additional_price;
                } else {
                    $additional_price = 0;
                }
                // توليد رقم طلب فريد
                $orderNumber = 'ORD-'.strtoupper(uniqid());

                // إنشاء الطلب
                $supplierId = $product->supplier_id;
                $planId = get_supplier_subscription_data($supplierId)->plan_id;

                // if(plan_phone_visibilty_autorization($planId)==true || get_user_data(tenant('id'))->freeOrder->quantity > 0)
                // {
                //   $phoneVisibility=true;
                //   $quantity=get_user_data(tenant('id'))->freeOrder->quantity - 1;
                //   get_user_data(tenant('id'))->freeOrder->update([
                //     'quantity' =>$quantity,
                //   ]);
                // }
                // else
                // {
                //   $phoneVisibility=false;
                // }
                // dd($phoneVisibility);
                if ($request->shipping_and_point == 'home') {
                    $shipping_type = 'to_home';
                } else {
                    $shipping_type = 'to_descktop';
                }
                // dd($planId, $request->name);
                $phoneVisibility = plan_phone_visibilty_autorization($planId, $request->name);
                
                // get total price
                if ($product->free_shipping == 'yes') {
                    $shipping_cost = 0;
                } else {
                    $shipping_cost = get_shipping_cost($request->shipping_and_point, $request->wilaya, $request->dayra, $request->baladia);
                }
                
                if (supplier_product_has_discount($product->id)) {
                    $unit_price = $product->activeDiscount->discount_amount + $additional_price;
                    $coupon_discount = get_coupon_discount($request->product_id, $request->coupon, get_user_data(tenant('id'))->type);
                    $total_price = ((($product->activeDiscount->discount_amount + $additional_price) * $request->qty) + $shipping_cost) - $coupon_discount;
                } else {
                    $unit_price = $product->price + $additional_price;
                    $coupon_discount = get_coupon_discount($request->product_id, $request->coupon, get_user_data(tenant('id'))->type);
                    $total_price = ((($product->price + $additional_price) * $request->qty) + $shipping_cost) - $coupon_discount;
                }
                
                // get product discount
                if ($product->discount) {
                    $product_discount = $product->discount->discount_amount;
                } else {
                    $product_discount = 0;
                }

                $DiscountAmount = $coupon_discount + $product_discount;
                // wile testing
                if (strcasecmp($request->name, 'test') === 0) {
                    $customer_phone = '0660000000';
                    $phoneVisibility = true;
                } else {
                    $customer_phone = $request->phone;
                }

                // $shipping_cost=get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                $supplierOrder = SupplierOrders::create([
                    'supplier_id' => $product->supplier_id,
                    'order_number' => $orderNumber,
                    'customer_name' => $request->name,
                    'phone' => $customer_phone,
                    'phone_visiblity' => $phoneVisibility,
                    'status' => 'pending',
                    'total_price' => $total_price,
                    'discount' => $DiscountAmount,
                    'shipping_cost' => $shipping_cost,
                    'shipping_type' => $shipping_type,
                    'free_shipping' => $product->free_shipping,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'note' => $request->note,
                    'shipping_address' => $request->address,
                    'billing_address' => $request->billing_address ?? $request->address,
                    'wilaya_id' => $request->wilaya,
                    'dayra_id' => $request->dayra,
                    'baladia_id' => $request->baladia,
                    // ---------
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'device_fingerprint' => $deviceFingerprint,
                    'session_id' => $sessionId,
                    'risk_score' => $riskScore,
                    'risk_indicators' => json_encode($riskIndicators),
                    'fraud_status' => $fraudStatus,
                    // --------
                ]);

                // إدراج عنصر الطلب
                $order_item = SupplierOrderItems::create([
                    'order_id' => $supplierOrder->id,
                    'product_id' => $request->product_id,
                    'variation_id' => $request->product_varition,
                    'attribute_id' => $request->product_attribute,
                    'quantity' => $request->qty,
                    'unit_price' => $unit_price,
                    'total_price' => $total_price,
                ]);
                // إدارة المخزون
                $this->decreaseStock($order_item);

                DB::commit(); // تأكيد العملية

                // notify the supplier about this order

                // with telegram api call

                // return response()->json([
                //     'message' => 'تم إنشاء الطلب بنجاح!',
                //     'order' => $supplierOrder
                // ], 201);
                // إدراج الطلب في قوقل شيت مباشرة إذا كان الإشتراك يسمح بذالك
                if ($planId > 1) {
                    $data = [
                        'order_number' => $supplierOrder->order_number,
                        'customer_name' => $supplierOrder->customer_name,
                        'phone' => $supplierOrder->phone,
                        'status' => $supplierOrder->status,
                        'total_price' => $supplierOrder->total_price,
                        'shipping_cost' => $supplierOrder->shipping_cost,
                        'payment_method' => $supplierOrder->payment_method,
                        'payment_status' => $supplierOrder->payment_status,
                        'shipping_address' => $supplierOrder->shipping_address,
                    ];
                    // $result = $this->sheetService->addOrder($data);
                    // $result=$this->googleSheetService->addOrder($data);
                    $result = sendOrderDataToGoogleSheet::dispatch(tenant('id'), $data);
                // if ($result['success']) {
                //     return response()->json([
                //         'message' => 'Order saved to Google Sheet',
                //         'row' => $result['row']
                //     ]);
                // }else
                // {
                //     return response()->json([
                //         'message' =>'error',
                //         // 'row'=>$result,
                //     ]);
                // }

                // return response()->json([
                //     'error' => 'Failed to save order'
                // ], 500);
                } else {
                    $data = [
                        'order_number' => $supplierOrder->order_number,
                        'customer_name' => $supplierOrder->customer_name,
                        'phone' => 'غير متاح في هذه الخطة',
                        'status' => $supplierOrder->status,
                        'total_price' => $supplierOrder->total_price,
                        'shipping_cost' => $supplierOrder->shipping_cost,
                        'payment_method' => $supplierOrder->payment_method,
                        'payment_status' => $supplierOrder->payment_status,
                        'shipping_address' => $supplierOrder->shipping_address,
                    ];
                }
                // telegrame إرسال الإشعار للمورد
                sendTelegramInfoAboutOrder::dispatch($supplierOrder);
                //  $this->orderNotificationService->sendOrderNotificationToSupplier($supplierOrder);
                // redirect to checkout page
                if ($request->payment_method == 'chargily') {
                    // return view('stores.suppliers.checkout.chargily.index');
                    return redirect()->route('tenant.payments.show_chargily_pay', $supplierOrder->id);
                }
                if ($request->payment_method == 'verments') {
                    // return view('stores.suppliers.checkout.verments.index');
                    return redirect()->route('tenant.payments.show_verments_pay', $supplierOrder->id);
                }

                // إعادة المستخدم إلى صفحة الشكر
                return redirect()->route('tenant.thanks')->with('success', 'شكراً لطلبك! سيتم التواصل معك قريبًا.');
            } catch (\Exception $e) {
                DB::rollBack(); // التراجع في حالة حدوث خطأ
                // return response()->json([
                //     'message' => 'حدث خطأ أثناء إنشاء الطلب',
                //     'error' => $e->getMessage()
                // ], 500);
            }
        }
    }

    // order abandoned
    public function order_abandoned(Request $request)
    {
        // التحقق من نوع المستخدم
        if (get_user_data(tenant('id')) && get_user_data(tenant('id'))->type == 'supplier') {
            // التحقق من صحة البيانات
            $validatedData = $request->validate([
                'phone' => 'required|string|regex:/^0[5-7][0-9]{8}$/',
            ]);

            try {
                DB::beginTransaction(); // بدء المعاملة
                $product = SupplierProducts::findOrfail($request->product_id);
                // توليد رقم طلب فريد
                $orderNumber = 'ORD-'.strtoupper(uniqid());

                // إنشاء الطلب
                $supplierId = $product->supplier_id;
                $planId = get_supplier_subscription_data($supplierId)->plan_id;
                if ($planId == 1 || $planId == 2) {
                    $phoneVisibility = false;
                } else {
                    $phoneVisibility = true;
                }
                // $phoneVisibility = plan_phone_visibilty_autorization($planId) ? true : false;
                if ($request->shipping_and_point == 'home') {
                    $shipping_type = 'to_home';
                } else {
                    $shipping_type = 'to_descktop';
                }
                // get total price
                if ($product->free_shipping == 'yes') {
                    $shipping_cost = 0;
                } else {
                    $shipping_cost = get_shipping_cost($request->shipping_and_point, $request->wilaya, $request->dayra, $request->baladia);
                }
                if (supplier_product_has_discount($product->id)) {
                    $unit_price = $product->activeDiscount->discount_amount;
                    $total_price = ($product->activeDiscount->discount_amount * $request->qty) + $shipping_cost;
                } else {
                    $unit_price = $product->price;
                    $total_price = ($product->price * $request->qty) + $shipping_cost;
                }
                // $total_price=($product->price * $request->qty) + get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                // get shipping cost
                // $shipping_cost=get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                $supplierOrder = SupplierOrderAbandoned::create([
                    'supplier_id' => $product->supplier_id,
                    'order_number' => $orderNumber,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'phone_visiblity' => $phoneVisibility,
                    'status' => 'pending',
                    'total_price' => $total_price,
                    'shipping_cost' => $shipping_cost,
                    'shipping_type' => $shipping_type,
                    // 'free_shipping' => $product->free_shipping,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'note' => $request->note,
                    'shipping_address' => $request->address,
                    'billing_address' => $request->billing_address ?? $request->address,
                ]);

                // إدراج عنصر الطلب
                SupplierOrderAbandonedItems::create([
                    'order_id' => $supplierOrder->id,
                    'product_id' => $request->product_id,
                    'variation_id' => $request->product_varition,
                    'attribute_id' => $request->product_attribute,
                    'quantity' => $request->qty,
                    'unit_price' => $unit_price,
                    'total_price' => $total_price,
                ]);

                DB::commit(); // تأكيد العملية

                // notify the supplier about this order

                // with telegram api call

                return response()->json([
                    'message' => 'تم إنشاء الطلب بنجاح!',
                    'order' => $supplierOrder,
                ], 201);

                // إعادة المستخدم إلى صفحة الشكر
            } catch (\Exception $e) {
                DB::rollBack(); // التراجع في حالة حدوث خطأ

                return response()->json([
                    'message' => 'حدث خطأ أثناء إنشاء الطلب',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }

    // order_with_items
    public function order_with_items(Request $request)
    {
        // check user type
        if (get_user_data(tenant('id')) && get_user_data(tenant('id'))->type == 'supplier') {
            // التحقق من صحة البيانات
            $validatedData = $request->validate([
                // 'supplier_id' => 'required|exists:suppliers,id',
                // 'user_id' => 'nullable|exists:users,id',
                'name' => 'sometimes|nullable|string|max:255',
                'phone' => 'required|string|regex:/^0[5-7][0-9]{8}$/',
                'address' => 'sometimes|nullable|string|max:500',
                'wilaya' => 'required|integer|exists:wilayas,id',
                // 'dayrea' => 'required|integer|exists:dayreas,id',
                // 'baladia' => 'required|integer|exists:baladias,id',
                'shipping_and_point' => 'required|in:home,descktop',
                // 'product_id' => 'required|exists:supplier_products,id',
                // 'product_varition' => 'nullable|exists:supplier_product_variations,id',
                // 'product_attribute' => 'nullable|exists:supplier_product_attributes,id',
                // 'qty' => 'required|integer|min:1',
                // 'price' => 'required|numeric|min:0',
                // 'form_total_amount' => 'required|numeric|min:0',
                // 'shipping_cost' => 'required|numeric|min:0',
                'payment_method' => 'required|in:cod,chargily,verments',
            ]);

            try {
                DB::beginTransaction(); // بدء المعاملة
                // delete order abandoned from data base
                $order_abandoned = SupplierOrderAbandoned::where('phone', $request->phone)->first();
                if ($order_abandoned) {
                    $order_abandoned->delete();
                }
                // get supplier data
                foreach (session('cart')->items as $item) {
                    $product_id = $item['id'];
                    break;
                }
                $s_product = SupplierProducts::findOrfail($product_id);
                // -----------لمنع الطلبات الوهمية----------------
                // الحصول على بيانات العميل
                $ip = $request->ip();
                $userAgent = $request->header('User-Agent');
                $sessionId = Session::getId();

                // إذا لم يكن هناك بصمة جهاز، توليد واحدة (يفضل جلبها من JS)
                $deviceFingerprint = $request->input('device_fingerprint') ?? Str::uuid()->toString();

                // تقييم أولي لدرجة الخطر
                $riskScore = 0;
                $riskIndicators = [];

                // 1. تحقق من عدد الطلبات السابقة بنفس IP خلال آخر 24 ساعة
                $ordersFromSameIP = SupplierOrders::where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->count();
                if ($ordersFromSameIP > 3) {
                    $riskScore += 40;
                    $riskIndicators[] = 'same_ip_multiple_orders';
                }

                // 2. تحقق من رقم الهاتف إذا كان وهمي
                if (preg_match('/^(\+213|0)(5|6|7)[0-9]{8}$/', $request->phone) === 0) {
                    $riskScore += 50;
                    $riskIndicators[] = 'invalid_phone';
                }

                // 3. تحقق من عدد الطلبات من نفس البصمة
                $ordersFromSameDevice = SupplierOrders::where('device_fingerprint', $deviceFingerprint)
                    ->where('created_at', '>=', now()->subDay())
                    ->count();
                if ($ordersFromSameDevice > 2) {
                    $riskScore += 30;
                    $riskIndicators[] = 'same_device_multiple_orders';
                }

                // تحديد حالة الاحتيال بناءً على درجة الخطر
                $fraudStatus = 'approved';
                if ($riskScore >= 70) {
                    $fraudStatus = 'under_review';
                }
                if ($riskScore >= 90) {
                    $fraudStatus = 'rejected';
                }
                // ------------نهاية إجراءات لمنع الطلبات الوهمية------------------

                // توليد رقم طلب فريد
                $orderNumber = 'ORD-'.strtoupper(uniqid());

                // التحقق من وجود كوبون
                $cart_amount = session('cart')->totalPrice;
                if ($request->coupon) {
                    // //  $coupon_discount = get_coupon_discount($request->product_id, $request->coupon, get_user_data(tenant('id'))->type);
                    $coupon = userCoupons::where('user_id', get_user_data(tenant('id'))->id)
                    ->where('code', $request->coupon)
                    ->where('is_active', 1)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();
                    // check valdation coupon
                    if (is_valid_coupon_for_orders($coupon, $cart_amount, get_user_data(tenant('id'))->type)) {
                        // Apply the coupon discount
                        if ($coupon->type == 'percent') {
                            $couponAmount = $cart_amount * $coupon->value / 100;
                        } elseif ($coupon->type == 'fixed') {
                            $couponAmount = $coupon->value;
                        }
                        ++$coupon->usage_per_user;
                        $coupon->save();
                    } else {
                        $couponAmount = '00';
                    }
                } else {
                    $couponAmount = 0;
                }
                // dd($couponAmount);

                // إنشاء الطلب
                $supplierId = $s_product->supplier_id;
                $planId = get_supplier_subscription_data($supplierId)->plan_id;
                // if(plan_phone_visibilty_autorization($planId)==true || get_user_data(tenant('id'))->freeOrder->quantity > 0)
                // {
                //   $phoneVisibility=true;
                //   $quantity=get_user_data(tenant('id'))->freeOrder->quantity - 1;
                //   get_user_data(tenant('id'))->freeOrder->update([
                //     'quantity' =>$quantity,
                //   ]);
                // }
                // else
                // {
                //   $phoneVisibility=false;
                // }
                // dd($phoneVisibility);

                $phoneVisibility = plan_phone_visibilty_autorization($planId, $request->name);
                // get total price
                $free_shipping = true;
                foreach (session('cart')->items as $item) {
                    if ($item['free_shipping'] === 'no') {
                        $free_shipping = false;
                    }
                }
                // dd($free_shipping);
                if ($free_shipping) {
                    $shipping_cost = 0;
                    $get_free_shipping = 'yes';
                } else {
                    $shipping_cost = get_shipping_cost($request->shipping_and_point, $request->wilaya, $request->dayra, $request->baladia);
                    $get_free_shipping = 'no';
                }

                if ($request->shipping_and_point == 'home') {
                    $shipping_type = 'to_home';
                } else {
                    $shipping_type = 'to_descktop';
                }
                // get unit price and total price
                $total_price = 0;
                $unit_price = 0;
                $additional_price = 0;
                $products_discounts = 0;
                foreach (session('cart')->items as $item) {
                    if (supplier_product_has_discount($item['id'])) {
                        $product = SupplierProducts::findOrFail($item['id']);
                        $products_discounts += ($product->price - $product->discount->discount_amount) * $item['qty'];
                    }
                    // get additional price
                    // foreach ($item['attribute_ids'] as $attribute)
                    // {
                    //         //dd($attribute);
                    //     if(!empty($attribute['attribute']))
                    //     {
                    //          $additional_price+=$attribute['attribute']['additional_price']*$attribute['qty'];
                    //     }else
                    //     {
                    //      $additional_price+=0;
                    //     }

                    // }
                }

                // $total_price+=$shipping_cost+$additional_price;
                $total_price = (session('cart')->totalPrice + $shipping_cost) - ($couponAmount + $products_discounts);
                //  dd($total_price);
                // wile testing
                if (strcasecmp($request->name, 'test') === 0) {
                    $customer_phone = '0660000000';
                    $phoneVisibility = true;
                } else {
                    $customer_phone = $request->phone;
                }
                // // decriment coupoune usage
                // $coupone = userCoupons::where('user_id', get_user_data(tenant('id'))->id)->where('code', $request->coupon)->first();
                // if ($coupone && $coupone->usage_per_user <= $coupone->usage_limit) {
                //     $coupone->update([
                //         'usage_per_user' => $coupone->usage_per_user + 1,
                //     ]);
                // }
                // get shipping cost
                // dd($products_discounts);
                // $shipping_cost=get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                $supplierOrder = SupplierOrders::create([
                    'supplier_id' => $supplierId,
                    'order_number' => $orderNumber,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'phone_visiblity' => $phoneVisibility,
                    'status' => 'pending',
                    'total_price' => $total_price,
                    'discount' => $couponAmount + $products_discounts,
                    'shipping_cost' => $shipping_cost,
                    'shipping_type' => $shipping_type,
                    'free_shipping' => $get_free_shipping,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'note' => $request->note,
                    'shipping_address' => $request->address,
                    'billing_address' => $request->billing_address ?? $request->address,
                    'wilaya_id' => $request->wilaya,
                    'dayra_id' => $request->dayra,
                    'baladia_id' => $request->baladia,
                    // ---------
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'device_fingerprint' => $deviceFingerprint,
                    'session_id' => $sessionId,
                    'risk_score' => $riskScore,
                    'risk_indicators' => json_encode($riskIndicators),
                    'fraud_status' => $fraudStatus,
                    // --------
                ]);
                // dd($total_price);
                // إدراج عنصر الطلب
                foreach (session('cart')->items as $item) {
                    // dd(session('cart')->items);
                    // inistialize the varibles
                    $variation_keys = [];
                    $attribute_keys = [];
                    $variation_id = null;
                    $attribute_id = null;
                    $item_price = 0;
                    $item_price = $item['price'];
                    // get variation ids
                    foreach ($item['variation_ids'] as $variation) {
                        $variation_keys[] = $variation;
                    }
                    // get attribute ids
                    foreach ($item['attribute_ids'] as $attribute) {
                        $attribute_keys[] = $attribute;
                    }
                    // item normal
                    if ($variation_keys[0]['qty'] >= 1 && ($attribute_keys[0]['qty'] == $variation_keys[0]['qty'])) {
                        $variation_id = null;
                        $attribute_id = null;
                    }
                    // item has color only
                    if (count($variation_keys) > count($attribute_keys)) {
                        $variation_id = $variation_keys[1]['id'];
                        $attribute_id = null;
                    }
                    // item has attribute only
                    if (count($attribute_keys) > count($variation_keys)) {
                        $variation_id = null;
                        $attribute_id = $attribute_keys[1]['id'];
                        $item_price += $attribute_keys[1]['attribute']['additional_price'];
                    }

                    // dd($variation_keys, $attribute_keys);
                    // item has color and attribute

                    if (count($variation_keys) > 1 && (count($variation_keys) == count($attribute_keys))) {
                        $variation_id = $variation_keys[1]['id'];
                        $attribute_id = $attribute_keys[1]['id'];
                        $item_price += $attribute_keys[1]['attribute']['additional_price'];
                    }

                    // get item qty
                    $item_qty = $item['qty'];
                    // if ($item['id'] == 4) {
                    //     dd($item, count($variation_keys), count($attribute_keys),$variation_id, $attribute_id, $item_price, $item_qty);
                    //     // dd($variation_id, $attribute_id, $item_price, $item_qty);
                    // }

                    $order_item = SupplierOrderItems::create([
                        'order_id' => $supplierOrder->id,
                        'product_id' => $item['id'],
                        'variation_id' => $variation_id,
                        'attribute_id' => $attribute_id,
                        'quantity' => $item_qty,
                        'unit_price' => $item_price,
                        'total_price' => $item_price * $item_qty,
                    ]);
                    // إدارة المخزون
                    $this->decreaseStock($order_item);
                }

                DB::commit(); // تأكيد العملية

                session()->forget('cart');
                // notify the supplier about this order

                // with telegram api call

                // return response()->json([
                //     'message' => 'تم إنشاء الطلب بنجاح!',
                //     'order' => $supplierOrder
                // ], 201);
                // إدراج الطلب في قوقل شيت مباشرة إذا كان الإشتراك يسمح بذالك
                if ($planId > 1) {
                    $data = [
                        'order_number' => $supplierOrder->order_number,
                        'customer_name' => $supplierOrder->customer_name,
                        'phone' => $supplierOrder->phone,
                        'status' => $supplierOrder->status,
                        'total_price' => $supplierOrder->total_price,
                        'shipping_cost' => $supplierOrder->shipping_cost,
                        'payment_method' => $supplierOrder->payment_method,
                        'payment_status' => $supplierOrder->payment_status,
                        'shipping_address' => $supplierOrder->shipping_address,
                    ];
                    // $result = $this->sheetService->addOrder($data);
                    // $result=$this->googleSheetService->addOrder($data);
                    $result = sendOrderDataToGoogleSheet::dispatch(tenant('id'), $data);
                // if ($result['success']) {
                //     return response()->json([
                //         'message' => 'Order saved to Google Sheet',
                //         'row' => $result['row']
                //     ]);
                // }else
                // {
                //     return response()->json([
                //         'message' =>'error',
                //         // 'row'=>$result,
                //     ]);
                // }

                // return response()->json([
                //     'error' => 'Failed to save order'
                // ], 500);
                } else {
                    $data = [
                        'order_number' => $supplierOrder->order_number,
                        'customer_name' => $supplierOrder->customer_name,
                        'phone' => 'غير متاح في هذه الخطة',
                        'status' => $supplierOrder->status,
                        'total_price' => $supplierOrder->total_price,
                        'shipping_cost' => $supplierOrder->shipping_cost,
                        'payment_method' => $supplierOrder->payment_method,
                        'payment_status' => $supplierOrder->payment_status,
                        'shipping_address' => $supplierOrder->shipping_address,
                    ];
                }
                // telegrame إرسال الإشعار للمورد
                sendTelegramInfoAboutOrder::dispatch($supplierOrder);
                //  $this->orderNotificationService->sendOrderNotificationToSupplier($supplierOrder);
                // redirect to checkout page
                if ($request->payment_method == 'chargily') {
                    // return view('stores.suppliers.checkout.chargily.index');
                    return redirect()->route('tenant.payments.show_chargily_pay', $supplierOrder->id);
                }
                if ($request->payment_method == 'verments') {
                    // return view('stores.suppliers.checkout.verments.index');
                    return redirect()->route('tenant.payments.show_verments_pay', $supplierOrder->id);
                }

                // إعادة المستخدم إلى صفحة الشكر
                return redirect()->route('tenant.thanks')->with('success', 'شكراً لطلبك! سيتم التواصل معك قريبًا.');
            } catch (\Exception $e) {
                DB::rollBack(); // التراجع في حالة حدوث خطأ
                // return response()->json([
                //     'message' => 'حدث خطأ أثناء إنشاء الطلب',
                //     'error' => $e->getMessage()
                // ], 500);
            }
        }
    }

    // function thanks
    public function thanks()
    {
        if (!session()->has('success')) {
            return redirect()->back();
        }

        return view('stores.suppliers.pages.thanks');
    }

    // cod checkout
    public function checkout()
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get user data
            if (session()->has('cart')) {
                $cart = session('cart');
            } else {
                $cart = new Cart();
            }
            if (count($cart->items) == 0) {
                return redirect()->route('tenant.cart');
            }

            $wilayas = Wilaya::get();
            // get order form setting
            $form_settings = UserStoreSetting::where('user_id', get_user_data(tenant('id'))->id)->where('key', 'store_order_form_settings')->first();
            $order_form = json_decode($form_settings->value);

            // return idex view with user data
            return view('stores.suppliers.checkout', compact('wilayas', 'order_form'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // chargily pay
    public function show_chargily_pay($order_id)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get order data
            $order = SupplierOrders::findOrfail($order_id);
            $wilayas = Wilaya::get();
            // $items=SupplierOrderItems::where('order_id',$order->id)->get();

            // dd('order: '.$order->items.'items: '.$items);
            // return idex view with user data
            return view('stores.suppliers.payments.chargily.index', compact('order', 'wilayas'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    public function chargily_pay(Request $request)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            $order = SupplierOrders::findOrfail($request->order_id);
            $order_items = SupplierOrderItems::where('order_id', $order->id)->get();
            dd($order_items);
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // verments pay
    public function show_verments_pay($order_id)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // get order data
            $order = SupplierOrders::findOrfail($order_id);
            $wilayas = Wilaya::get();

            // return idex view with user data
            return view('stores.suppliers.payments.verments.index', compact('order', 'wilayas'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    public function verments_pay(Request $request)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            // validation
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:supplier_orders,id',
                'payment_proof' => 'required|mimetypes:application/pdf,image/jpeg,image/png|max:2048',
            ]);
            // get order data
            $order = SupplierOrders::findOrfail($request->order_id);
            // edit the order data
            // upload file to right path of supplier store folder
            $file = $request->file('payment_proof');
            if ($file->isValid()) {  // Check if file upload was successful
                // Get file extension
                $extension = $file->getClientOriginalExtension();
                // Rename the file using order number
                $filename = $order->order_number.'.'.$extension;
                // Store the file with new filename in supplier's storage
                $path = $file->storeAs(
                    get_supplier_store_name(tenant('id')).'/customer_payment_proofs/'.date('Y').'/'.date('m').'/'.date('d'),
                    $filename,
                    'supplier'        
                );
                // $url = Storage::disk('public')->url('tenantsupplier/app/public/supplier/'.$path);
                $url = asset('storage/tenantsupplier/app/public/supplier/'.$path);
            } else {
                // Handle invalid file upload
                throw new \Exception('Invalid file upload');
            }
            $order->payment_proof = $url;
            $order->save();
            // update the order

            // redirect to thank you page with success message
            return redirect()->route('tenant.thanks')->with('success', 'شكراً لطلبك! سيتم التواصل معك قريبًا.');
            // return idex view with user data

            // return view('stores.suppliers.payments.verments.index',compact('order'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    // get dayras
    public function get_dayras($wilaya_id)
    {
        $dayras = Dayra::where('wilaya_id', $wilaya_id)->get();
        $html = '<option value="0" selected>إختر الدائرة...</option>';
        foreach ($dayras as $dayra) {
            $html .= '<option value="'.$dayra->id.'">'.$dayra->ar_name.'</option>';
        }

        return $html;
    }

    // get baladias
    public function get_baladias($dayra_id)
    {
        $baladias = Baladia::where('dayra_id', $dayra_id)->get();
        $html = '<option value="0" selected>إختر البلدية...</option>';
        foreach ($baladias as $baladia) {
            $html .= '<option value="'.$baladia->id.'">'.$baladia->ar_name.'</option>';
        }

        return $html;
    }

    // get shipping prices
    public function get_shipping_prices($wilaya_id)
    {
        $prices = ShippingPrice::where('user_id', get_user_data(tenant('id'))->id)->where('wilaya_id', $wilaya_id)->first();

        return response()->json([
            'prices' => $prices,
        ]);
    }

    // get_wilaya_data
    public function get_wilaya_data($wilaya_id)
    {
        $wilaya = Wilaya::findOrfail($wilaya_id);
        if ($wilaya == null) {
            $wilaya = ['ar_name' => 'ولاية غير معروفة'];
        }

        return response()->json([
            'wilaya' => $wilaya,
        ]);
    }

    // get_wilaya_data
    public function get_dayra_data($wilaya_id)
    {
        $dayra = Dayra::findOrfail($wilaya_id);
        if ($dayra == null) {
            $dayra = ['ar_name' => 'دائرة غير معروفة'];
        }

        return response()->json([
            'dayra' => $dayra,
        ]);
    }

    // add to cart
    public function add_to_cart(Request $request)
    {
        // check user type
        if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
            $product = SupplierProducts::findOrfail($request->product_id);
            $variation_id = $request->variation_id;
            $attribute_id = $request->attribute_id;
            if (session()->has('cart')) {
                $cart = new Cart(session('cart'));
            } else {
                $cart = new Cart();
            }
            $cart->add($product, $variation_id, $attribute_id);
            session()->put('cart', $cart);

            // return response()->json([
            //     'cart' => $cart,
            // ]);
            return back()->with('success', 'تمت اضافة المنتج الى السلة بنجاح');
        }

        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    }

    public function remove_from_cart($id)
    {
        if (session()->has('cart')) {
            $cart = new Cart(session('cart'));
        } else {
            $cart = new Cart();
        }
        $cart->remove($id);
        session()->put('cart', $cart);

        // return response()->json([
        //     'cart' => $cart,
        // ]);
        return back()->with('success', 'تمت ازالة المنتج من السلة بنجاح');
    }

    public function remove_from_cart_variation($id, $variation_id, $attribute_id)
    {
        if (session()->has('cart')) {
            $cart = new Cart(session('cart'));
        } else {
            $cart = new Cart();
        }
        $cart->remove_variation($id, $variation_id, $attribute_id);
        session()->put('cart', $cart);

        // return response()->json([
        //     'cart' => $cart,
        // ]);
        return back()->with('success', 'تمت ازالة المنتج من السلة بنجاح');
    }

    public function remove_all_from_cart()
    {
        session()->forget('cart');
        if (session()->has('cart')) {
            $cart = new Cart(session('cart'));
        } else {
            $cart = new Cart();
        }
        // $cart->removeAll();
        // session()->forget('cart');
        session()->put('cart', $cart);

        // return response()->json([
        //     'cart' => $cart,
        // ]);
        return back()->with('success', 'تمت ازالة جميع المنتجات من السلة بنجاح');
    }

    // increment item in the cart
    public function increment($id, $variation_id = null, $attribute_id = null)
    {
        if (session()->has('cart')) {
            $cart = new Cart(session('cart'));
        } else {
            $cart = new Cart();
        }
        $cart->increment($id, $variation_id, $attribute_id);
        session()->put('cart', $cart);

        return response()->json([
            'cart' => $cart,
        ]);
        // return back()->with('success','تمت ازالة جميع المنتجات من السلة بنجاح');
    }

    // decrement item in the cart
    public function decrement($id, $variation_id = null, $attribute_id = null)
    {
        if (session()->has('cart')) {
            $cart = new Cart(session('cart'));
        } else {
            $cart = new Cart();
        }
        $cart->decrement($id, $variation_id, $attribute_id);
        session()->put('cart', $cart);

        return response()->json([
            'cart' => $cart,
        ]);
        // return back()->with('success','تمت ازالة جميع المنتجات من السلة بنجاح');
    }

    // update_cart_quantity
    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $variationId = $request->variation_id ?: 0;
        $attributeId = $request->attribute_id ?: 0;
        $newQuantity = $request->new_quantity;

        // return response()->json([
        //     'success' => true,
        //     'variationId' => $variationId,
        //     'attributeId' => $attributeId,
        //     'newQuantity' => $newQuantity,
        //     'productId' => $productId
        // ]);

        $cart = session()->get('cart');

        //    $cart->updateQty($productId, $newQuantity, $variationId, $attributeId);

        if ($cart) {
            // Update the quantity using the method we added to the Cart class
            $success = $cart->updateQty($productId, $newQuantity, $variationId, $attributeId);

            if ($success) {
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'cart' => [
                        'items' => $cart->items,
                        'totalQty' => $cart->totalQty,
                        'totalPrice' => $cart->totalPrice,
                    ],
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'فشل تحديث الكمية',
        ]);
    }

    public function fetchCoupon(Request $request)
    {
        // $request->validate([
        //     'coupon' => 'required|string',
        // ]);

        $couponCode = $request->input('coupon');
        $cart_amount = session('cart')->totalPrice;

        // // check user type
        // if (get_user_data(tenant('id')) != null && get_user_data(tenant('id'))->type == 'supplier') {
        //     // get order data
        //     $order = SupplierOrders::findOrfail($order_id);
        //     $wilayas = Wilaya::get();

        //     // return idex view with user data
        //     return view('stores.suppliers.payments.verments.index', compact('order', 'wilayas'));
        // }

        // Find the coupon in the database
        $coupon = userCoupons::where('code', $couponCode)
            ->where('is_active', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'error' => 'Invalid or expired coupon code',
                'couponAmount' => 0,
            ], 404);
        }
        // check valdation coupon
        if (is_valid_coupon_for_orders($coupon, $cart_amount, get_user_data(tenant('id'))->type)) {
            // Apply the coupon discount
            if ($coupon->type == 'percent') {
                $couponAmount = $cart_amount * $coupon->value / 100;
            } elseif ($coupon->type == 'fixed') {
                $couponAmount = $coupon->value;
            }
        } else {
            $couponAmount = '00';
        }
        // check if the cart hass products with discounts
        $products_discounts = 0;
        foreach (session('cart')->items as $item) {
            if (supplier_product_has_discount($item['id'])) {
                $product = SupplierProducts::findOrFail($item['id']);
                $products_discounts += ($product->price - $product->discount->discount_amount) * $item['qty'];
            }
        }

        return response()->json([
            'couponAmount' => $couponAmount + $products_discounts,
            'couponType' => $coupon->type, // percentage or fixed
            'couponStatus' => $coupon->is_active,
            // Add any other coupon details you need
        ]);
    }

    public function productFetchCoupon(Request $request)
    {
        //    return response()->json([
        //     'response' => $request->all(),
        //     // Add any other coupon details you need
        // ]);

        $couponCode = $request->input('coupon');
        $product_id = $request->input('product_id');
        $product = SupplierProducts::findOrfail($product_id);
        $cart_amount = $request->input('totalPrice');

        // Find the coupon in the database
        $coupon = userCoupons::where('code', $couponCode)
            ->where('is_active', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'error' => 'Invalid or expired coupon code',
                'couponAmount' => 0,
            ], 404);
        }
        // check valdation coupon
        if (is_valid_coupon_for_product($coupon, $cart_amount, get_user_data(tenant('id'))->type, $product->id)) {
            // Apply the coupon discount
            if ($coupon->type == 'percent') {
                $couponAmount = $product->price * $coupon->value / 100;
            } elseif ($coupon->type == 'fixed') {
                $couponAmount = $coupon->value;
            }
        } else {
            $couponAmount = '00';
        }

        return response()->json([
            'couponAmount' => $couponAmount,
            'couponType' => $coupon->type, // percentage or fixed
            'couponStatus' => $coupon->is_active,
            // Add any other coupon details you need
        ]);
    }
}
