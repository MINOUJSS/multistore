<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    //index
    public function index()
    {
        $suppliers=User::where('type', 'supplier')->orderBy('id', 'desc')->get();
        return view('admins.admin.supplier.index',compact('suppliers'));
    }
    //destroy
    public function destroy($id)
    {
        try {
            // Start a transaction for atomicity
            \DB::beginTransaction();
            //select user
        $user=User::find($id);
        // Define the folder path
        $folderPath = get_supplier_store_name('supplier/'.$user->tenant_id);
        // Delete the folder from storage
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }
        //get supplier
        $supplier=Tenant::find($user->tenant_id);
        //delete supplier
        $supplier->delete();
             // Commit the transaction
             \DB::commit();
            
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();
            // if(!Storage::disk('public')->exists($folderPath))
            //     {
            //         Storage::disk('public')->makeDirectory($folderPath);
            //     }
            return redirect()->back()->with('success','تم حذف المورد بنجاح');
        }
        
    }
}
