<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\ChargilySettingForTenants;
use App\Models\Supplier\Supplier;
use App\Models\User;
use App\Models\UserBanckAccounts;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupplierProfileController extends Controller
{
    public function index()
    {
        $supplier = Supplier::findOrfail(get_supplier_data(auth()->user()->tenant_id)->id);
        $user = get_user_data(auth()->user()->tenant_id);
        $wilayas = Wilaya::get();
        $chargily_settings = $user->chargilySettings;
        $bank_settings = $user->bank_settings;

        //   dd($chargily_settings);
        return view('users.suppliers.profile.index', compact('supplier', 'user', 'wilayas', 'chargily_settings', 'bank_settings'));
    }

    public function update(Request $request)
    {
        // validatation
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'store_name' => 'required',
            'id_card_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $supplier = Supplier::findOrfail(get_supplier_data(auth()->user()->tenant_id)->id);
        $user = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        // dd($user->email);
        $old_email = $user->email;
        $old_phone = $user->phone;
        // check if uploded image
        if ($request->hasFile('id_card_image')) {
            // delete old image if exist form storege
            if (Storage::disk('supplier')->exists(get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/id_card_image')) {
                Storage::disk('supplier')->deleteDirectory(get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/id_card_image');
            }
            $path = $request->file('id_card_image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/id_card_image', 'public');
            $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path);
            $supplier->id_card_image = $url;
            // chenge approval_status
            $supplier->approval_status == 'pending';
        }
        $supplier->full_name = $request->full_name;
        $user->name = $request->full_name;
        $supplier->last_name = $request->last_name;
        $supplier->first_name = $request->first_name;
        $user->email == $request->email;
        $user->phone == $request->phone;
        $user->update();
        $user_beta = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        if ($old_email != $user_beta->email || $old_phone != $user_beta->phone) {
            // chenge approval_status
            $supplier->approval_status == 'pending';
        }
        if ($request->sex != 'null') {
            $supplier->sex = $request->sex;
        }
        $supplier->birth_date = $request->birth_date;
        $supplier->store_name = $request->store_name;
        if ($request->part_of_approved_list) {
            $supplier->part_of_approved_list = 'yes';
        } else {
            $supplier->part_of_approved_list = 'no';
        }

        if ($request->wilaya !== 'null') {
            $supplier->wilaya = $request->wilaya;
        }

        if ($request->dayra !== 'null') {
            $supplier->dayra = $request->dayra;
        }

        if ($request->baladia !== 'null') {
            $supplier->baladia = $request->baladia;
        }

        $supplier->address = $request->address;
        $supplier->update();

        return redirect()->back()->with('success', 'تم تحديث بيانات المورد بنجاح');
    }

    // Change password
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',  // Added minimum length requirement
            'password_confirmation' => 'required',
        ]);

        // Validate the request
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('activate_security_tab', true) // Add this line
                ->with('active_tab', 'store_setting');
        }
        $user = User::findOrFail(auth()->user()->id);  // Simplified user retrieval

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()
            ->with('activate_security_tab', true) // Add this line
            ->with('error', 'كلمة المرور القديمة غير صحيحة');
        } else {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        // $user->password = Hash::make($request->password);
        // $user->save();  // Changed from update() to save()

        return redirect()->back()
        ->with('activate_security_tab', true) // Add this line
        ->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    // create orupdate chargily settings
    public function create_or_update_chargily_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'public_key' => 'required',
            'secret_key' => 'required',
        ]);

        // Validate the request
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('activate_chargily_tab', true) // Add this line
                ->with('active_tab', 'chargily_setting');
        }

        $user = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        $chargily_settings = $user->chargilySettings;
        if ($chargily_settings == null) {
            $chargily_settings = new ChargilySettingForTenants();
            $chargily_settings->user_id = get_user_data(auth()->user()->tenant_id)->id;
        }
        $chargily_settings->public_key = $request->public_key;
        $chargily_settings->secret_key = $request->secret_key;
        if ($request->mode) {
            $chargily_settings->mode = 'live';
        } else {
            $chargily_settings->mode = 'test';
        }
        $chargily_settings->save();

        return redirect()->back()
        ->with('activate_chargily_tab', true) // Add this line
        ->with('success', 'تم تحديث بيانات شارجيلي بنجاح');
    }

    // delete chargily settings
    public function delete_chargily_settings(Request $request)
    {
        $user = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        $chargily_settings = $user->chargilySettings;
        $chargily_settings->delete();
        // make the supplier not approved
        $supplier = Supplier::findOrfail(get_supplier_data(auth()->user()->tenant_id)->id);
        $supplier->approval_status = 'pending';
        $supplier->update();

        // return back
        return redirect()->back()
        ->with('activate_chargily_tab', true) // Add this line
        ->with('success', 'تم حذف بيانات شارجيلي بنجاح');
    }

    public function create_or_update_bank_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
        ]);

        // Validate the request
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('activate_bank_tab', true) // Add this line
                ->with('active_tab', 'bank_setting');
        }

        $user = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        $bank_settings = $user->bank_settings;
        if ($bank_settings == null) {
            $bank_settings = new UserBanckAccounts();
            $bank_settings->user_id = get_user_data(auth()->user()->tenant_id)->id;
        }
        $bank_settings->name = $request->name;
        $bank_settings->bank_name = $request->bank_name;
        $bank_settings->account_number = $request->account_number;
        $bank_settings->save();

        return redirect()->back()
        ->with('activate_bank_tab', true) // Add this line
        ->with('success', 'تم تحديث بيانات البنك بنجاح');
    }

    // delete bank settings
    public function delete_bank_settings(Request $request)
    {
        $user = User::findOrfail(get_user_data(auth()->user()->tenant_id)->id);
        $bank_settings = $user->bank_settings;
        $bank_settings->delete();
        // make the supplier not approved
        $supplier = Supplier::findOrfail(get_supplier_data(auth()->user()->tenant_id)->id);
        $supplier->approval_status = 'pending';
        $supplier->update();

        // return back
        return redirect()->back()
        ->with('activate_bank_tab', true) // Add this line
        ->with('success', 'تم حذف بيانات البنك بنجاح');
    }

    // update avatar
    public function update_avatar(Request $request)
    {
        // uplode the avatar
        $supplier = get_supplier_data(auth()->user()->tenant_id);
        if ($request->hasFile('avatar_Image')) {
            // delete old image if exist form storege
            if (Storage::disk('supplier')->exists(get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/avatar')) {
                Storage::disk('supplier')->deleteDirectory(get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/avatar');
            }
            $path = $request->file('avatar_Image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/profile/avatar', 'public');
            $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path);
            $supplier->avatar = $url;
            // chenge approval_status
            $supplier->approval_status == 'pending';
        }
        $supplier->save();

        return response()->json([
            'success' => true,
            'avatar' => $url,
            'message' => 'تم تحديث الصورة بنجاح',
        ]);
    }
}
