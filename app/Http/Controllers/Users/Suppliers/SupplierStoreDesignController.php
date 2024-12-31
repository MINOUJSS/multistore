<?php

namespace App\Http\Controllers\Users\Suppliers;

use Illuminate\Http\Request;
use App\Models\UserStoreSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SupplierStoreDesignController extends Controller
{
    //
    public function index()
    {
        return view('users.suppliers.store-design.index');
    }
    //update theme
    public function theme_update(Request $request,$user_id)
    {
        // filter data 
        // if has file then update logo
        if($image=$request->file('image'))
        {
            $extension=explode('.',$image->getClientOriginalName())[1];
            $name=explode('.',$image->getClientOriginalName())[0];
            $image_name=$name.'-'.time().'.'.$extension;
            $store_name=get_supplier_data(auth()->user()->tenant_id)->store_name;
            $path = 'supplier/'.$store_name.'/images/logo';
            if(!Storage::disk('public')->exists($path))
            {
                Storage::disk('public')->makeDirectory($path);
            }else
            {
                Storage::disk('public')->deleteDirectory($path);
                Storage::disk('public')->makeDirectory($path);
            }
            $image->storeAs($path,$image_name ,'public');
            $supplier_logo=UserStoreSetting::where('user_id',$user_id)->where('key','store_logo')->first();
            $supplier_logo->value='/storage/tenantsupplier/app/public/'.$path.'/'.$image_name;
            $supplier_logo->update();
        }   
        $supplier_theme=UserStoreSetting::where('user_id',$user_id)->where('key','store_theme')->first();
        $supplier_theme->value=json_encode(
        ['primarycolor'=>$request->primarycollor,
            'bodytextcolor'=>$request->bodytextcolor,
            'footertextcolor'=>$request->footertextcolor]);
        $supplier_theme->update();
        return redirect()->back()->with('success','تم التحديث بنجاح');
    }
}
