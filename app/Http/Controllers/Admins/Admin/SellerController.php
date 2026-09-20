<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserRequestsValidation;
use App\Services\Admins\Admin\SellerStoreResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = Seller::with(['user.balance', 'tenant.domains', 'plan_subscription']);

        // Full-table search: name, phone, store name, email
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('store_name', 'like', "%{$search}%")
                  ->orWhere('tenant_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sellers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admins.admin.seller.index', compact('sellers'));
    }

    // show seller
    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        $user = get_user_data($seller->tenant_id);

        // Financial & Payment Accounts
        $bankAccount = $user?->bank_settings;
        $chargilySetting = $user?->chargilySettings;

        // Orders Statistics
        $ordersCount = $seller->orders()->count();
        $deliveredOrdersCount = $seller->orders()->where('status', 'delivered')->count();
        $pendingOrdersCount = $seller->orders()->whereIn('status', ['pending', 'processing'])->count();
        $ordersWithProofCount = $seller->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->count();

        // Orders with payment proofs for auditing
        $ordersWithProofs = $seller->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();

        return view('admins.admin.seller.show', compact(
            'seller',
            'user',
            'bankAccount',
            'chargilySetting',
            'ordersCount',
            'deliveredOrdersCount',
            'pendingOrdersCount',
            'ordersWithProofCount',
            'ordersWithProofs'
        ));
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

    // change seller password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $seller = Seller::findOrFail($id);
        $user = User::where('tenant_id', $seller->tenant_id)->first();

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'لم يتم العثور على حساب المستخدم المرتبط'], 442);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تغيير كلمة المرور بنجاح',
                'new_password' => $request->password,
            ]);
        }

        return redirect()->back()->with([
            'success' => 'تم تغيير كلمة المرور بنجاح',
            'new_password' => $request->password,
        ]);
    }

    /**
     * Reset seller store to initial default settings and layout,
     * strictly preserving seller's products, orders, and financial accounts.
     *
     * @param Request $request
     * @param int|string $id
     * @param SellerStoreResetService $resetService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetStore(Request $request, $id, SellerStoreResetService $resetService)
    {
        $seller = Seller::findOrFail($id);
        $user = User::where('tenant_id', $seller->tenant_id)->first() ?? get_user_data($seller->tenant_id);

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.',
                ], 404);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.');
        }

        try {
            $resetService->reset($seller, $user);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إعادة ضبط متجر البائع إلى الوضعية الافتراضية بنجاح مع الحفاظ على جميع المنتجات والطلبات.',
                ]);
            }

            return redirect()->back()->with('success', 'تمت إعادة ضبط متجر البائع إلى الوضعية الافتراضية بنجاح.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Seller Store Reset Failed: ' . $e->getMessage(), [
                'seller_id' => $seller->id,
                'exception' => $e,
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إعادة ضبط المتجر: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء إعادة ضبط المتجر: ' . $e->getMessage());
        }
    }
}
