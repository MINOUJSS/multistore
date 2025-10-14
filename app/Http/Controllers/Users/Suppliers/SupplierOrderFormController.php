<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;

class SupplierOrderFormController extends Controller
{
    public function index()
    {
        $form_settings = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_order_form_settings')->first();
        $order_form = json_decode($form_settings->value);

        return view('users.suppliers.pages.sections.order_form.index', compact('order_form'));
    }

    public function updateOrderForm(Request $request)
    {
        $validated = $request->validate([
            'form_title_controller' => 'sometimes|nullable|string|max:255',
            'submit_btn' => 'sometimes|nullable|string|max:50',
            'form_lable_customer_name_controller' => 'sometimes|nullable|string|max:100',
            'form_placeholder_customer_name_controller' => 'nullable|string|max:100',
            'form_required_customer_name_controller' => 'nullable',
            'form_lable_customer_phone_controller' => 'sometimes|nullable|string|max:100',
            'form_placeholder_customer_phone_controller' => 'nullable|string|max:100',
            'form_lable_customer_address_controller' => 'nullable|string|max:100',
            'form_placeholder_customer_address_controller' => 'nullable|string|max:100',
            'form_required_customer_address_controller' => 'nullable',
            'form_required_customer_address_status_controller' => 'nullable',
            'form_lable_customer_notes_controller' => 'nullable|string|max:100',
            'form_placeholder_customer_notes_controller' => 'nullable|string|max:100',
            'form_required_customer_notes_controller' => 'nullable',
            'form_required_customer_notes_status_controller' => 'nullable',
            'form_product_coupon_code_controller' => 'nullable|string|max:100',
            'form_placeholder_coupon_code_controller' => 'nullable|string|max:100',
        ]);

        // Process the form data (save to database, etc.)
        // For example:
        // $orderForm = OrderForm::firstOrNew(['user_id' => auth()->id()]);
        // $orderForm->fill($validated);
        // $orderForm->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم حفظ الإعدادات بنجاح',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }

        try {
            // Get the current settings
            $setting = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_order_form_settings')->first();

            if (!$setting) {
                return response()->json([
                    'success' => false,
                    'message' => 'الإعدادات غير موجودة',
                ], 404);
            }

            // Decode the current JSON value
            $currentSettings = json_decode($setting->value, true);

            // Update the values with the new data from the request
            if($request->input('form_title_controller') != '') {
              $currentSettings['form_title'] = $request->input('form_title_controller');  
            }
            if($request->input('submit_btn') != '') {
              $currentSettings['form_submit_button'] = $request->input('submit_btn');  
            }
            if($request->input('form_lable_customer_name_controller') != '') {
              $currentSettings['lable_customer_name'] = $request->input('form_lable_customer_name_controller');  
            }
            if($request->input('form_placeholder_customer_name_controller') != '') {
              $currentSettings['input_placeholder_customer_name'] = $request->input('form_placeholder_customer_name_controller');  
            }
            $currentSettings['customer_name_required'] = $request->has('form_required_customer_name_controller') ? 'true' : 'false';
            if($request->input('form_lable_customer_phone_controller') != '') {
              $currentSettings['lable_customer_phone'] = $request->input('form_lable_customer_phone_controller');  
            }
            if($request->input('form_placeholder_customer_phone_controller') != '') {
              $currentSettings['input_placeholder_customer_phone'] = $request->input('form_placeholder_customer_phone_controller');
            }
            if($request->input('form_lable_customer_address_controller') != '') {
              $currentSettings['lable_customer_address'] = $request->input('form_lable_customer_address_controller');
            }
            if($request->input('form_placeholder_customer_address_controller') != '') {
              $currentSettings['input_placeholder_customer_address'] = $request->input('form_placeholder_customer_address_controller');
            }
            $currentSettings['customer_address_required'] = $request->has('form_required_customer_address_controller') ? 'true' : 'false';

            // Handle address field activation
            $currentSettings['customer_address_visible'] = $request->has('form_required_customer_address_status_controller') ? 'true' : 'false';

            if($request->input('form_lable_customer_notes_controller') != '') {
              $currentSettings['lable_customer_notes'] = $request->input('form_lable_customer_notes_controller');
            }
            if($request->input('form_placeholder_customer_notes_controller') != '') {
              $currentSettings['input_placeholder_customer_notes'] = $request->input('form_placeholder_customer_notes_controller');
            }
            $currentSettings['customer_notes_required'] = $request->has('form_required_customer_notes_controller') ? 'true' : 'false';

            // Handle notes field activation
            $currentSettings['customer_notes_visible'] = $request->has('form_required_customer_notes_status_controller') ? 'true' : 'false';

            if($request->input('form_product_coupon_code_controller') != '') {
              $currentSettings['lable_product_coupon_code'] = $request->input('form_product_coupon_code_controller');
            }
            if($request->input('form_placeholder_coupon_code_controller') != '') {
              $currentSettings['input_placeholder_product_coupon_code'] = $request->input('form_placeholder_coupon_code_controller');
            }

            // Save the updated settings back to the database
            $setting->value = json_encode($currentSettings);
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الإعدادات بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الإعدادات: '.$e->getMessage(),
            ], 500);
        }
    }
}
