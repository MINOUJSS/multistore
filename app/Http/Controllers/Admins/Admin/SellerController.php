<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserRequestsValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // index
    public function index()
    {
        // $sellers = User::where('type', 'seller')->orderBy('id', 'desc')->get();
        $sellers = Seller::orderBy('id', 'desc')->paginate(10);

        return view('admins.admin.seller.index', compact('sellers'));
    }

    // show seller
    public function show($id)
    {
        $seller = Seller::find($id);
        $user = get_user_data($seller->tenant_id);

        return view('admins.admin.seller.show', compact('seller', 'user'));
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

    // approve seller
    public function approve($id)
    {
        $seller = Seller::find($id);
        $seller->update(['approval_status' => 'approved']);
        // update status inuserRequestValidation table
        $user = get_user_data($seller->tenant_id);
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
        $seller->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'approved',
            'reason' => 'تم توثيق البائع دون توضيحات',
        ]);

        // send notification to user
        $user->notify(new \App\Notifications\Users\Sellers\SellerApprovedNotification($seller));
        // insert message in user notification table
        $user_notification = UserNotification::create([
            'user_id' => $user->id,
            'sender_id' => auth('admin')->id(),
            'type' => 'system',
            'title' => 'توثيق الحساب',
            'body' => 'تم توثيق حسابك بنجاح',
            'icon' => 'check-circle',
            'color' => 'success',
            'action_url' => route('seller.profile'),
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'approval_status' => 'approved', 'message' => 'تم توثيق البائع بنجاح']);
    }

    // un approve seller
    public function unapprove(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'reason' => 'required|string|max:1000',
        ]);

        $seller = Seller::findOrFail($request->seller_id);

        $seller->update([
            'approval_status' => 'pending',
        ]);

        // insert reason
        $seller->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'unapproved',
            'reason' => $request->reason,
        ]);
        // update status inuserRequestValidation table
        $user = get_user_data($seller->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'rejected',
                'reject_reason' => $request->reason,
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }

        // send notification to user
        $user->notify(new \App\Notifications\Users\Sellers\SellerUnApprovedNotification($seller));
        // insert message in user notification table
        $user_notification = UserNotification::create([
            'user_id' => $user->id,
            'sender_id' => auth('admin')->id(),
            'type' => 'system',
            'title' => 'تم حذف أو رفض توثيق الحساب',
            'body' => 'تم حذف أو رفض توثيق الحساب  للسبب أو الأسباب التالية : '.$request->reason,
            'icon' => 'fas fa-ban',
            'color' => 'danger',
            'action_url' => route('seller.profile'),
            'is_read' => false,
        ]);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم حذف توثيق البائع بنجاح',
        // ]);
        return redirect()->back()->with(['approval_status' => 'unapproved', 'success' => true, 'message' => 'تم حذف توثيق البائع بنجاح']);
    }
}
