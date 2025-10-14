<?php

namespace App\Http\Controllers\Users\Suppliers;

use Illuminate\Http\Request;
use App\Models\Supplier\SupplierAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierAttributeController extends Controller
{
   
    //create
    function create(Request $request)
    {
         //validate
            $validator = Validator::make($request->all(),[
                'attribute_name'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }
         //create attribute
         $attribute= new SupplierAttribute;
         $user_id=auth()->user()->id;
         $supplier_slug=tenant_to_slug(auth()->user()->tenant_id);
        $attribute->user_id=$user_id;
        $attribute->name=$request->attribute_name;
        $attribute->slug=$supplier_slug.'-'.$request->attribute_name;
        $attribute->save();
        return response()->json([
            'status' => 'success',
            'message' =>'save attribute successfully',
        ]);
    }
    //get user attributes
    function get_user_attributes($user_id)
    {
        $attributes=SupplierAttribute::where('user_id',$user_id)->get();
        return response()->json([
            'status' => 'success',
            'attributes' => $attributes,
        ]);
    }
}
