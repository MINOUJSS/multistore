<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserRequestsValidation;
use App\Services\Admins\Admin\SupplierStoreResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = Supplier::with(['user.balance', 'tenant.domains', 'plan_subscription']);

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

        $suppliers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admins.admin.supplier.index', compact('suppliers'));
    }

    // show
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = get_user_data($supplier->tenant_id);

        // Financial & Payment Accounts
        $bankAccount = $user?->bank_settings;
        $chargilySetting = $user?->chargilySettings;

        // Orders Statistics
        $ordersCount = $supplier->orders()->count();
        $deliveredOrdersCount = $supplier->orders()->where('status', 'delivered')->count();
        $pendingOrdersCount = $supplier->orders()->whereIn('status', ['pending', 'processing'])->count();
        $ordersWithProofCount = $supplier->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->count();

        // Orders with payment proofs for auditing
        $ordersWithProofs = $supplier->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();

        return view('admins.admin.supplier.show', compact(
            'supplier',
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

    // change supplier password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $supplier = Supplier::findOrFail($id);
        $user = User::where('tenant_id', $supplier->tenant_id)->first();

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
     * Reset supplier store to initial default settings and layout,
     * strictly preserving supplier's products, orders, and financial accounts.
     *
     * @param Request $request
     * @param int|string $id
     * @param SupplierStoreResetService $resetService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetStore(Request $request, $id, SupplierStoreResetService $resetService)
    {
        $supplier = Supplier::findOrFail($id);
        $user = User::where('tenant_id', $supplier->tenant_id)->first() ?? get_user_data($supplier->tenant_id);

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على حساب المستخدم المرتبط بهذا المورد.',
                ], 404);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط بهذا المورد.');
        }

        try {
            $resetService->reset($supplier, $user);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إعادة ضبط متجر المورد إلى الوضعية الافتراضية بنجاح مع الحفاظ على جميع المنتجات والطلبات.',
                ]);
            }

            return redirect()->back()->with('success', 'تمت إعادة ضبط متجر المورد إلى الوضعية الافتراضية بنجاح.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Supplier Store Reset Failed: ' . $e->getMessage(), [
                'supplier_id' => $supplier->id,
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
