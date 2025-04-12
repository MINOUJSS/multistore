<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SupplierProducts;
use App\Models\SupplierAttribute;
use App\Models\UserStoreCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SupplierProductImages;
use Illuminate\Support\Facades\Storage;
use App\Models\SupplierProductDiscounts;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SupplierProductAttributes;
use App\Models\SupplierProductVariations;
use Illuminate\Support\Facades\Validator;

class SupplierProductController extends Controller
{
    //
    public function index()
    {
        // dd(get_supplier_data(auth()->user()->tenant_id)->id);
        $store_categories=UserStoreCategory::where('user_id',auth()->user()->id)->get();
        $categories_ids=[];
        foreach($store_categories as $category)
        {
            $categories_ids[]=$category->category_id;
        }
        //get categories data in array
        foreach($categories_ids as $id)
        {
            $categories[]=Category::find($id);
        }
        $products=SupplierProducts::orderBy('id', 'desc')->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->paginate(10);
        return view('users.suppliers.products.index', compact('products', 'categories'));
    }
    //create
    public function create(Request $request)
    {
            // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'add_product_name' => 'required|string|min:3',
            'add_product_category' => 'required|integer',
            'add_product_cost' => 'required|numeric|min:0',
            'add_product_price' => 'required|numeric|min:0',
            'add_product_qty' => 'required|integer|min:1',
            'add_product_min_qty' => 'required|integer|min:1',
            'add_product_short_description' => 'required|string',
            'add_product_description' => 'required|string',
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'add_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'add_product_sku.*' => 'required|string|min:3',
            'add_product_color.*' => 'required|string',
            'add_product_size.*' => 'required|string',
            'add_product_weight.*' => 'required|string',
            'add_product_variation_add_price.*' => 'required|numeric|min:0',
            'add_product_variation_stock.*' => 'required|integer|min:0',
            'add_discount_amount' => 'nullable|numeric|min:0',
            'add_discount_percentage' => 'nullable|numeric|min:0|max:100',
            'add_discount_start_date' => 'nullable|date',
            'add_discount_end_date' => 'nullable|date|after_or_equal:add_discount_start_date',
            'add_attribute_value.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction(); // بدء المعاملة لضمان سلامة الإدخالات

        try {
            // إنشاء المنتج
            $product = new SupplierProducts();
            $product->supplier_id = get_supplier_data(auth()->user()->tenant_id)->id;
            $product->category_id = $request->add_product_category;
            $product->name = $request->add_product_name;
            $product->slug = get_supplier_store_name(auth()->user()->tenant_id) . '-' . product_name_to_slug($request->add_product_name);
            $product->short_description = $request->add_product_short_description;
            $product->description = $request->add_product_description;
            $product->price = $request->add_product_price;
            $product->cost = $request->add_product_cost;
            $product->qty = $request->add_product_qty;
            $product->minimum_order_qty = $request->add_product_min_qty;
            $product->condition = $request->add_product_condition;
            $product->free_shipping = $request->has('add_free_shipping') ? 'yes' : 'no';
            $product->status = $request->has('add_status') ? 'active' : 'inactive';
            $product->save();

            // رفع الصورة الأساسية
            if ($request->hasFile('add_image')) {
                $path = $request->file('add_image')->store("supplier/" . get_supplier_store_name(auth()->user()->tenant_id) . "/images/products/{$product->id}", 'public');
                $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path);
                $product->image = $url;
                $product->save();
            }

            // رفع الصور الإضافية
            if ($request->hasFile('add_images')) {
                $imagesData = [];
                foreach ($request->file('add_images') as $image) {
                    $path = $image->store("supplier/" . get_supplier_store_name(auth()->user()->tenant_id) . "/images/products/{$product->id}", 'public');
                    $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path);
                    $imagesData[] = [
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                SupplierProductImages::insert($imagesData);
            }

            // إضافة السمات (Attributes)
            if ($request->has('add_attribute_value')) {
                $attributesData = [];
                foreach ($request->add_attribute_value as $index => $attribute) {
                    $attributesData[] = [
                        'product_id' => $product->id,
                        'attribute_id' => $request->add_porduct_attribute[$index] ?? null,
                        'value' => $attribute,
                        'additional_price' => $request->add_atrribute_add_price[$index] ?? 0,
                        'stock_quantity' => $request->add_attribute_stock_qty[$index] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                SupplierProductAttributes::insert($attributesData);
            }

            // إضافة المتغيرات (Variations)
            if ($request->has('add_product_color')) {
                $variationsData = [];
                foreach ($request->add_product_color as $index => $color) {
                    $variationsData[] = [
                        'product_id' => $product->id,
                        'sku' => $request->add_product_sku[$index],
                        'color' => $color,
                        'size' => $request->add_product_size[$index],
                        'weight' => $request->add_product_weight[$index],
                        'additional_price' => $request->add_product_variation_add_price[$index],
                        'stock_quantity' => $request->add_product_variation_stock[$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                SupplierProductVariations::insert($variationsData);
            }

            // إضافة الخصومات (Discounts)
            if ($request->filled('add_discount_amount') && $request->filled('add_discount_start_date') && $request->filled('add_discount_end_date')) {
                SupplierProductDiscounts::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'discount_amount' => $request->add_discount_amount,
                        'discount_percentage' => $request->add_discount_percentage,
                        'start_date' => $request->add_discount_start_date,
                        'end_date' => $request->add_discount_end_date,
                        'status' => $request->has('add_discount_status') ? 'active' : 'inactive',
                    ]
                );
            }

            DB::commit(); // حفظ جميع العمليات

            return response()->json([
                'status' => 'success',
                'message' => 'تمت إضافة المنتج بنجاح',
                'product_id' => $product->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // التراجع عن جميع العمليات في حالة حدوث خطأ
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء حفظ المنتج',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }
    //edit
    public function edit($product_id)
    {
        $product=SupplierProducts::find($product_id);
        $product_images=SupplierProductImages::where('product_id',$product_id)->get();
        $product_variations=SupplierProductVariations::where('product_id',$product_id)->get();
        $product_discount=SupplierProductDiscounts::where('product_id',$product_id)->first();
        $product_attributes=SupplierProductAttributes::where('product_id',$product_id)->get();
        $supplier_attributes=SupplierAttribute::all();
        return response()->json([
            'status' => '200',
            'product' => $product,
            'product_images'=>$product_images,
            'product_variations'=>$product_variations,
            'product_discount' =>$product_discount,
            'product_attributes'=>$product_attributes,
            'supplier_attributes'=>$supplier_attributes,
        ]);
    } 
    //
    public function update(Request $request,$product_id)
    {
            // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|min:3',
            'product_category' => 'required|integer',
            'product_cost' => 'required|numeric|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_qty' => 'required|integer|min:1',
            'product_min_qty' => 'required|integer|min:1',
            'product_short_description' => 'required|string',
            'product_description' => 'required|string',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction(); // بدء المعاملة لضمان سلامة الإدخالات

        try {
            $product = SupplierProducts::findOrFail($product_id);
            $product->category_id = $request->product_category;
            $product->name = $request->product_name;
            $product->slug = get_supplier_store_name(auth()->user()->tenant_id) . '-' . product_name_to_slug($request->product_name);
            $product->short_description = $request->product_short_description;
            $product->description = $request->product_description;
            $product->price = $request->product_price;
            $product->cost = $request->product_cost;
            $product->qty = $request->product_qty;
            $product->minimum_order_qty = $request->product_min_qty;
            $product->status = $request->has('status') ? 'active' : 'inactive';

            // رفع الصورة إلى نطاق المستأجر
            if ($request->hasFile('image')) {
                //delete old image
                $url=explode('storage/tenantsupplier/app/public/',$product->image);
                if(count($url)>=2)
                {
                $imagePath=$url[1];
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                    }
                }
                
                $path = $request->file('image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // التخزين في قرص المستأجر
                $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
                $product->image=$url;
            }
            
            //رفع الصور
            $imageUrls = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // حفظ الصور في storage/app/public/uploads/products
                    $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
                    $imageUrls[] = $url;
                    // insert into product images table
                    $p_image= new SupplierProductImages();
                    $p_image->product_id = $product_id;
                    $p_image->image_path =$url;
                    $p_image->save();
                }
            }

            // تحديث أو إضافة الخصومات (Discounts)
            if ($request->filled('discount_amount') && $request->filled('discount_start_date') && $request->filled('discount_end_date')) {
                SupplierProductDiscounts::updateOrCreate(
                    ['product_id' => $product_id],
                    [
                        'discount_amount' => $request->discount_amount,
                        'discount_percentage' => $request->discount_percentage,
                        'start_date' => $request->discount_start_date,
                        'end_date' => $request->discount_end_date,
                        'status' => $request->has('discount_status') ? 'active' : 'inactive',
                    ]
                );
            }

            $product->save();
            DB::commit(); // حفظ جميع العمليات

            return response()->json([
                'status' => 'success',
                'message' => 'تم تحديث المنتج بنجاح',
                'product_id' => $product->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // التراجع عن جميع العمليات في حالة حدوث خطأ
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء تحديث المنتج',
                'error' => $e->getMessage(),
            ], 500);
        }
        // //validation
        // $validator = Validator::make($request->all(),[
        //     'product_name' => 'required',
        //     'product_category' => 'required',
        //     'product_cost' => 'required',
        //     'product_price' => 'required',
        //     'product_qty' => 'required',
        //     'product_min_qty' => 'required',
        //     'product_short_description' => 'required',
        //     'product_description' =>'required',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من كل صورة
        //     'product_sku.*' => 'required|string|min:3',
        //     'product_color.*' => 'required|string',
        //     'product_size.*' => 'required|string',
        //     'product_weight.*' => 'required|string',
        //     'product_variation_add_price.*' => 'required|numeric',
        //     'product_variation_stock.*' => 'required|integer',
        //     'discount_amount.*' => 'required|numeric',
        //     'discount_percentage.*' => 'required|numeric',
        //     'discount_start_date.*' => 'required|date',
        //     'discount_end_date.*' => 'required|date',
        //     'attribute_value.*' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }
        // // return response()->json([
        // //     'status' => 'success',
        // //     'result' => $request->all(),
        // // ]);
        // // Process the form data (e.g., save to database)
        // $product=SupplierProducts::findOrFail($product_id);
        // $product->category_id=$request->product_category;
        // $product->name=$request->product_name;
        // $product->slug=get_supplier_store_name(auth()->user()->tenant_id).'-'.product_name_to_slug($request->product_name);
        // $product->short_description=$request->product_short_description;
        // $product->description=$request->product_description;
        // $product->price=$request->product_price;
        // $product->cost=$request->product_cost;
        // // رفع الصورة إلى نطاق المستأجر
        // if ($request->hasFile('image')) {
        //     //delete old image
        //     $url=explode('storage/tenantsupplier/app/public/',$product->image);
        // //    $url='supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product->image;
        //     // $imagePath = 'supplier/saoura/images/products/hoh4eNMGslsmw06zhmGCyy7QmZdolz02oUtcaeMO.png'; // Relative to storage/app/public
        //     if(count($url)>=2)
        //     {
        //      $imagePath=$url[1];
        //      if (Storage::disk('public')->exists($imagePath)) {
        //         Storage::disk('public')->delete($imagePath);
        //         }
        //     }
        //     // $imagePath=$url[1];
        //     // $imagePath=$url;
            
        //     $path = $request->file('image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // التخزين في قرص المستأجر
        //     $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
        //     $product->image=$url;
        // }
        // //رفع الصور
        
        // $imageUrls = [];
        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $path = $image->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // حفظ الصور في storage/app/public/uploads/products
        //         $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
        //         $imageUrls[] = $url;
        //         // insert into product images table
        //         $p_image= new SupplierProductImages();
        //         $p_image->product_id = $product_id;
        //         $p_image->image_path =$url;
        //         $p_image->save();
        //     }
        // }

        // $product->qty=$request->product_qty;
        // $product->minimum_order_qty=$request->product_min_qty;
        // $product->condition=$request->product_condition;
        // if($request->free_shipping != null && $request->free_shipping=="on")
        // {
        // $product->free_shipping='yes';
        // }else
        // {
        //     $product->free_shipping='no';
        // }
        // if($request->status != null && $request->status=="on")
        // {
        // $product->status='active';
        // }else
        // {
        //     $product->status='inactive';
        // }
        // //update product attribute
        // if($request->update_attribute_id !=null)
        // {
        //     foreach($request->update_attribute_id as $index =>$attribute)
        //     {
              
        //         $product_atrribute=SupplierProductAttributes::find($request->update_attribute_id[$index]);
        //         $product_atrribute->attribute_id=$request->update_product_attribute[$index];
        //         $product_atrribute->value=$request->update_attribute_value[$index];
        //         $product_atrribute->additional_price=$request->update_attribute_add_price[$index];
        //         $product_atrribute->stock_quantity=$request->update_attribute_stock_qty[$index];
        //         $product_atrribute->update();
        //     }  
        // }
        // // add product attribute
        // if($request->attribute_value !=null)
        // {
        //     foreach($request->attribute_value as $index =>$attribute)
        //     {
        //         $product_atrribute=new SupplierProductAttributes;
        //         $product_atrribute->product_id=$request->product_id;                ;
        //         $product_atrribute->attribute_id=$request->porduct_attribute[$index];
        //         $product_atrribute->value=$request->attribute_value[$index];
        //         $product_atrribute->additional_price=$request->atrribute_add_price[$index];
        //         $product_atrribute->stock_quantity=$request->attribute_stock_qty[$index];
        //         $product_atrribute->save();
        //     }
        // }
        // //update product variation information
        // if($request->update_product_color != null)
        // {
        //     foreach($request->update_product_color as $index =>$color)
        //     {
        //         $product_variation=SupplierProductVariations::find($request->update_varition_id[$index]);
        //         $product_variation->sku=$request->update_product_sku[$index];
        //         $product_variation->color=$request->update_product_color[$index];
        //         $product_variation->size=$request->update_product_size[$index];
        //         $product_variation->weight=$request->update_product_weight[$index];
        //         $product_variation->additional_price=$request->update_product_variation_add_price[$index];
        //         $product_variation->stock_quantity=$request->update_product_variation_stock[$index];
        //         $product_variation->update();
        //     } 
        // }
        // //add product variation information
        // if($request->product_color != null)
        // {
        //     foreach($request->product_color as $index =>$color)
        //     {
        //         $product_variation=new SupplierProductVariations;
        //         $product_variation->product_id=$request->product_id[$index];
        //         $product_variation->sku=$request->product_sku[$index];
        //         $product_variation->color=$request->product_color[$index];
        //         $product_variation->size=$request->product_size[$index];
        //         $product_variation->weight=$request->product_weight[$index];
        //         $product_variation->additional_price=$request->product_variation_add_price[$index];
        //         $product_variation->stock_quantity=$request->product_variation_stock[$index];
        //         $product_variation->save();
        //     }
        // }
        // // add product discounts information
        // if($request->discount_amount !=null)
        // {
        //     if($request->discount_status=="on")
        //     {
        //         $status="active";
        //     }else
        //     {
        //         $status="inactive";
        //     }
        //     $discount=SupplierProductDiscounts::updateOrCreate(
        //         ['product_id' => $request->product_id],
        //         [
        //           'discount_amount' => $request->discount_amount,
        //           'discount_percentage' => $request->discount_percentage,
        //           'start_date' => $request->discount_start_date,
        //           'end_date' => $request->discount_end_date,
        //           'status' => $status,
        //         ]
        //     );
        // }
        // $product->update();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Form submitted successfully!',
        //     'result'=>$request->all(),
        // ]);
        
    }
    //delete product
    function delete($id)
    {
        //get product folder
        $product=SupplierProducts::findOrfail($id);
        //delete product images folder
        $store_name=get_supplier_store_name(get_tenant_id_from_supplier($product->supplier_id));
        $folderPath='/supplier/'.$store_name.'/images/products/'.$product->id;
        if(Storage::disk('public')->exists($folderPath))
        {
            Storage::disk('public')->deleteDirectory($folderPath); // حذف المجلد بالكامل
        }
        //delete product frome database
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => "تم حذف مجلد المنتج $id بنجاح"
        ]);
    }
    //function delete_product_image()
    function delete_product_image($id)
    {
        //get image from database
        $image=SupplierProductImages::find($id);
        $product_id=$image->product_id;
        if($image!=null){
        //delete image from supplier images folder
        $url=explode('storage/tenantsupplier/app/public/',$image->image_path);
        $imagePath=$url[1];
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $image->delete();
        $product_images=SupplierProductImages::where('product_id',$product_id)->get();
            return response()->json([
                'status' => 'success',
                'product_images' =>$product_images,
            ]);
        }else
        {
           return response()->json([
            'status' => 'error',
            'message' => 'image not found',
           ],400);
        }
    }

    //function delete_product_variation
    function delete_product_variation($id)
    {
        $product_variation=SupplierProductVariations::findOrfail($id);
        $product_id=$product_variation->product_id;
        $product_variation->delete();
        $product_variations=SupplierProductVariations::where('product_id',$product_id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'variation deleted successfully',
            'product_variations' =>$product_variations,
        ]);
    }
    //function delete_product_discount
    function delete_product_discount($id)
    {
        $product_discount=SupplierProductDiscounts::findOrfail($id);
        $product_discount->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'discount deleted successfully',
        ]);
    }
    //function delete_product_attribute
    function delete_product_attribute($id)
    {
        $product_attribute=SupplierProductAttributes::findOrfail($id);
        $product_attribute->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'attribute deleted successfully',
        ]);
    }

    ///filter products
    public function filterProducts(Request $request)
    {
        $query = SupplierProducts::query();

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->get();

        return view('users.suppliers.components.content.products.partials.product_table', compact('products'))->render();
    }


}
