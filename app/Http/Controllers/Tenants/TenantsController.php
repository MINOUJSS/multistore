<?php

namespace App\Http\Controllers\Tenants;

use Google_Client;
use App\Models\Dayra;
use App\Models\Wilaya;
use GuzzleHttp\Client;
use App\Models\Baladia;
use App\Models\UserSlider;
use Google_Service_Sheets;
use App\Models\SupplierFqa;
use App\Models\UserBalance;
use App\Models\SupplierPage;
use Illuminate\Http\Request;
use App\Models\SupplierOrders;
use App\Models\SupplierProducts;
use App\Models\UserStoreCategory;
use App\Models\SupplierOrderItems;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\SupplierProductImages;
use Google_Service_Sheets_ValueRange;
use App\Models\SupplierProductAttributes;
use App\Models\SupplierProductVariations;
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
            $page= SupplierPage::where('slug','about')->first();
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
    public function product($id)
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
            $wilayas=Wilaya::all();
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
            'supplier_id' => 'required|exists:suppliers,id',
            // 'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^0[5-7][0-9]{8}$/',
            'address' => 'required|string|max:500',
            // 'wilaya' => 'required|integer|exists:wilayas,id',
            // 'dayrea' => 'required|integer|exists:dayreas,id',
            // 'baladia' => 'required|integer|exists:baladias,id',
            // 'shipping_and_point' => 'required|in:home,store',
            // 'product_id' => 'required|exists:supplier_products,id',
            // 'product_varition' => 'nullable|exists:supplier_product_variations,id',
            // 'product_attribute' => 'nullable|exists:supplier_product_attributes,id',
            'qty' => 'required|integer|min:1',
            // 'price' => 'required|numeric|min:0',
            // 'form_total_amount' => 'required|numeric|min:0',
            // 'shipping_cost' => 'required|numeric|min:0',
            // 'payment_method' => 'required|in:cash_on_delivery,credit_card,bank_transfer',
        ]);

        try {
            DB::beginTransaction(); // بدء المعاملة

            // توليد رقم طلب فريد
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // إنشاء الطلب
            $supplierOrder = SupplierOrders::create([
                'supplier_id' => $request->supplier_id,
                'order_number' => $orderNumber,
                'customer_name'=>$request->name,
                'phone' => $request->phone,
                'status' => 'pending',
                'total_price' => $request->form_total_amount,
                'shipping_cost' => $request->shipping_cost,
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
                'unit_price' => $request->price,
                'total_price' => $request->form_total_amount,
            ]);

                        
            //add 10 d.a to user balance 
            //get user
            $user=get_user_data(tenant('id'));
            //update user balance
            $balance=UserBalance::where('user_id',$user->id)->first();
            $balance->outstanding_amount=$balance->outstanding_amount+get_platform_comition($request->price);
            $balance->update();

            DB::commit(); // تأكيد العملية

            // إدراج الطلب في Google Sheets
            $this->insertOrderToGoogleSheet($supplierOrder);

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
    //function thanks
    function thanks() 
    {
        if(!session()->has('success'))
        {
            return redirect()->back();
        }
        return view('stores.suppliers.pages.thanks');
    }
    /**
     * إدراج الطلب في Google Sheets عبر Webhook
     */
    private function insertOrderToGoogleSheet($order)
    {
        try {
            $spreadsheetId = "1XOfN-5TI0LBDRFefQLemlkOjyCVTaF8jqwLt7wIbr9Y"; // Google Sheet ID
            $range = "Orders"; // اسم الورقة داخل الملف
    
            $client = new Google_Client();
            $client->setApplicationName("Google Sheets API Laravel");
            $client->setAuthConfig(base_path('/asset/googleSheet/credentials.json')); 
            $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    
            $service = new Google_Service_Sheets($client);
    
            $values = [
                [
                    now()->format('Y-m-d H:i:s'), // الوقت الحالي
                    $order->order_number ?? 'N/A',
                    $order->customer_name ?? 'N/A',
                    $order->phone ?? 'N/A',
                    $order->shipping_address ?? 'N/A',
                    $order->total_price ?? 0,
                    $order->shipping_cost ?? 0,
                    $order->payment_method ?? 'Unknown',
                    $order->status ?? 'Pending'
                ]
            ];
    
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
    
            $params = ['valueInputOption' => 'RAW'];
    
            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    
        } catch (\Exception $e) {
            \Log::error("Error inserting order to Google Sheets: " . $e->getMessage());
        }
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
    function get_dayras($wilaya_id)
    {
        $dayras=Dayra::where('wilaya_id',$wilaya_id)->get();
        $html='<option selected>إختر الدائرة...</option>';
        foreach($dayras as $dayra)
        {
            $html.='<option value="'.$dayra->id.'">'.$dayra->ar_name.'</option>';
        }
        return $html;
    }
    //get baladias
    function get_baladias($dayra_id)
    {
        $baladias=Baladia::where('dayra_id',$dayra_id)->get();
        $html='<option selected>إختر البلدية...</option>';
        foreach($baladias as $baladia)
        {
            $html.='<option value="'.$baladia->id.'">'.$baladia->ar_name.'</option>';
        }
        return $html;
    }
}
