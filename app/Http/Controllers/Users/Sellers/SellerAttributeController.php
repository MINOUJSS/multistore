<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerAttributeController extends Controller
{
    // create
    public function create(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'attribute_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        // create attribute
        $attribute = new SellerAttribute();
        $user_id = auth()->user()->id;
        $seller_slug = tenant_to_slug(auth()->user()->tenant_id);
        $attribute->user_id = $user_id;
        $attribute->name = $request->attribute_name;
        $attribute->slug = $seller_slug.'-'.$request->attribute_name;
        $attribute->save();

        return response()->json([
            'status' => 'success',
            'message' => 'save attribute successfully',
        ]);
    }

    // get user attributes
    public function get_user_attributes($user_id)
    {
        $attributes = SellerAttribute::where('user_id', $user_id)->get();

        return response()->json([
            'status' => 'success',
            'attributes' => $attributes,
        ]);
    }
}
