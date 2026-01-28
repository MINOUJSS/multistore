<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\UserSlider;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellerSliderController extends Controller
{
    public function index()
    {
        // get seller silders
        $sliders = UserSlider::where('user_id', auth()->user()->id)->orderBy('order', 'asc')->get();
        // get slider status
        $slider_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_slider_visibility')->first();

        return view('users.sellers.pages.sections.slider.index', compact('sliders', 'slider_status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'title.required' => 'حقل العنوان مطلوب',
            'image.required' => 'حقل الصورة مطلوب',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif',
            'image.max' => 'يجب ألا تتجاوز الصورة 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store(
                    'seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/sliders',
                    'public'
                );
                $url = Storage::disk('public')->url('tenantseller/app/public/'.$path);
                $imagePath = $url;
            }
            $link = null;
            $request->link == '' ? $link = null : $link = $request->link;
            $slider = UserSlider::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'link' => $link,
                'order' => $request->order ?? 0,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة السلايدر بنجاح',
                'data' => $slider,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: '.$e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $slider = UserSlider::findOrFail($id);

        return response()->json($slider);
    }

    public function update(Request $request, $id)
    {
        $slider = UserSlider::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $link = null;
            $request->link == '' ? $link = null : $link = $request->link;
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'link' => $link,
                'order' => $request->order ?? 0,
                'status' => $request->status,
            ];

            // Handle image update if new image is provided
            if ($request->hasFile('image')) {
                // get old image name in storage
                $oldImageName = explode('seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/sliders/', $slider->image)[1];
                // Delete old image if exists from storage
                if ($slider->image && Storage::disk('seller')->exists(get_seller_store_name(auth()->user()->tenant_id).'/images/sliders/'.$oldImageName)) {
                    Storage::disk('seller')->delete(get_seller_store_name(auth()->user()->tenant_id).'/images/sliders/'.$oldImageName);
                }

                // Store new image
                $path = $request->file('image')->store(
                    'seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/sliders',
                    'public'
                );

                // Generate full URL
                $url = Storage::disk('public')->url('tenantseller/app/public/'.$path);
                $data['image'] = $url;
            }

            $slider->update($data);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث السلايدر بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $slider = UserSlider::findOrFail($id);

        try {
            // Delete associated image
            if ($slider->image) {
                $fullPath = 'seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/sliders/'.basename($slider->image);

                if (Storage::disk('public')->exists($fullPath)) {
                    Storage::disk('public')->delete($fullPath);
                }
            }

            $slider->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف السلايدر بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحذف: '.$e->getMessage(),
            ], 500);
        }
    }

    // updateStatus
    public function updateStatus(Request $request)
    {
        $slider_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_slider_visibility')->first();
        if ($request->slider_status == 'on') {
            $slider_status->value = 'true';
        } else {
            $slider_status->value = 'false';
        }
        $slider_status->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم تحديث حالة السلايدر بنجاح',
        // ]);
        return redirect()->back()->with('success', 'تم تحديث حالة السلايدر بنجاح');
    }
}
