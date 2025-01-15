<?php

namespace App\Http\Controllers\Tenants;

use App\Models\Dayra;
use App\Models\Wilaya;
use App\Models\Baladia;
use App\Models\UserSlider;
use App\Models\SupplierFqa;
use App\Models\SupplierPage;
use Illuminate\Http\Request;
use App\Models\SupplierProducts;
use App\Models\UserStoreCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            //return idex view with user data
        return view('stores.suppliers.product-details',compact('product','wilayas'));
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
