<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Users\CourierdzService;

class CourierdzController extends Controller
{
    //connection
    public function testCredentials(Request $request)
    {
        // courierdz
        $courierdz = new CourierdzService(1,auth()->user()->type,$request->name);
        return response()->json($courierdz->testCredentials());
    }
    //create order
    public function createOrder(Request $request)
    {
        // courierdz
        $courierdz = new CourierdzService($request->order_id,auth()->user()->type,$request->shipping_company);
        return $courierdz->createOrder();
    }
    //get providers list
    public function providersList(Request $request,$id)
    {
        // courierdz
        $courierdz = new CourierdzService($id,auth()->user()->type,'yalidin');
        return $courierdz->providersList();
    }
}
