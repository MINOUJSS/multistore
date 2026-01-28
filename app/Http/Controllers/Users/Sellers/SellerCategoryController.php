<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserStoreCategory;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellerCategoryController extends Controller
{
    public function index()
    {
        $slug = tenant_to_slug(auth()->user()->tenant_id);
        $globalCategories = Category::where('slug', 'like', $slug.'-%')->get();
        $storeCategories = UserStoreCategory::where('user_id', auth()->user()->id)->get();
        // get categories status
        $categories_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_categories_visibility')->first();

        return view('users.sellers.pages.sections.categories.index', compact('globalCategories', 'storeCategories', 'categories_status'));
    }

    // Global Categories Methods
    public function getGlobalCategories()
    {
        $categories = Category::with('parent')->get();

        return response()->json($categories);
    }

    public function storeGlobalCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $slug = tenant_to_slug(auth()->user()->tenant_id).'-'.paragraph_to_slug($request->name);
        // $category = Category::create($request->all());
        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['message' => 'تم إضافة القسم بنجاح', 'category' => $category]);
    }

    // Store Categories Methods
    public function getStoreCategories()
    {
        $categories = UserStoreCategory::with('category')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($categories);
    }

    public function storeStoreCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('image');
        $data['user_id'] = auth()->id();

        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('store-categories', 'public');
        //     $data['image'] = Storage::url($path);
        // }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/categories', 'public');
            $data['image'] = Storage::disk('public')->url('tenantseller/app/public/'.$path);
        }

        $storeCategory = UserStoreCategory::create($data);

        return response()->json(['message' => 'تم إضافة قسم المتجر بنجاح', 'category' => $storeCategory]);
    }

    // Common methods for both
    // global edit
    public function globaledit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return response()->json($category);
    }

    // store edit
    public function storeedit($id)
    {
        $category = UserStoreCategory::findOrFail($id);

        return response()->json($category);
    }
    // public function edit($type, $id)
    // {
    //     if ($type === 'global') {
    //         $category = Category::where('slug', $id)->firstOrFail(); // Category::findOrFail($id);
    //     } else {
    //         $category = UserStoreCategory::where('user_id', auth()->user()->id())
    //             ->findOrFail($id);
    //     }

    //     return response()->json($category);
    // }

    // global update
    public function globalupdate(Request $request, $id)
    {
        $category = Category::findOrFail($id); // Category::where('slug', $id)->firstOrFail();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $category->update($request->all());

        return response()->json(['message' => 'تم تحديث القسم بنجاح', 'category' => $category]);
    }

    // store update
    public function storeupdate(Request $request, $id)
    {
        $category = UserStoreCategory::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        //     if ($request->hasFile('image')) {
        //         // Delete old image if exists
        //         if ($category->image) {
        //             Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
        //         }
        //         $path = $request->file('image')->store('store-categories', 'public');
        //         $data['image'] = Storage::url($path);
        //     }
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            // Delete associated image
            if ($category->image) {
                $fullPath = 'seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/categories/'.basename($category->image);

                if (Storage::disk('public')->exists($fullPath)) {
                    Storage::disk('public')->delete($fullPath);
                }
            }
            $path = $request->file('image')->store('seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/categories', 'public');
            $data['image'] = Storage::disk('public')->url('tenantseller/app/public/'.$path);
            // if ($data['image']) {
            //     $category->update($data);
            // }
        }
        $category->update($data);

        return response()->json(['message' => 'تم تحديث قسم المتجر بنجاح', 'category' => $category]);
    }
    // public function update(Request $request, $type, $id)
    // {
    //     if ($type === 'global') {
    //         $category =Category::where('slug', $id)->firstOrFail(); //Category::findOrFail($id);
    //         $validator = Validator::make($request->all(), [
    //             'name' => 'required|string|max:255',
    //             'slug' => 'required|string|unique:categories,slug,'.$id,
    //             'description' => 'nullable|string',
    //             'parent_id' => 'nullable|exists:categories,id'
    //         ]);
    //     } else {
    //         $category = UserStoreCategory::where('user_id', auth()->user()->id())
    //             ->findOrFail($id);
    //         $validator = Validator::make($request->all(), [
    //             'category_id' => 'required|exists:categories,id',
    //             'image' => 'nullable|image|max:2048',
    //             'icon' => 'nullable|string|max:50',
    //             'order' => 'nullable|integer'
    //         ]);
    //     }

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->except('image');

    //     if ($request->hasFile('image')) {
    //         // Delete old image if exists
    //         if ($category->image) {
    //             Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
    //         }
    //         $path = $request->file('image')->store('store-categories', 'public');
    //         $data['image'] = Storage::url($path);
    //     }

    //     $category->update($data);
    //     return response()->json(['message' => 'تم التحديث بنجاح']);
    // }

    // global category delete
    public function globaldestroy($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail(); // Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'تم الحذف بنجاح']);
    }

    // store category delete
    public function storedestroy($id)
    {
        $category = UserStoreCategory::findOrFail($id);
        // Delete associated image
        if ($category->image) {
            $fullPath = 'seller/'.get_seller_store_name(auth()->user()->tenant_id).'/images/categories/'.basename($category->image);

            if (Storage::disk('public')->exists($fullPath)) {
                Storage::disk('public')->delete($fullPath);
            }
        }
        $category->delete();

        return response()->json(['message' => 'تم الحذف بنجاح']);
    }

    // public function destroy($type, $id)
    // {
    //     if ($type === 'global') {
    //         $category = Category::where('slug', $id)->firstOrFail(); //Category::findOrFail($id);
    //         $category->delete();
    //     } else {
    //         $category = UserStoreCategory::where('user_id', auth()->user()->id())
    //             ->findOrFail($id);
    //         if ($category->image) {
    //             Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
    //         }
    //         $category->delete();
    //     }
    //     return response()->json(['message' => 'تم الحذف بنجاح']);
    // }

    // updateStatus
    public function updateStatus(Request $request)
    {
        $categories_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_categories_visibility')->first();
        if ($request->categories_status == 'on') {
            $categories_status->value = 'true';
        } else {
            $categories_status->value = 'false';
        }
        $categories_status->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم تحديث حالة السلايدر بنجاح',
        // ]);
        return redirect()->back()->with('success', 'تم تحديث حالة الأقسام بنجاح');
    }
}
