<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminBankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AdminBankAccount::query()->with('admin');

        // Optional filter by account type
        if ($request->filled('type') && in_array($request->type, ['ccp', 'baridimob', 'bank', 'other'])) {
            $query->where('account_type', $request->type);
        }

        // Optional filter by active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == '1');
        }

        // Order by is_default first, then is_active, then newest
        $accounts = $query->orderByDesc('is_default')
            ->orderByDesc('is_active')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        // Statistics for KPI Cards
        $totalAccounts = AdminBankAccount::count();
        $activeAccounts = AdminBankAccount::where('is_active', true)->count();
        $postalAccounts = AdminBankAccount::whereIn('account_type', ['ccp', 'baridimob'])->count();
        $commercialBanks = AdminBankAccount::where('account_type', 'bank')->count();

        return view('admins.admin.bank_accounts.index', compact(
            'accounts',
            'totalAccounts',
            'activeAccounts',
            'postalAccounts',
            'commercialBanks'
        ));
    }

    /**
     * Store a newly created bank account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_type' => 'required|in:ccp,baridimob,bank,other',
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:150',
            'account_number' => 'nullable|string|max:50',
            'ccp_key' => 'nullable|string|max:10',
            'rip' => 'nullable|string|max:35',
            'iban' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ], [
            'account_type.required' => 'يرجى تحديد نوع الحساب البنكي.',
            'bank_name.required' => 'اسم البنك أو المؤسسة مطلوب.',
            'account_name.required' => 'اسم صاحب الحساب مطلوب.',
        ]);

        $validated['admin_id'] = Auth::guard('admin')->id();
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
        $validated['is_default'] = $request->has('is_default') ? (bool) $request->is_default : false;

        // Clean RIP or account number (remove any spaces)
        if (!empty($validated['rip'])) {
            $validated['rip'] = preg_replace('/\s+/', '', $validated['rip']);
        }
        if (!empty($validated['account_number'])) {
            $validated['account_number'] = preg_replace('/\s+/', '', $validated['account_number']);
        }

        // If this account is marked as default, unset other defaults of the same type
        if ($validated['is_default']) {
            AdminBankAccount::where('account_type', $validated['account_type'])
                ->update(['is_default' => false]);
        }

        $account = AdminBankAccount::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة الحساب البنكي بنجاح.',
                'data' => $account,
            ]);
        }

        Alert::success('تمت الإضافة بنجاح', 'تم تسجيل الحساب البنكي بنجاح.');
        return redirect()->route('admin.bank_accounts.index')->with('success', 'تم تسجيل الحساب البنكي بنجاح.');
    }

    /**
     * Show the form for editing the specified resource via AJAX or direct.
     */
    public function edit($id)
    {
        $account = AdminBankAccount::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'account' => $account,
            ]);
        }

        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = AdminBankAccount::findOrFail($id);

        $validated = $request->validate([
            'account_type' => 'required|in:ccp,baridimob,bank,other',
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:150',
            'account_number' => 'nullable|string|max:50',
            'ccp_key' => 'nullable|string|max:10',
            'rip' => 'nullable|string|max:35',
            'iban' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ], [
            'account_type.required' => 'يرجى تحديد نوع الحساب البنكي.',
            'bank_name.required' => 'اسم البنك أو المؤسسة مطلوب.',
            'account_name.required' => 'اسم صاحب الحساب مطلوب.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        $validated['is_default'] = $request->has('is_default') ? (bool) $request->is_default : false;

        // Clean RIP or account number
        if (!empty($validated['rip'])) {
            $validated['rip'] = preg_replace('/\s+/', '', $validated['rip']);
        }
        if (!empty($validated['account_number'])) {
            $validated['account_number'] = preg_replace('/\s+/', '', $validated['account_number']);
        }

        // If marked as default, unset other defaults of the same type
        if ($validated['is_default']) {
            AdminBankAccount::where('account_type', $validated['account_type'])
                ->where('id', '!=', $account->id)
                ->update(['is_default' => false]);
        }

        $account->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث بيانات الحساب البنكي بنجاح.',
                'data' => $account,
            ]);
        }

        Alert::success('تم التحديث', 'تم تعديل بيانات الحساب البنكي بنجاح.');
        return redirect()->route('admin.bank_accounts.index')->with('success', 'تم تعديل بيانات الحساب البنكي بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = AdminBankAccount::findOrFail($id);
        $accountName = $account->bank_name . ' (' . $account->account_name . ')';
        $account->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الحساب البنكي بنجاح.',
            ]);
        }

        Alert::success('تم الحذف', "تم حذف الحساب {$accountName} بنجاح.");
        return redirect()->route('admin.bank_accounts.index')->with('success', 'تم حذف الحساب البنكي بنجاح.');
    }

    /**
     * Toggle active/inactive status of a bank account.
     */
    public function toggleStatus($id)
    {
        $account = AdminBankAccount::findOrFail($id);
        $account->is_active = !$account->is_active;
        $account->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $account->is_active,
                'message' => $account->is_active ? 'تم تفعيل الحساب البنكي بنجاح.' : 'تم إيقاف تفعيل الحساب البنكي.',
            ]);
        }

        $statusText = $account->is_active ? 'تفعيل' : 'إيقاف';
        Alert::success('تغيير الحالة', "تم {$statusText} الحساب بنجاح.");
        return redirect()->route('admin.bank_accounts.index')->with('success', "تم {$statusText} الحساب بنجاح.");
    }
}
