<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // index
    public function index()
    {
        $sellers = User::where('type', 'seller')->orderBy('id', 'desc')->get();

        return view('admins.admin.seller.index', compact('sellers'));
    }

    // destroy
    public function destroy($id)
    {
        try {
            // Start a transaction for atomicity
            \DB::beginTransaction();
            // select user
            $user = User::find($id);
            // Define the folder path
            // $folderPath = get_seller_store_name('seller/'.$user->tenant_id);
            $folderPath = get_seller_store_name($user->tenant_id);
            // Delete the folder from storage
            if (Storage::disk('seller')->exists($folderPath)) {
                Storage::disk('seller')->deleteDirectory($folderPath);
            }
            // get seller
            $seller = Tenant::find($user->tenant_id);
            // delete seller categories
            foreach (get_seller_categories($user->tenant_id) as $category) {
                $category->delete();
            }
            // delete seller
            $seller->delete();
            // Commit the transaction
            \DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();

            // if(!Storage::disk('public')->exists($folderPath))
            //     {
            //         Storage::disk('public')->makeDirectory($folderPath);
            //     }
            return redirect()->back()->with('success', 'تم حذف البائع بنجاح');
        }
    }
}
