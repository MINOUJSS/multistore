<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompaines;
use App\Models\ShippingPrice;
use App\Services\Users\CourierdzService;
use Illuminate\Http\Request;

class SupplierShippingController extends Controller
{
    public function index()
    {
        $companies = ShippingCompaines::all();
        $yalidin = ShippingCompaines::where('name', '=', 'YALIDINE')->first();
        $zrexpress = ShippingCompaines::where('name', '=', 'ZREXPRESS')->first();
        $dhd = ShippingCompaines::where('name', '=', 'DHD')->first();
        $maystro = ShippingCompaines::where('name', '=', 'MAYSTRO_DELIVERY')->first();

        return view('users.suppliers.shipping.index', compact('yalidin', 'zrexpress', 'dhd', 'maystro', 'companies'));
    }

    public function edit()
    {
        $prices = ShippingPrice::where('user_id', auth()->user()->id)->get();

        return view('users.suppliers.shipping.edit', compact('prices'));
    }

    public function update(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'wilaya_*' => 'nullable|in:on',
            'to_home_wilaya_*' => 'nullable|in:on',
            'to_stop_desck_wilaya_*' => 'nullable|in:on',
            'additional_wilaya_*' => 'nullable|in:on',

            'to_home_w_*' => 'nullable|numeric|min:0',
            'to_desck_w_*' => 'nullable|numeric|min:0',
            'additional_w_*' => 'nullable|numeric|min:0',
        ], [
            // الرسائل المخصصة
            'to_home_w_*.numeric' => 'يجب أن يكون سعر الشحن للمنزل رقمًا صالحًا.',
            'to_desck_w_*.numeric' => 'يجب أن يكون سعر الشحن للمكتب رقمًا صالحًا.',
            'additional_w_*.numeric' => 'يجب أن يكون السعر الإضافي رقمًا صالحًا.',

            'to_home_w_*.min' => 'يجب أن يكون سعر الشحن للمنزل على الأقل 0.',
            'to_desck_w_*.min' => 'يجب أن يكون سعر الشحن للمكتب على الأقل 0.',
            'additional_w_*.min' => 'يجب أن يكون السعر الإضافي على الأقل 0.',
        ]);

        // تحديث البيانات لكل ولاية
        foreach ($request->except('_token') as $key => $value) {
            if (preg_match('/to_home_w_(\d+)/', $key, $matches)) {
                $wilayaId = $matches[1];

                $wilaya_checkbox = "wilaya_$wilayaId";
                $shipping_available_to_wilaya = $request->$wilaya_checkbox !== null ? 1 : 0;
                $to_home_checkbox = "to_home_wilaya_$wilayaId";
                $shipping_available_to_home = $request->$to_home_checkbox !== null ? 1 : 0;
                $to_stop_desck_checkbox = "to_stop_desck_wilaya_$wilayaId";
                $shipping_available_to_stop_desck = $request->$to_stop_desck_checkbox !== null ? 1 : 0;
                $additional_checkbox = "additional_wilaya_$wilayaId";
                $additional_price_status = $request->$additional_checkbox !== null ? 1 : 0;
                $to_home_price = "to_home_w_$wilayaId";
                $to_desck_price = "to_desck_w_$wilayaId";
                $additional_price = "additional_w_$wilayaId";

                // dd($request->$to_home);
                ShippingPrice::where('user_id', auth()->user()->id)->where('wilaya_id', $wilayaId)->update([
                    'shipping_available_to_wilaya' => $shipping_available_to_wilaya,
                    'shipping_available_to_stop_desck' => $shipping_available_to_stop_desck,
                    'shipping_available_to_home' => $shipping_available_to_home,
                    'additional_price_status' => $additional_price_status,
                    'to_home_price' => $request->$to_home_price,
                    'stop_desck_price' => $request->$to_desck_price,
                    'additional_price' => $request->$additional_price,
                ]);
            }
        }

        // sweet alert
        return redirect()->back()->with('success', 'تم تحديث التسعيرات بنجاح.');
    }

    public function add_shipping_company(Request $request)
    {
        // validate Yalidin data
        if ($request->name === 'YALIDINE') {
            // ✅ تحقق من صحة البيانات
            $validatedData = $request->validate([
                'wilaya' => 'required|string|max:100',
                'api_id' => 'required|string|max:255',
                'api_token' => 'required|string|max:255',
            ], [
                // ✅ تخصيص رسائل الخطأ
                'wilaya.required' => 'يرجى إدخال ولاية الشحن.',
                'api_id.required' => 'يرجى إدخال API ID.',
                'api_token.required' => 'يرجى إدخال API TOKEN.',
            ]);
            // ----
            $data = json_encode([
                'logo' => 'https://i.imgur.com/LNDFb1h.png',
                'wilaya' => $request->wilaya,
                'api_id' => $request->api_id,
                'api_token' => $request->api_token,
            ]);
        }
        // validate zrexpress data
        elseif ($request->name === 'ZREXPRESS') {
            // ✅ تحقق من صحة البيانات
            $validatedData = $request->validate([
                'token' => 'required|string|max:255',
                'cle' => 'required|string|max:255',
            ], [
                // ✅ تخصيص رسائل الخطأ
                'token.required' => 'يرجى إدخال Token.',
                'cle.required' => 'يرجى إدخال Cle.',
            ]);
            // ----
            $data = json_encode([
                'logo' => 'https://i.imgur.com/eL1fmUM.jpeg',
                'token' => $request->token,
                'cle' => $request->cle,
            ]);
        } elseif ($request->name === 'DHD') {
            // ✅ تحقق من صحة البيانات
            $validatedData = $request->validate([
                'token' => 'required|string|max:255',
            ], [
                // ✅ تخصيص رسائل الخطأ
                'token.required' => 'يرجى إدخال Token.',
            ]);
            // ----
            $data = json_encode([
                'logo' => 'https://i.imgur.com/PrM01pT.png',
                'token' => $request->token,
            ]);
        } elseif ($request->name === 'MAYSTRO_DELIVERY') {
            $validatedData = $request->validate([
                'id' => 'required|string|max:255',
                'key' => 'required|string|max:255',
            ], [
                // ✅ تخصيص رسائل الخطأ
                'id' => 'يرجى إدخال id.',
                'key.required' => 'يرجى إدخال key.',
            ]);
            // ----
            $data = json_encode([
                'logo' => 'https://i.imgur.com/Pjv1wp2.pngs',
                'id' => $request->id,
                'key' => $request->key,
            ]);
        }
        // // test courierdz credentials before save
        // $courierdz = new CourierdzService(1, auth()->user()->type, $request->name);
        // $result = $courierdz->testCredentials();
        // return response()->json($result); //$result;

        // ✅ إنشاء أو تحديث بيانات شركة الشحن
        $user_id = auth()->user()->id;
        // if ($result) {
        $shippingCompany = ShippingCompaines::updateOrCreate(
            ['name' => $request->name,
                'user_id' => $user_id,
            ], // البحث عن الشركة بناءً على الاسم
            [
                'data' => $data,
            ]
        );

        // ✅ إرسال رسالة نجاح
        return response()->json([
            'success' => true,
            'message' => 'تم حفظ بيانات شركة الشحن بنجاح!',
            'data' => $shippingCompany,
        ]);
        // } else {
        //     // ✅ إرسال رسالة نجاح
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'بيانات الإتصال بشركة التوصيل خاطئة!',
        //     ]);
        // }
    }

    public function delete_shipping_company($id)
    {
        $shippingCompany = ShippingCompaines::findOrfail($id);
        $shippingCompany->delete();

        //
        // return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح']);
        return redirect()->back()->with('success', 'تم حذف بيانات شركة الشحن بنجاح!');
    }

    public function updateShippingStatus(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:shipping_compaines,id',
            'status' => 'required|in:active,inactive',
        ]);
        $company = ShippingCompaines::findOrFail($request->company_id);
        $company->status = $request->status;
        $company->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح']);
    }

    // get get_shipping_cost
    public function get_shipping_cost(Request $request)
    {
        $wilaya_id = $request->wilaya_id;
        $dayra_id = $request->dayra_id;
        $baladia_id = $request->baladia_id;
        $shipping_type = $request->shipping_type;

        $shipping_price = ShippingPrice::where('user_id', auth()->user()->id)->where('wilaya_id', $wilaya_id)->first();

        if (!$shipping_price) {
            return response()->json([
                'success' => false,
                'shipping_cost' => 0,
            ]);
        }

        if ($dayra_id == 0 && $baladia_id == 0 && $shipping_type == 'to_home') {
            return response()->json([
                'success' => true,
                'shipping_cost' => $shipping_price->to_home_price,
            ]);
        } elseif ($dayra_id != 0 && $shipping_type == 'to_home') {
            return response()->json([
                'success' => true,
                'shipping_cost' => $shipping_price->to_home_price + $shipping_price->additional_price,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'shipping_cost' => $shipping_price->stop_desck_price,
            ]);
        }
    }
}
