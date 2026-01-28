<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerStoreDesignController extends Controller
{
    public function index()
    {
        return view('users.sellers.store-design.index');
    }

    // update theme
    public function theme_update(Request $request, $user_id)
    {
        // filter data
        // if has file then update logo
        if ($image = $request->file('image')) {
            $extension = explode('.', $image->getClientOriginalName())[1];
            $name = explode('.', $image->getClientOriginalName())[0];
            $image_name = $name.'-'.time().'.'.$extension;
            $store_name = get_seller_data(auth()->user()->tenant_id)->store_name;
            $path = 'seller/'.$store_name.'/images/logo';
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            } else {
                Storage::disk('public')->deleteDirectory($path);
                Storage::disk('public')->makeDirectory($path);
            }
            $image->storeAs($path, $image_name, 'public');
            $seller_logo = UserStoreSetting::where('user_id', $user_id)->where('key', 'store_logo')->first();
            if ($seller_logo == null) {
                $seller_logo = new UserStoreSetting();
                $seller_logo->user_id = $user_id;
                $seller_logo->key = 'store_logo';
                $seller_logo->value = '/storage/tenantseller/app/public/'.$path.'/'.$image_name;
                $seller_logo->save();
            }
            $seller_logo->value = '/storage/tenantseller/app/public/'.$path.'/'.$image_name;
            $seller_logo->update();
        }
        $seller_theme = UserStoreSetting::where('user_id', $user_id)->where('key', 'store_theme')->first();
        if ($seller_theme == null) {
            $seller_theme = new UserStoreSetting();
            $seller_theme->user_id = $user_id;
            $seller_theme->key = 'store_theme';
            $seller_theme->value = json_encode(
                ['primarycolor' => $request->primarycollor,
                    'bodytextcolor' => $request->bodytextcolor,
                    'footertextcolor' => $request->footertextcolor]
            );
            $seller_theme->save();
        }
        $seller_theme->value = json_encode(
            ['primarycolor' => $request->primarycollor,
                'bodytextcolor' => $request->bodytextcolor,
                'footertextcolor' => $request->footertextcolor]);
        $seller_theme->update();

        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }
}
