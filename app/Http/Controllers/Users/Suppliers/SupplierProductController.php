<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Supplier\SupplierAttribute;
use App\Models\Supplier\SupplierProductAttributes;
use App\Models\Supplier\SupplierProductDiscounts;
use App\Models\Supplier\SupplierProductImages;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierProductsReviews;
use App\Models\Supplier\SupplierProductVariations;
use App\Models\Supplier\SupplierProductVideos;
use App\Models\UserStoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupplierProductController extends Controller
{
    public function index()
    {
        // dd(get_supplier_data(auth()->user()->tenant_id)->id);
        $store_categories = UserStoreCategory::where('user_id', auth()->user()->id)->get();
        $categories_ids = [];
        foreach ($store_categories as $category) {
            $categories_ids[] = $category->category_id;
        }
        // get categories data in array
        $categories = [];
        foreach ($categories_ids as $id) {
            $categories[] = Category::find($id);
        }
        $products = SupplierProducts::orderBy('id', 'desc')->where('supplier_id', get_supplier_data(auth()->user()->tenant_id)->id)->paginate(10);

        return view('users.suppliers.products.index', compact('products', 'categories'));
    }

    // create
    public function create(Request $request)
    {
        // التحقق من حق المورد في إضافة منتج جديد
        $plan = get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan == 1) {
            $products = SupplierProducts::where('supplier_id', get_supplier_data(auth()->user()->tenant_id)->id)->count();
            if ($products >= 12) {
                return response()->json([
                    'status' => 'max_products_limit',
                    'title' => 'الحد الأقصى لإضافة المنتجات',
                    'message' => 'لا يمكنك اضافة اكثر من 12 منتجات',
                ]);
            }
        } elseif ($plan == 2) {
            $products = SupplierProducts::where('supplier_id', get_supplier_data(auth()->user()->tenant_id)->id)->count();
            if ($products >= 100) {
                return response()->json([
                    'status' => 'max_products_limit',
                    'title' => 'الحد الأقصى لإضافة المنتجات',
                    'message' => 'لا يمكنك اضافة اكثر من 100 منتجات',
                ]);
            }
        }
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'add_product_name' => 'required|string|min:3',
            'add_product_category' => 'nullable',
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
            // ✅ التحقق من الفيديوهات
            'video_url' => 'nullable|array',
            'video_url.*' => [
                'nullable',
                'string',
                // ✅ regex للتحقق من روابط YouTube أو Vimeo
                'regex:/^(https?:\/\/)?(www\.)?((youtube\.com\/watch\?v=|youtu\.be\/)[\w-]{11}|vimeo\.com\/[0-9]+)$/',
            ],
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
            if ($request->add_product_category != 'null') {
                $product->category_id = $request->add_product_category;
            }
            $product->name = $request->add_product_name;
            $product->slug = get_supplier_store_name(auth()->user()->tenant_id).'-'.product_name_to_slug($request->add_product_name);
            $product->short_description = $request->add_product_short_description;
            $product->description = $request->add_product_description;
            $product->price = $request->add_product_price;
            $product->cost = $request->add_product_cost;
            $product->qty = $request->add_product_qty;
            $product->minimum_order_qty = $request->add_product_min_qty;
            $product->condition = $request->add_product_condition;
            $product->free_shipping = $request->has('add_free_shipping') ? 'yes' : 'no';
            $product->status = $request->has('add_status') ? 'active' : 'inactive';
            // $product->save();

            // رفع الصورة الأساسية
            if ($request->hasFile('add_image')) {
                $path = $request->file('add_image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id)."/images/products/{$product->id}", 'public');
                $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path);
                $product->image = $url;
                $product->save();
            }

            // رفع الصور الإضافية
            if ($request->hasFile('add_images')) {
                $imagesData = [];
                foreach ($request->file('add_images') as $image) {
                    $path = $image->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id)."/images/products/{$product->id}", 'public');
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

            // تقييم المنتج
            SupplierProductsReviews::create([
                'product_id' => $product->id,
                'rating' => $request->add_product_review,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
                        // 'size' => $request->add_product_size[$index],
                        // 'weight' => $request->add_product_weight[$index],
                        // 'additional_price' => $request->add_product_variation_add_price[$index],
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

            // ✅ حفظ فيديوهات المنتج
            if ($request->has('videos')) {
                $videos = $request->videos;

                // عدد الفيديوهات المرسلة
                $count = count($videos['title'] ?? []);

                for ($i = 0; $i < $count; ++$i) {
                    $type = $videos['type'][$i] ?? 'youtube';
                    $title = $videos['title'][$i] ?? null;
                    $youtubeUrl = $videos['youtube_url'][$i] ?? null;
                    $description = $videos['description'][$i] ?? null;
                    $isActive = isset($videos['is_active'][$i]) ? 1 : 0;

                    $filePath = null;
                    $youtubeId = null;

                    // 🔹 إذا كان الفيديو من YouTube
                    if ($type === 'youtube' && !empty($youtubeUrl)) {
                        preg_match('/(youtu\.be\/|v=)([^&]+)/', $youtubeUrl, $matches);
                        $youtubeId = $matches[2] ?? null;
                    }

                    // 🔹 إذا كان الفيديو من vimeo
                    if ($type === 'vimeo' && !empty($youtubeUrl)) {
                        if (!function_exists('get_vimeo_id')) {
                            function get_vimeo_id(string $url): ?string
                            {
                                // Match both "vimeo.com/123456789" and "player.vimeo.com/video/123456789"
                                preg_match('/(?:vimeo\.com\/(?:video\/)?)([0-9]+)/', $youtubeUrl, $matches);

                                return $matches[1] ?? null;
                            }
                        }

                        $youtubeId = get_vimeo_id($youtubeUrl);
                    }

                    // 🔹 إذا كان الفيديو مرفوعًا محليًا
                    if ($type === 'local' && isset($videos['file'][$i]) && $videos['file'][$i] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $videos['file'][$i];
                        if ($file->isValid()) {
                            $path = $file->store(get_supplier_store_name(auth()->user()->tenant_id)."/videos/products/{$product->id}", 'supplier');
                            $filePath = Storage::disk('supplier')->url('tenantsupplier/app/public/supplier/'.$path);
                        }
                    }

                    // ✅ حفظ السجل في قاعدة البيانات
                    $product->videos()->create([
                        'title' => $title,
                        'type' => $type,
                        'youtube_url' => $youtubeUrl,
                        'youtube_id' => $youtubeId,
                        'file_path' => $filePath,
                        'file_disk' => 'supplier',
                        'description' => $description,
                        'is_active' => $isActive,
                        'sort_order' => $i,
                    ]);
                }
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

    // edit
    public function edit($product_id)
    {
        $product = SupplierProducts::find($product_id);
        $product_images = SupplierProductImages::where('product_id', $product_id)->get();
        $product_variations = SupplierProductVariations::where('product_id', $product_id)->get();
        $product_discount = SupplierProductDiscounts::where('product_id', $product_id)->first();
        $product_attributes = SupplierProductAttributes::where('product_id', $product_id)->get();
        $product_review = SupplierProductsReviews::where('product_id', $product_id)->first();
        $supplier_attributes = SupplierAttribute::all();

        return response()->json([
            'status' => '200',
            'product' => $product,
            'product_images' => $product_images,
            'product_variations' => $product_variations,
            'product_discount' => $product_discount,
            'product_attributes' => $product_attributes,
            'supplier_attributes' => $supplier_attributes,
            'product_review' => $product_review,
            'product_videos' => $product->videos,
        ]);
    }

    public function update(Request $request, $product_id)
    {
        // return response()->json([
        //     'status' => '200',
        //     'product_id' => $product_id,
        //     'request' => $request->all(),
        // ]);
        // if (!function_exists('getYoutubeVideoId')) {

        // }

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

        // return response()->json([
        //     'status' => 'error',
        //     'errors' => $request->all(),
        // ]);

        try {
            $product = SupplierProducts::findOrFail($product_id);
            if ($request->add_product_category != 'null') {
                $product->category_id = $request->product_category;
            } else {
                $product->category_id = null;
            }
            $product->name = $request->product_name;
            $product->slug = get_supplier_store_name(auth()->user()->tenant_id).'-'.product_name_to_slug($request->product_name);
            $product->short_description = $request->product_short_description;
            $product->description = $request->product_description;
            $product->price = $request->product_price;
            $product->cost = $request->product_cost;
            $product->qty = $request->product_qty;
            $product->minimum_order_qty = $request->product_min_qty;
            $product->condition = $request->product_condition;
            $product->free_shipping = $request->has('free_shipping') ? 'yes' : 'no';
            $product->status = $request->has('status') ? 'active' : 'inactive';

            // رفع الصورة إلى نطاق المستأجر
            if ($request->hasFile('image')) {
                // delete old image
                $url = explode('storage/tenantsupplier/app/public/', $product->image);
                if (count($url) >= 2) {
                    $imagePath = $url[1];
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }

                $path = $request->file('image')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // التخزين في قرص المستأجر
                $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
                $product->image = $url;
            }

            // رفع الصور
            $imageUrls = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/images/products/'.$product_id, 'public'); // حفظ الصور في storage/app/public/uploads/products
                    $url = Storage::disk('public')->url('tenantsupplier/app/public/'.$path); // رابط الصورة
                    $imageUrls[] = $url;
                    // insert into product images table
                    $p_image = new SupplierProductImages();
                    $p_image->product_id = $product_id;
                    $p_image->image_path = $url;
                    $p_image->save();
                }
            }

            // تقييم المنتج
            $product_review = SupplierProductsReviews::where('product_id', $product_id)->first();
            if ($product_review) {
                $product_review->rating = $request->product_review;
                $product_review->update();
            } else {
                // تقييم المنتج
                SupplierProductsReviews::create([
                    'product_id' => $product->id,
                    'rating' => $request->product_review,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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

            // -------------------start----------------------
            /*
|----------------------------------------------------------------------
| 1) Product Videos (تحديث / إضافة / حذف)
|----------------------------------------------------------------------
*/

            // 1️⃣ جلب IDs الفيديوهات الموجودة في الفورم (إن وُجدت)
            $existingVideoIds = $request->update_videos_id ?? [];

            // 2️⃣ حذف الفيديوهات التي تم حذفها من الفورم
            SupplierProductVideos::where('product_id', $product->id)
                ->whereNotIn('id', $existingVideoIds)
                ->delete();

            // 3️⃣ تحديث الفيديوهات الموجودة
            if ($request->has('update_videos_id')) {
                foreach ($request->update_videos_id as $i => $videoId) {
                    $video = SupplierProductVideos::find($videoId);
                    if ($video) {
                        $type = $request->update_videos['type'][$i];
                        $isActive = isset($request->update_videos['is_active'][$i]) ? 1 : 0;

                        $updateData = [
                            'title' => $request->update_videos['title'][$i],
                            'type' => $type,
                            'description' => $request->update_videos['description'][$i],
                            'is_active' => $isActive,
                        ];

                        if ($type === 'youtube' || $type === 'vimeo') {
                            $updateData['youtube_url'] = $request->update_videos['youtube_url'][$i];
                            if ($type === 'youtube') {
                                $updateData['youtube_id'] = getYoutubeVideoId($request->update_videos['youtube_url'][$i]);
                            } elseif ($type === 'vimeo') {
                                $updateData['youtube_id'] = get_vimeo_id($request->update_videos['youtube_url'][$i]);
                            }
                            $updateData['file_path'] = null;
                        } elseif ($type === 'local' && isset($request->update_videos['file'][$i])) {
                            // حذف الملف القديم إن وُجد
                            if ($video->file_path && Storage::disk($video->file_disk)->exists($video->file_path)) {
                                Storage::disk($video->file_disk)->delete($video->file_path);
                            }

                            // رفع الملف الجديد
                            // $path = $request->update_videos['file'][$i]->store('products/videos', 'supplier');
                            $path = $request->update_videos['file'][$i]->store(get_supplier_store_name(auth()->user()->tenant_id)."/videos/products/{$product->id}", 'supplier');
                            $updateData['file_path'] = Storage::disk('supplier')->url('tenantsupplier/app/public/supplier/'.$path);
                            $updateData['file_disk'] = 'supplier';
                            $updateData['youtube_url'] = null;
                            $updateData['youtube_id'] = null;
                        }

                        $video->update($updateData);
                    }
                }
            }

            // 4️⃣ إضافة فيديوهات جديدة
            if ($request->has('videos')) {
                foreach ($request->videos['type'] as $i => $type) {
                    $isActive = isset($request->videos['is_active'][$i]) ? 1 : 0;

                    $data = [
                        'product_id' => $product->id,
                        'title' => $request->videos['title'][$i],
                        'type' => $type,
                        'description' => $request->videos['description'][$i],
                        'is_active' => $isActive,
                    ];

                    if ($type === 'youtube' || $type === 'vimeo') {
                        $data['youtube_url'] = $request->videos['youtube_url'][$i];
                        if ($type === 'youtube') {
                            $data['youtube_id'] = getYoutubeVideoId($request->videos['youtube_url'][$i]);
                        } elseif ($type === 'vimeo') {
                            $data['youtube_id'] = get_vimeo_id($request->videos['youtube_url'][$i]);
                        }
                    } elseif ($type === 'local' && isset($request->videos['file'][$i])) {
                        $path = $request->videos['file'][$i]->store(get_supplier_store_name(auth()->user()->tenant_id)."/videos/products/{$product->id}", 'supplier');
                        $data['file_path'] = Storage::disk('supplier')->url('tenantsupplier/app/public/supplier/'.$path);
                        $data['file_disk'] = 'supplier';
                    }

                    SupplierProductVideos::create($data);
                }
            }

            /*
                   |--------------------------------------------------------------------------
                   | 1) Product Attributes (تحديث / إضافة / حذف)
                   |--------------------------------------------------------------------------
                   */

            // جلب IDs المرسلة من الفورم
            $existingAttrIds = $request->update_attribute_id ?? [];

            // حذف أي Attribute لم يتم إرساله (يعني المستخدم حذفه من الفورم)
            SupplierProductAttributes::where('product_id', $product->id)
                ->whereNotIn('id', $existingAttrIds)
                ->delete();

            // تحديث Attributes الموجودة
            if ($request->has('update_attribute_id')) {
                foreach ($request->update_attribute_id as $i => $attrId) {
                    $attribute = SupplierProductAttributes::find($attrId);
                    if ($attribute) {
                        $attribute->update([
                            'attribute_id' => $request->update_product_attribute[$i],
                            'value' => $request->update_attribute_value[$i],
                            'additional_price' => $request->update_attribute_add_price[$i],
                            'stock_quantity' => $request->update_attribute_stock_qty[$i],
                        ]);
                    }
                }
            }

            // إضافة Attributes جديدة
            if ($request->has('porduct_attribute')) {
                foreach ($request->porduct_attribute as $i => $attr) {
                    SupplierProductAttributes::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attr,
                        'value' => $request->attribute_value[$i],
                        'additional_price' => $request->atrribute_add_price[$i],
                        'stock_quantity' => $request->attribute_stock_qty[$i],
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 2) Product Variations (تحديث / إضافة / حذف)
            |--------------------------------------------------------------------------
            */

            // جلب IDs المرسلة من الفورم
            $existingVarIds = $request->update_varition_id ?? [];

            // حذف أي Variation لم يتم إرساله (يعني المستخدم حذفه من الفورم)
            SupplierProductVariations::where('product_id', $product->id)
                ->whereNotIn('id', $existingVarIds)
                ->delete();

            // تحديث Variations الموجودة
            if ($request->has('update_varition_id')) {
                foreach ($request->update_varition_id as $i => $varId) {
                    $variation = SupplierProductVariations::find($varId);
                    if ($variation) {
                        $variation->update([
                            'sku' => $request->update_product_sku[$i],
                            'color' => $request->update_product_color[$i],
                            'stock_quantity' => $request->update_product_variation_stock[$i],
                        ]);
                    }
                }
            }

            // إضافة Variations جديدة
            if ($request->has('product_sku')) {
                foreach ($request->product_sku as $i => $sku) {
                    // شرط احترازي: لا تسمح بـ Duplicate SKU
                    if (!SupplierProductVariations::where('sku', $sku)->where('product_id', $product->id)->exists()) {
                        SupplierProductVariations::insert([
                            'product_id' => $product->id,
                            'sku' => $sku,
                            'color' => $request->product_color[$i],
                            'stock_quantity' => $request->product_variation_stock[$i],
                        ]);
                    }
                }
            }
            // --------------------end---------------------

            // معالجة الخصومات (Discounts) - إضافة أو تحديث أو حذف
            if ($request->filled('discount_amount') && $request->filled('discount_start_date') && $request->filled('discount_end_date')) {
                SupplierProductDiscounts::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'discount_amount' => $request->discount_amount,
                        'discount_percentage' => $request->discount_percentage,
                        'start_date' => $request->discount_start_date,
                        'end_date' => $request->discount_end_date,
                        'status' => $request->has('discount_status') ? 'active' : 'inactive',
                        'updated_at' => now(),
                    ]
                );
            } else {
                // حذف الخصم إذا لم يتم تقديم بيانات الخصم
                SupplierProductDiscounts::where('product_id', $product->id)->delete();
            }
            // end test

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
    }

    // delete product
    public function delete($id)
    {
        // get product folder
        $product = SupplierProducts::findOrfail($id);
        // delete product images folder
        $store_name = get_supplier_store_name(get_tenant_id_from_supplier($product->supplier_id));
        $folderPath = '/supplier/'.$store_name.'/images/products/'.$product->id;
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath); // حذف المجلد بالكامل
        }
        // delete product frome database
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => "تم حذف مجلد المنتج $id بنجاح",
        ]);
    }

    // function delete_product_image()
    public function delete_product_image($id)
    {
        // get image from database
        $image = SupplierProductImages::find($id);
        $product_id = $image->product_id;
        if ($image != null) {
            // delete image from supplier images folder
            $url = explode('storage/tenantsupplier/app/public/', $image->image_path);
            $imagePath = $url[1];
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $image->delete();
            $product_images = SupplierProductImages::where('product_id', $product_id)->get();

            return response()->json([
                'status' => 'success',
                'product_images' => $product_images,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'image not found',
            ], 400);
        }
    }

    // function delete_product_video()
    public function delete_product_video($id)
    {
        // get video from database
        $video = SupplierProductVideos::find($id);
        $product_id = $video->product_id;
        if ($video != null) {
            // delete video from supplier videos folder
            $url = explode('storage/tenantsupplier/app/public/', $video->file_path);
            $videoPath = $url[1];
            if (Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            $video->delete();
            $product_videos = SupplierProductVideos::where('product_id', $product_id)->get();

            return response()->json([
                'status' => 'success',
                'product_videos' => $product_videos,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'video not found',
            ], 400);
        }
    }

    // function delete_product_variation
    public function delete_product_variation($id)
    {
        $product_variation = SupplierProductVariations::findOrfail($id);
        $product_id = $product_variation->product_id;
        $product_variation->delete();
        $product_variations = SupplierProductVariations::where('product_id', $product_id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'variation deleted successfully',
            'product_variations' => $product_variations,
        ]);
    }

    // function delete_product_discount
    public function delete_product_discount($id)
    {
        $product_discount = SupplierProductDiscounts::findOrfail($id);
        $product_discount->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'discount deleted successfully',
        ]);
    }

    // function delete_product_attribute
    public function delete_product_attribute($id)
    {
        $product_attribute = SupplierProductAttributes::findOrfail($id);
        $product_attribute->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'attribute deleted successfully',
        ]);
    }

    // /filter products
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
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        $products = $query->where('supplier_id', get_supplier_data(auth()->user()->tenant_id)->id)->get();

        return view('users.suppliers.components.content.products.partials.product_table', compact('products'))->render();
    }

    // get_json_data
    public function get_json_data($id)
    {
        $product = SupplierProducts::findOrfail($id);

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }
}
