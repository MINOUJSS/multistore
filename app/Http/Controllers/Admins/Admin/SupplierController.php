<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserRequestsValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    // index
    public function index()
    {
        // $suppliers = User::where('type', 'supplier')->orderBy('id', 'desc')->paginate(10);
        $suppliers = Supplier::orderBy('id', 'desc')->paginate(10);

        return view('admins.admin.supplier.index', compact('suppliers'));
    }

    // show
    public function show($id)
    {
        $supplier = Supplier::find($id);
        $user = get_user_data($supplier->tenant_id);

        return view('admins.admin.supplier.show', compact('supplier', 'user'));
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
            // $folderPath = get_supplier_store_name('supplier/'.$user->tenant_id);
            $folderPath = get_supplier_store_name($user->tenant_id);
            // Delete the folder from storage
            if (Storage::disk('supplier')->exists($folderPath)) {
                Storage::disk('supplier')->deleteDirectory($folderPath);
            }
            // get supplier
            $supplier = Tenant::find($user->tenant_id);
            // delete supplier categories
            foreach (get_supplier_categories($user->tenant_id) as $category) {
                $category->delete();
            }
            // delete supplier
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
            return redirect()->back()->with('success', 'تم حذف المورد بنجاح');
        }
    }

    // approve supplier
    public function approve($id)
    {
        $supplier = Supplier::find($id);
        $supplier->update(['approval_status' => 'approved']);
        // update status inuserRequestValidation table
        $user = get_user_data($supplier->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'approved',
                'approval_notes' => 'تم توثيق البائع دون توضيحات',
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }
        // insert reason
        $supplier->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'approved',
            'reason' => 'تم توثيق البائع دون توضيحات',
        ]);

        return response()->json(['success' => true, 'approval_status' => 'approved', 'message' => 'تم توثيق البائع بنجاح']);
    }

    // un approve supplier
    public function unapprove(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'reason' => 'required|string|max:1000',
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id);

        $supplier->update([
            'approval_status' => 'pending',
        ]);

        // insert reason
        $supplier->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'unapproved',
            'reason' => $request->reason,
        ]);

        // update status inuserRequestValidation table
        $user = get_user_data($supplier->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'rejected',
                'reject_reason' => $request->reason,
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم حذف توثيق البائع بنجاح',
        // ]);
        return redirect()->back()->with(['approval_status' => 'unapproved', 'success' => true, 'message' => 'تم حذف توثيق البائع بنجاح']);
    }
}
