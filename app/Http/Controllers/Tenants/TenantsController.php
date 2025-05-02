<?php

namespace App\Http\Controllers\Tenants;


use App\Models\Dayra;
use App\Models\Wilaya;
use GuzzleHttp\Client;
use App\Models\Baladia;
use App\Models\UserSlider;
use App\Models\SupplierFqa;
use App\Models\UserBalance;
use App\Models\SupplierPage;
use Illuminate\Http\Request;
use App\Models\ShippingPrice;
use App\Models\SupplierOrders;
use App\Models\SupplierProducts;
use App\Models\UserStoreCategory;
use App\Models\SupplierOrderItems;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\SupplierProductImages;
use App\Models\SupplierOrderAbandoned;
use App\Models\SupplierProductsVisits;
use App\Models\SupplierProductAttributes;
use App\Models\SupplierProductVariations;
use App\Models\SupplierOrderAbandonedItems;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenantsController extends Controller
{
    //genral index
    public function index()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
        //get user data
        $sliders= UserSlider::where('user_id',get_user_data(tenant('id'))->id)->get();
        $categories= UserStoreCategory::where('user_id',get_user_data(tenant('id'))->id)->get();
        $products= SupplierProducts::where('supplier_id',get_supplier_data(tenant('id'))->id)->get();
        $faqs= SupplierFqa::where('supplier_id',get_supplier_data(tenant('id'))->id)->get();
        //return idex view with user data
            return view('stores.suppliers.index',compact('sliders','categories','products','faqs'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // about page
    public function about()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug',tenant_to_slug(tenant('id')).'-about')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.about',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // privacy policy page
    public function privacy_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','privacy-policy')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.privacy_policy',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // contact us page
    public function contact_us()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','contact-us')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.contact_us',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // exchange policy page
    public function exchange_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','exchange-policy')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.exchange_and_return_policy',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // payment policy page
    public function payment_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','payment-policy')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.payment_methods',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // shipping policy page
    public function shipping_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','shipping-policy')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.shipping_and_handling',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // terms of use page
    public function terms_of_use()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','terms-of-use')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.terms_of_use',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // faqpage
    public function faq()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $page= SupplierPage::where('slug','faq')->first();
            //return idex view with user data
        return view('stores.suppliers.pages.faq',compact('page'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // categories page
    public function categories()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $categories= UserStoreCategory::where('user_id',get_user_data(tenant('id'))->id)->get();
            //return idex view with user data
        return view('stores.suppliers.categories',compact('categories'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //products
    public function products()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.products');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //product details
    public function product($id,Request $request)
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
        //insert this visit to supplier product visit table
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
                    'product_id'  => $id,
                    'ip_address'  => $ipAddress,
                    'user_agent'  => $userAgent,
                    'user_id'     => $userId,
                    'visited_at'  => now(),
                ]);
            }
            //
            $wilayas=ShippingPrice::where('user_id',get_user_data(tenant('id'))->id)->where('shipping_available_to_wilaya',1)->get();
            $product= SupplierProducts::where('supplier_id',get_supplier_data(tenant('id'))->id)->where('id',$id)->first();
            $product_images=SupplierProductImages::where('product_id',$product->id)->get();
            $product_variations=SupplierProductVariations::where('product_id',$product->id)->get();
            $product_attributes=SupplierProductAttributes::where('product_id',$product->id)->get();
            //return idex view with user data
        return view('stores.suppliers.product-details',compact('product','wilayas','product_images','product_variations','product_attributes'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //products by category
    public function products_by_category($category_id)
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $products= SupplierProducts::where('supplier_id',get_supplier_data(tenant('id'))->id)->where('category_id',$category_id)->get();
            //return idex view with user data
        return view('stores.suppliers.products-by-category',compact('products'));
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //cart
    public function cart()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.cart');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //order
    public function order(Request $request)
    {
          // التحقق من نوع المستخدم
    if (get_user_data(tenant('id')) && get_user_data(tenant('id'))->type == 'supplier') {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            // 'supplier_id' => 'required|exists:suppliers,id',
            // 'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^0[5-7][0-9]{8}$/',
            'address' => 'required|string|max:500',
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
            'payment_method' => 'required|in:cod,chargily,baridimob',
        ]);

        try {
            DB::beginTransaction(); // بدء المعاملة
            //delete order abandoned from data base
            $order_abandoned=SupplierOrderAbandoned::where('phone',$request->phone)->first();
            $order_abandoned->delete();
            //get product data
            $product=SupplierProducts::findOrfail($request->product_id);
            // توليد رقم طلب فريد
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // إنشاء الطلب
            $supplierId = $product->supplier_id;
            $planId = get_supplier_subscription_data($supplierId)->plan_id;
            $phoneVisibility = plan_phone_visibilty_autorization($planId) ? true : false;
            // get total price
            $total_price=($product->price * $request->qty) + get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
            //get shipping cost
            $shipping_cost=get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
            $supplierOrder = SupplierOrders::create([
                'supplier_id' => $product->supplier_id,
                'order_number' => $orderNumber,
                'customer_name'=>$request->name,
                'phone' => $request->phone,
                'phone_visiblity' => $phoneVisibility,
                'status' => 'pending',
                'total_price' => $total_price,
                'shipping_cost' => $shipping_cost,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => $request->address,
                'billing_address' => $request->billing_address ?? $request->address,
            ]);

            // إدراج عنصر الطلب
            SupplierOrderItems::create([
                'order_id' => $supplierOrder->id,
                'product_id' => $request->product_id,
                'variation_id' => $request->product_varition,
                'attribute_id' => $request->product_attribute,
                'quantity' => $request->qty,
                'unit_price' => $product->price,
                'total_price' => $total_price,
            ]);

            DB::commit(); // تأكيد العملية


            //notify the supplier about this order
            
            //with telegram api call


            // return response()->json([
            //     'message' => 'تم إنشاء الطلب بنجاح!',
            //     'order' => $supplierOrder
            // ], 201);

            // إعادة المستخدم إلى صفحة الشكر
           return redirect()->route('tenant.thanks')->with('success', 'شكراً لطلبك! سيتم التواصل معك قريبًا.');;

        } catch (\Exception $e) {
            DB::rollBack(); // التراجع في حالة حدوث خطأ
            // return response()->json([
            //     'message' => 'حدث خطأ أثناء إنشاء الطلب',
            //     'error' => $e->getMessage()
            // ], 500);
        }

    }
    }
    //order abandoned
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
                $product=SupplierProducts::findOrfail($request->product_id);
                // توليد رقم طلب فريد
                $orderNumber = 'ORD-' . strtoupper(uniqid());

                // إنشاء الطلب
                $supplierId = $product->supplier_id;
                $planId = get_supplier_subscription_data($supplierId)->plan_id;
                $phoneVisibility = plan_phone_visibilty_autorization($planId) ? true : false;
                // get total price
                $total_price=($product->price * $request->qty) + get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                //get shipping cost
                $shipping_cost=get_shipping_cost($request->shipping_and_point,$request->wilaya,$request->dayra,$request->baladia);
                $supplierOrder = SupplierOrderAbandoned::create([
                    'supplier_id' => $product->supplier_id,
                    'order_number' => $orderNumber,
                    'customer_name'=>$request->name,
                    'phone' => $request->phone,
                    'phone_visiblity' => $phoneVisibility,
                    'status' => 'pending',
                    'total_price' => $total_price,
                    'shipping_cost' => $shipping_cost,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
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
                    'unit_price' => $product->price,
                    'total_price' => $total_price,
                ]);

                DB::commit(); // تأكيد العملية


                //notify the supplier about this order
                
                //with telegram api call


                return response()->json([
                    'message' => 'تم إنشاء الطلب بنجاح!',
                    'order' => $supplierOrder
                ], 201);

                // إعادة المستخدم إلى صفحة الشكر
    

            } catch (\Exception $e) {
                DB::rollBack(); // التراجع في حالة حدوث خطأ
                return response()->json([
                    'message' => 'حدث خطأ أثناء إنشاء الطلب',
                    'error' => $e->getMessage()
                ], 500);
            }

        }  
    }
    //function thanks
    public function thanks() 
    {
        if(!session()->has('success'))
        {
            return redirect()->back();
        }
        return view('stores.suppliers.pages.thanks');
    }
    
    //checkout
    public function checkout()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.checkout');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    //get dayras
    public function get_dayras($wilaya_id)
    {
        $dayras=Dayra::where('wilaya_id',$wilaya_id)->get();
        $html='<option value="0" selected>إختر الدائرة...</option>';
        foreach($dayras as $dayra)
        {
            $html.='<option value="'.$dayra->id.'">'.$dayra->ar_name.'</option>';
        }
        return $html;
    }
    //get baladias
    public function get_baladias($dayra_id)
    {
        $baladias=Baladia::where('dayra_id',$dayra_id)->get();
        $html='<option value="0" selected>إختر البلدية...</option>';
        foreach($baladias as $baladia)
        {
            $html.='<option value="'.$baladia->id.'">'.$baladia->ar_name.'</option>';
        }
        return $html;
    }
    //get shipping prices
    public function get_shipping_prices($wilaya_id)
    {
        $prices=ShippingPrice::where('user_id',get_user_data(tenant('id'))->id)->where('wilaya_id',$wilaya_id)->first();
        return response()->json([
            'prices' =>$prices,
        ]);
    }
    //get_wilaya_data
    public function get_wilaya_data($wilaya_id)
    {
        $wilaya=Wilaya::findOrfail($wilaya_id);
        if($wilaya==null)
        {
            $wilaya=['ar_name'=>'ولاية غير معروفة'];
        }
        return response()->json([
            'wilaya' => $wilaya,
        ]);
    }
    //get_wilaya_data
    public function get_dayra_data($wilaya_id)
    {
        $dayra=Dayra::findOrfail($wilaya_id);
        if($dayra==null)
        {
            $dayra=['ar_name'=>'دائرة غير معروفة'];
        }
        return response()->json([
            'dayra' => $dayra,
        ]);
    }
}
