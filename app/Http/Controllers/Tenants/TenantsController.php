<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
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

        //return idex view with user data
            return view('stores.suppliers.index');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // about page
    public function about()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.about');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // privacy policy page
    public function privacy_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.privacy_policy');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // contact us page
    public function contact_us()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.contact_us');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // exchange policy page
    public function exchange_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.exchange_and_return_policy');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // payment policy page
    public function payment_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.payment_methods');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // shipping policy page
    public function shipping_policy()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.shipping_and_handling');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // terms of use page
    public function terms_of_use()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.terms_of_use');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
    // faqpage
    public function faq()
    {
        //check user type
        if(get_user_data(tenant('id'))!=null && get_user_data(tenant('id'))->type=='supplier'){
            //get user data
    
            //return idex view with user data
        return view('stores.suppliers.pages.faq');
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
    
            //return idex view with user data
        return view('stores.suppliers.product-details');
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
}
