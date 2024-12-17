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
        if(get_user_data(tenant('id'))->type=='supplier'){
        //get user data

        //return idex view with user data
            return view('stores.suppliers.index');
        }

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }
}
