<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SupplierProducts;
use App\Models\UserStoreCategory;
use App\Http\Controllers\Controller;

class SupplierProductController extends Controller
{
    //
    public function index()
    {
        $store_categories=UserStoreCategory::where('user_id',auth()->user()->id)->get();
        $categories_ids=[];
        foreach($store_categories as $category)
        {
            $categories_ids[]=$category->category_id;
        }
    
        //get categories data in array
        foreach($categories_ids as $id)
        {
            $categories[]=Category::find($id);
        }
        $products=SupplierProducts::orderBy('id', 'desc')->get();
        return view('users.suppliers.products.index', compact('products', 'categories'));
    }
    //
    public function edit($product_id)
    {
        $product=SupplierProducts::find($product_id);
        return response()->json([
            'status' => '200',
            'product' => $product,
        ]);
    } 
    //
    public function update(Request $request,$product_id)
    {
        dd($request);
    }

}
