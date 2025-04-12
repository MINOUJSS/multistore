<?php

namespace App\Listeners;

use App\Models\Category;
use App\Models\UserSlider;
use App\Models\SupplierFqa;
use App\Models\SupplierPage;
use App\Models\ShippingPrice;
use App\Models\SupplierProducts;
use App\Models\UserStoreCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CteateDefaultContentForSupplierListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // create default slider
        $supplier = $event->supplier;
        $user_id = auth()->user()->id;
        
        $defaultSliders = [
            ['user_id'=> auth()->user()->id,'title' => 'مرحبًا بكم في متجرك', 'description' => 'اكتشف...', 'image' => 'asset/users/store/img/slider/pc-slider1.png', 'status' => 'active', 'order' => 1],
            ['user_id'=> auth()->user()->id,'title' => 'أضف منتجاتك بسهولة', 'description' => 'ابدأ...', 'image' => 'asset/users/store/img/slider/pc-slider2.png', 'status' => 'active', 'order' => 2],
            ['user_id'=> auth()->user()->id,'title' => 'روّج لمنتجاتك الآن', 'description' => 'استخدم...', 'image' => 'asset/users/store/img/slider/pc-slider3.png', 'status' => 'active', 'order' => 3],
        ];

        foreach ($defaultSliders as $slider) {
            UserSlider::create($slider);
        }

        //create default category
        $defaultCategories = [
            ['name' => 'بدون تصنيف', 'description' => 'صنف عام لكل المنتجات', 'slug' => tenant_to_slug($supplier->tenant_id).'-cat0'],
            ['name' => 'الصنف-1', 'description' => 'وصف الصنف الأول', 'slug' => tenant_to_slug($supplier->tenant_id).'-cat1'],
            ['name' => 'الصنف-2', 'description' => 'وصف الصنف الثاني', 'slug' => tenant_to_slug($supplier->tenant_id).'-cat2'],
            ['name' => 'الصنف-3', 'description' => 'وصف الصنف الثالث', 'slug' => tenant_to_slug($supplier->tenant_id).'-cat3'],
        ];
        $image_index=0;
        foreach ($defaultCategories as $categoryData) {
            $image_index++;
            $category=Category::create($categoryData);
             // ربط القسم بالمستخدم (المورد) في جدول user_store_categories
                UserStoreCategory::create([
                    'user_id'     => $user_id, // معرف المستخدم (المورد)
                    'category_id' => $category->id, // معرف القسم
                    'image'       => 'asset/users/store/img/categories/'.$image_index.'.png',          // أو قيمة افتراضية
                    'icon'        => null,          // أو قيمة افتراضية
                    'order'       => 0,             // ترتيب القسم
                ]);
        }

        //get supplier default category
        $default_category=Category::where('slug',tenant_to_slug($supplier->tenant_id).'-cat0')->first();
        //ctreate default products
        $defaultProducts = [
            [
                'name' => 'منتج 1',
                'slug' => tenant_to_slug($supplier->tenant_id).'-product-1',
                'short_description' => 'وصف قصير للمنتج الأول.',
                'description' => 'وصف مفصل للمنتج الأول.',
                'price' => 100.00,
                'cost' => 70.00,
                'image' => asset('asset/users/store/img/products/product.webp'),
                'qty' => 50,
                'minimum_order_qty' => 1,
                'condition' => 'new',
                'free_shipping' => 'no',
                'status' => 'active',
            ],
            [
                'name' => 'منتج 2',
                'slug' => tenant_to_slug($supplier->tenant_id).'-product-2',
                'short_description' => 'وصف قصير للمنتج الثاني.',
                'description' => 'وصف مفصل للمنتج الثاني.',
                'price' => 200.00,
                'cost' => 150.00,
                'image' => asset('asset/users/store/img/products/product.webp'),
                'qty' => 30,
                'minimum_order_qty' => 2,
                'condition' => 'new',
                'free_shipping' => 'yes',
                'status' => 'active',
            ],
            [
                'name' => 'منتج 3',
                'slug' => tenant_to_slug($supplier->tenant_id).'-product-3',
                'short_description' => 'وصف قصير للمنتج الثالث.',
                'description' => 'وصف مفصل للمنتج الثالث.',
                'price' => 300.00,
                'cost' => 250.00,
                'image' => asset('asset/users/store/img/products/product.webp'),
                'qty' => 20,
                'minimum_order_qty' => 1,
                'condition' => 'new',
                'free_shipping' => 'no',
                'status' => 'active',
            ],
            [
                'name' => 'منتج 4',
                'slug' => tenant_to_slug($supplier->tenant_id).'-product-4',
                'short_description' => 'وصف قصير للمنتج الرابع.',
                'description' => 'وصف مفصل للمنتج الرابع.',
                'price' => 400.00,
                'cost' => 300.00,
                'image' => asset('asset/users/store/img/products/product.webp'),
                'qty' => 10,
                'minimum_order_qty' => 1,
                'condition' => 'new',
                'free_shipping' => 'yes',
                'status' => 'active',
            ],
        ];
        
        foreach ($defaultProducts as $productData) {
            SupplierProducts::create(array_merge($productData, [
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
                'category_id' => $default_category->id,          // يمكن تحديثه لاحقًا أو تحديده عند الإنشاء
            ]));
        }

        // إنشاء تسعيرات افتراضية لكل الولايات
        $defaultShippingPrices = [
            ['wilaya_id' => 1,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 2,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 3,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 4,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 5,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 6,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 7,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 8,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 9,'shipping_available_to_wilaya' => 1,'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 10,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 11,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 12,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 13,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 14,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 15,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 16,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 17,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 18,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 19,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 20,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 21,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 22,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 23,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 24,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 25,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 26,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 27,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 28,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 29,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 30,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 31,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 32,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 33,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 34,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 35,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 36,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 37,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 38,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 39,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 40,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 41,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 42,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 43,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 44,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 45,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 46,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 47,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 48,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 49,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 50,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 51,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 52,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 53,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            ['wilaya_id' => 54,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 550.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 850.00, 'shipping_available_to_home' => 1, 'additional_price' => 220.00, 'additional_price_status' => 1],
            ['wilaya_id' => 55,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 650.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 950.00, 'shipping_available_to_home' => 1, 'additional_price' => 270.00, 'additional_price_status' => 1],
            ['wilaya_id' => 56,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 500.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 800.00, 'shipping_available_to_home' => 1, 'additional_price' => 200.00, 'additional_price_status' => 1],
            ['wilaya_id' => 57,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 600.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 900.00, 'shipping_available_to_home' => 1, 'additional_price' => 250.00, 'additional_price_status' => 1],
            ['wilaya_id' => 58,'shipping_available_to_wilaya' => 1, 'stop_desck_price' => 700.00, 'shipping_available_to_stop_desck' => 1, 'to_home_price' => 1000.00, 'shipping_available_to_home' => 1, 'additional_price' => 300.00, 'additional_price_status' => 1],
            // يمكنك إضافة جميع ولايات الجزائر الـ 58 هنا بنفس النمط
        ];

        foreach ($defaultShippingPrices as $shippingData) {
            ShippingPrice::create(array_merge($shippingData, [
                'user_id' => $user_id, // ربط تسعيرة التوصيل بالمستخدم (المورد)
            ]));
        }


        //create default fqy
        $defaultFqa = [
            [
                'supplier_id' => $event->supplier->id,
                'question' => 'كيف يمكنني إضافة منتج جديد؟',
                'answer' => 'لإضافة منتج جديد، انتقل إلى قسم "إدارة المنتجات" واضغط على "إضافة منتج".',
                'order' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => $event->supplier->id,
                'question' => 'كيف يمكنني إدارة الطلبات؟',
                'answer' => 'يمكنك إدارة الطلبات من خلال قسم "الطلبات" في لوحة التحكم.',
                'order' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => $event->supplier->id,
                'question' => 'ما هي طرق الدفع المتاحة؟',
                'answer' => 'المتجر يدعم الدفع عبر البطاقات الائتمانية والتحويل البنكي.',
                'order' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($defaultFqa as $fqaData) {
            SupplierFqa::create($fqaData);
        }
        //create default pages
        //صفحة عن المتجر
        SupplierPage::create([
                'title' => 'عن المتجر',
                'slug' => 'about',
                'content' => '<h1>عن متجرنا</h1><p>مرحبًا بكم في <strong>متجرنا</strong>، حيث نقدم لكم أفضل المنتجات والخدمات التي تلبي احتياجاتكم بأعلى مستويات الجودة. نحن نسعى دائمًا لتحقيق رضاكم من خلال تجربة تسوق فريدة ومريحة.</p><h2>رؤيتنا</h2><p>أن نكون الوجهة الأولى للتسوق الإلكتروني، مع توفير منتجات متنوعة بأسعار تنافسية وجودة عالية.</p><h2>رسالتنا</h2><p>تقديم تجربة تسوق إلكتروني مميزة تلبي احتياجات العملاء مع الحرص على تقديم خدمة عملاء استثنائية وسريعة.</p><h2>قيمنا</h2><ul><li>الشفافية والمصداقية في التعامل.</li><li>الالتزام بالجودة والتميز.</li><li>الابتكار المستمر في تقديم أفضل الحلول.</li></ul><h2>لماذا نحن؟</h2><p>- نقدم مجموعة واسعة من المنتجات التي تلبي مختلف الأذواق.<br>- نسعى لتقديم أفضل الأسعار مع الحفاظ على الجودة.<br>- نحرص على توفير خدمة عملاء متوفرة على مدار الساعة.<br>- نوفر شحنًا سريعًا وآمنًا لكل الطلبات.</p><h2>تواصل معنا</h2><p>إذا كان لديك أي استفسارات أو اقتراحات، لا تتردد في التواصل معنا عبر صفحة <a href="/contact-us">اتصل بنا</a>. نحن هنا لخدمتك دائمًا.</p>',
                'meta_title' => 'عن المتجر',
                'meta_description' => 'صفحة تحتوي على معلومات عن المتجر.',
                'meta_keywords' => 'معلومات, المتجر',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //الشحن و التسليم   
        SupplierPage::create([
                'title' => 'شحن و التسليم',
                'slug' => 'shipping-policy',
                'content' => '<h1>الشحن والتسليم</h1>
<p>
    في <strong>متجرنا</strong>، نسعى لتوفير تجربة شحن مريحة وسريعة لعملائنا الكرام. نحن نعمل مع أفضل شركات الشحن لضمان وصول طلباتكم بأسرع وقت ممكن وبأعلى مستويات الجودة.
</p>

<h2>مدة معالجة الطلبات</h2>
<p>
    - يتم تجهيز الطلبات خلال <strong>1-3 أيام عمل</strong> من تاريخ تأكيد الطلب.<br>
    - قد تختلف مدة التجهيز بناءً على نوع المنتج أو فترات العروض.
</p>

<h2>شركات الشحن</h2>
<p>
    نحن نتعاون مع شركات الشحن الرائدة لضمان تقديم خدمات موثوقة وسريعة. تشمل شركات الشحن:
</p>
<ul>
    <li>شركة الشحن الأولى</li>
    <li>شركة الشحن الثانية</li>
    <li>شركة الشحن الثالثة</li>
</ul>

<h2>رسوم الشحن</h2>
<p>
    - تعتمد رسوم الشحن على وزن المنتج وموقع التسليم.<br>
    - بعض الطلبات قد تكون مؤهلة للحصول على <strong>شحن مجاني</strong> إذا تجاوزت قيمة الشراء حدًا معينًا.<br>
    - سيتم عرض تفاصيل رسوم الشحن عند إتمام عملية الدفع.
</p>

<h2>مدة التوصيل</h2>
<p>
    - تختلف مدة التوصيل حسب المنطقة الجغرافية:<br>
    <ul>
        <li><strong>داخل المدينة:</strong> 1-2 أيام عمل</li>
        <li><strong>داخل الدولة:</strong> 2-5 أيام عمل</li>
        <li><strong>الشحن الدولي:</strong> 7-14 يوم عمل</li>
    </ul>
</p>

<h2>تتبع الشحنات</h2>
<p>
    بمجرد شحن طلبك، سنرسل إليك رقم تتبع يمكنك من خلاله متابعة حالة شحنتك عبر الموقع الإلكتروني لشركة الشحن.
</p>

<h2>سياسة الشحن والتسليم</h2>
<p>
    - نضمن توصيل المنتجات بحالة سليمة وفي الوقت المحدد.<br>
    - في حالة وجود أي مشكلة أثناء الشحن أو تأخير، يرجى التواصل مع فريق خدمة العملاء.
</p>

<h2>التواصل</h2>
<p>
    إذا كان لديك أي استفسارات تتعلق بالشحن والتسليم، لا تتردد في التواصل معنا عبر صفحة <a href="/contact-us">اتصل بنا</a> أو من خلال رقم خدمة العملاء.
</p>
',
                'meta_title' => 'شحن و التسليم',
                'meta_description' => 'صفحة تحتوي على معلومات عن شحن و التسليم.',
                'meta_keywords' => 'معلومات, شحن و التسليم',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //طرق الدفع
        SupplierPage::create([
                'title' => 'طرق الدفع',
                'slug' => 'payment-policy',
                'content' => '<h1>طرق الدفع</h1>
<p>
    في <strong>متجرنا</strong>، نوفر لك العديد من الخيارات المريحة والآمنة لإتمام عملية الدفع. نسعى لضمان تجربة تسوق سلسة ومناسبة لاحتياجاتك.
</p>

<h2>خيارات الدفع المتاحة</h2>
<ul>
    <li>
        <strong>الدفع الإلكتروني</strong>:<br>
        يمكنك استخدام بطاقات الائتمان أو بطاقات الخصم المباشر مثل Visa وMasterCard وAmerican Express لإتمام عملية الدفع بكل أمان وسهولة.
    </li>
    <li>
        <strong>الدفع عند الاستلام</strong>:<br>
        إذا كنت تفضل الدفع بعد استلام طلبك، نقدم لك خدمة الدفع عند الاستلام. <em>(قد يتم تطبيق رسوم إضافية على هذه الخدمة حسب موقعك.)</em>
    </li>
    <li>
        <strong>المحافظ الرقمية</strong>:<br>
        ندعم المحافظ الرقمية مثل PayPal وApple Pay وGoogle Pay، لتوفير تجربة دفع حديثة وآمنة.
    </li>
    <li>
        <strong>الحوالات المصرفية</strong>:<br>
        يمكنك اختيار تحويل الأموال مباشرة إلى حسابنا المصرفي. ستظهر تفاصيل الحساب أثناء إتمام عملية الدفع.
    </li>
</ul>

<h2>معايير الأمان</h2>
<p>
    نحن نستخدم أحدث تقنيات التشفير لضمان حماية بياناتك أثناء عملية الدفع. يتم التعامل مع جميع المعلومات المالية بسرية تامة وفقًا للمعايير الدولية.
</p>

<h2>سياسة استرداد الأموال</h2>
<p>
    - إذا واجهتك أي مشكلة أثناء عملية الدفع أو إذا كنت بحاجة إلى استرداد الأموال، يمكنك التواصل معنا عبر صفحة <a href="/contact-us">اتصل بنا</a>.<br>
    - ستتم معالجة طلبات الاسترداد وفقًا لشروط وأحكام الاسترجاع.
</p>

<h2>التواصل معنا</h2>
<p>
    إذا كنت بحاجة إلى أي مساعدة أثناء عملية الدفع، لا تتردد في التواصل مع فريق الدعم الخاص بنا عبر:<br>
    - <strong>البريد الإلكتروني:</strong> support@example.com<br>
    - <strong>رقم الهاتف:</strong> +123-456-7890
</p>

<h2>نصائح للدفع الآمن</h2>
<p>
    - تأكد من استخدام شبكة إنترنت آمنة عند إتمام عملية الدفع.<br>
    - لا تشارك معلومات بطاقتك مع أي طرف ثالث.<br>
    - تحقق من وجود رمز القفل الآمن في شريط عنوان المتصفح أثناء الدفع.
</p>
',
                'meta_title' => 'طرق الدفع',
                'meta_description' => 'صفحة تحتوي على معلومات عن طرق الدفع.',
                'meta_keywords' => 'معلومات, طرق الدفع',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //شروط الإستخدام
        SupplierPage::create([
                'title' => 'شروط الإستخدام',
                'slug' => 'terms-of-use',
                'content' => '<h1>شروط الاستخدام</h1>
<p>
    مرحبًا بك في <strong>متجرنا</strong>. باستخدامك لهذا الموقع، فإنك توافق على الالتزام بالشروط والأحكام التالية. يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.
</p>

<h2>1. القبول بالشروط</h2>
<p>
    باستخدامك لهذا الموقع، فإنك تقر بأنك قد قرأت وفهمت ووافقت على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، يرجى التوقف عن استخدام الموقع.
</p>

<h2>2. التعديلات على الشروط</h2>
<p>
    نحن نحتفظ بالحق في تعديل أو تحديث شروط الاستخدام في أي وقت دون إشعار مسبق. سيتم نشر النسخة المحدثة على هذه الصفحة. استمرارك في استخدام الموقع بعد التعديلات يعتبر موافقة منك على الشروط المعدلة.
</p>

<h2>3. الاستخدام المسموح</h2>
<p>
    يحق لك استخدام الموقع لأغراض شخصية وقانونية فقط. يحظر عليك:
</p>
<ul>
    <li>استخدام الموقع لأي غرض غير قانوني أو غير مصرح به.</li>
    <li>انتهاك حقوق الملكية الفكرية الخاصة بنا أو الخاصة بالآخرين.</li>
    <li>نشر أو توزيع أي محتوى غير قانوني أو مسيء أو مضر.</li>
</ul>

<h2>4. الحسابات والأمان</h2>
<p>
    عند إنشاء حساب على الموقع، فإنك تتحمل مسؤولية الحفاظ على سرية معلومات حسابك. أنت مسؤول عن جميع الأنشطة التي تتم من خلال حسابك. في حالة الاشتباه في أي استخدام غير مصرح به لحسابك، يرجى الاتصال بنا فورًا.
</p>

<h2>5. المحتوى والملكية الفكرية</h2>
<p>
    جميع المحتويات على الموقع، بما في ذلك النصوص والصور والشعارات والبرمجيات، محمية بموجب حقوق الملكية الفكرية. يُحظر نسخ أو إعادة توزيع أي محتوى دون إذن خطي مسبق.
</p>

<h2>6. سياسة الخصوصية</h2>
<p>
    استخدامك للموقع يخضع لسياسة الخصوصية الخاصة بنا. نوصي بمراجعة <a href="/privacy-policy">سياسة الخصوصية</a> لمعرفة كيفية جمع واستخدام وحماية بياناتك.
</p>

<h2>7. حدود المسؤولية</h2>
<p>
    نحن غير مسؤولين عن أي أضرار مباشرة أو غير مباشرة قد تنشأ عن استخدام الموقع أو عدم القدرة على استخدامه. يُعد استخدامك للموقع على مسؤوليتك الشخصية.
</p>

<h2>8. إنهاء الاستخدام</h2>
<p>
    نحتفظ بالحق في تعليق أو إنهاء وصولك إلى الموقع في أي وقت ولأي سبب دون إشعار مسبق.
</p>

<h2>9. القانون المعمول به</h2>
<p>
    تخضع هذه الشروط والأحكام وتُفسر وفقًا للقوانين المعمول بها في بلد مقر الشركة.
</p>

<h2>10. التواصل معنا</h2>
<p>
    إذا كانت لديك أي أسئلة حول شروط الاستخدام، يرجى التواصل معنا عبر:
</p>
<ul>
    <li>البريد الإلكتروني: support@example.com</li>
    <li>الهاتف: +123-456-7890</li>
</ul>
',
                'meta_title' => 'شروط الإستخدام',
                'meta_description' => 'صفحة تحتوي على معلومات عن شروط الإستخدام.',
                'meta_keywords' => 'معلومات, شروط الإستخدام',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //سياسة الإستبدال و الإسترجاع
        SupplierPage::create([
                'title' => 'سياسة الإستبدال و الإسترجاع',
                'slug' => 'exchange-policy',
                'content' => '<h1>سياسة الاستبدال والاسترجاع</h1>
<p>
    نحن نسعى دائمًا لضمان رضاكم عن منتجاتنا وخدماتنا. إذا واجهتم أي مشكلة مع أحد المنتجات، فإن سياستنا للاستبدال والاسترجاع تتيح لكم خيارات مرنة ومريحة.
</p>

<h2>1. الشروط العامة للاستبدال والاسترجاع</h2>
<p>
    يمكنكم طلب استبدال أو استرجاع المنتج في الحالات التالية:
</p>
<ul>
    <li>إذا كان المنتج تالفًا أو معيبًا عند استلامه.</li>
    <li>إذا استلمتم منتجًا مختلفًا عن طلبكم.</li>
    <li>إذا لم يتم استخدام المنتج وكان في حالته الأصلية مع وجود جميع ملحقاته.</li>
</ul>

<h2>2. مدة الاستبدال والاسترجاع</h2>
<p>
    <strong>الاستبدال:</strong> يمكنكم طلب استبدال المنتج خلال <strong>7 أيام</strong> من تاريخ استلامه.<br>
    <strong>الاسترجاع:</strong> يمكنكم طلب استرجاع المنتج واسترداد الأموال خلال <strong>14 يومًا</strong> من تاريخ استلامه.
</p>

<h2>3. خطوات طلب الاستبدال أو الاسترجاع</h2>
<p>
    لتقديم طلب استبدال أو استرجاع، يرجى اتباع الخطوات التالية:
</p>
<ol>
    <li>التواصل مع فريق خدمة العملاء عبر البريد الإلكتروني أو الهاتف.</li>
    <li>تقديم تفاصيل الطلب ورقم الفاتورة.</li>
    <li>إرفاق صور للمنتج (في حالة وجود تلف أو عيب).</li>
    <li>انتظار تأكيد الطلب من فريق الدعم.</li>
</ol>

<h2>4. الشروط الخاصة بالاسترجاع</h2>
<p>
    عند استرجاع المنتج، يرجى التأكد من:
</p>
<ul>
    <li>إعادة المنتج في عبوته الأصلية مع جميع الملحقات.</li>
    <li>توفير إيصال الشراء الأصلي.</li>
    <li>تحمل تكاليف الشحن (ما لم يكن الخطأ من جانبنا).</li>
</ul>

<h2>5. طرق استرداد الأموال</h2>
<p>
    سيتم استرداد المبلغ المدفوع بنفس طريقة الدفع المستخدمة عند الشراء. قد يستغرق استرداد الأموال ما بين <strong>3 إلى 7 أيام عمل</strong> حسب البنك أو طريقة الدفع.
</p>

<h2>6. الحالات التي لا يمكن فيها الاستبدال أو الاسترجاع</h2>
<p>
    يرجى ملاحظة أن بعض المنتجات لا يمكن استبدالها أو استرجاعها، مثل:
</p>
<ul>
    <li>المنتجات المستخدمة أو التي تعرضت للتلف بسبب سوء الاستخدام.</li>
    <li>المنتجات القابلة للتلف مثل الأطعمة والمشروبات.</li>
    <li>المنتجات المصنوعة حسب الطلب.</li>
</ul>

<h2>7. التواصل معنا</h2>
<p>
    إذا كانت لديكم أي استفسارات أو طلبات متعلقة بسياسة الاستبدال والاسترجاع، يمكنكم التواصل معنا عبر:
</p>
<ul>
    <li>البريد الإلكتروني: support@example.com</li>
    <li>الهاتف: +123-456-7890</li>
    <li>الدردشة المباشرة على موقعنا.</li>
</ul>

<h2>8. تحديث السياسة</h2>
<p>
    نحتفظ بالحق في تعديل سياسة الاستبدال والاسترجاع في أي وقت. سيتم نشر النسخة المحدثة على هذه الصفحة.
</p>
',
                'meta_title' => 'سياسة الإستبدال و الإسترجاع',
                'meta_description' => 'صفحة تحتوي على معلومات عن سياسة الإستبدال و الإسترجاع.',
                'meta_keywords' => 'معلومات, سياسة الإستبدال و الإسترجاع',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //سياسة الخصوصية
        SupplierPage::create([
                'title' => 'سياسة الخصوصية',
                'slug' => 'privacy-policy',
                'content' => '<h1>سياسة الخصوصية</h1>
<p>
    نحن نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام ومشاركة معلوماتك عند استخدامك لمنصتنا.
</p>

<h2>1. المعلومات التي نجمعها</h2>
<p>نقوم بجمع المعلومات التالية عند استخدامك لمنصتنا:</p>
<ul>
    <li><strong>المعلومات الشخصية:</strong> مثل الاسم، عنوان البريد الإلكتروني، رقم الهاتف، وعنوان الإقامة.</li>
    <li><strong>معلومات الدفع:</strong> مثل تفاصيل بطاقات الائتمان أو الحساب البنكي (إذا لزم الأمر).</li>
    <li><strong>معلومات الجهاز:</strong> مثل نوع الجهاز، عنوان IP، ونظام التشغيل.</li>
    <li><strong>معلومات التصفح:</strong> مثل الصفحات التي تزورها والأنشطة التي تقوم بها على الموقع.</li>
</ul>

<h2>2. كيفية استخدام المعلومات</h2>
<p>نستخدم المعلومات التي نجمعها للأغراض التالية:</p>
<ul>
    <li>معالجة الطلبات وتقديم المنتجات والخدمات.</li>
    <li>تحسين تجربة المستخدم على الموقع.</li>
    <li>إدارة الحسابات وتقديم الدعم الفني.</li>
    <li>إرسال التحديثات والعروض الترويجية (بموافقتك).</li>
    <li>ضمان الأمان ومنع الاحتيال.</li>
</ul>

<h2>3. مشاركة المعلومات</h2>
<p>
    نحن لا نبيع بياناتك الشخصية لأي طرف ثالث. ومع ذلك، قد نشارك معلوماتك مع الأطراف التالية:
</p>
<ul>
    <li>مزودي الخدمات مثل شركات الشحن ومعالجي الدفع.</li>
    <li>الجهات الحكومية أو القانونية عند الضرورة للامتثال للقوانين.</li>
</ul>

<h2>4. حقوقك</h2>
<p>
    لديك حقوق معينة فيما يتعلق ببياناتك الشخصية، بما في ذلك:
</p>
<ul>
    <li>الوصول إلى البيانات التي نحتفظ بها عنك.</li>
    <li>طلب تصحيح أو حذف بياناتك.</li>
    <li>إلغاء الاشتراك من الاتصالات التسويقية.</li>
</ul>
<p>
    يمكنك ممارسة حقوقك عن طريق الاتصال بنا باستخدام تفاصيل الاتصال أدناه.
</p>

<h2>5. حماية البيانات</h2>
<p>
    نحن نتخذ التدابير الأمنية المناسبة لحماية بياناتك الشخصية من الوصول غير المصرح به أو الاستخدام غير المشروع.
</p>

<h2>6. ملفات تعريف الارتباط (Cookies)</h2>
<p>
    نحن نستخدم ملفات تعريف الارتباط لتحسين تجربة التصفح وجمع البيانات التحليلية. يمكنك التحكم في إعدادات ملفات تعريف الارتباط من خلال متصفحك.
</p>

<h2>7. تحديثات سياسة الخصوصية</h2>
<p>
    قد نقوم بتحديث سياسة الخصوصية من وقت لآخر. سيتم نشر النسخة المحدثة على هذه الصفحة مع تاريخ السريان.
</p>

<h2>8. التواصل معنا</h2>
<p>
    إذا كانت لديك أي أسئلة أو مخاوف بشأن سياسة الخصوصية هذه، يمكنك التواصل معنا عبر:
</p>
<ul>
    <li>البريد الإلكتروني: privacy@example.com</li>
    <li>الهاتف: +123-456-7890</li>
</ul>
<p>
    تاريخ السريان: <strong>01 يناير 2024</strong>
</p>
',
                'meta_title' => 'سياسة الخصوصية',
                'meta_description' => 'صفحة تحتوي على معلومات عن سياسة الخصوصية.',
                'meta_keywords' => 'معلومات, سياسة الخصوصية',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //اتصل بنا
        SupplierPage::create([
                'title' => 'اتصل بنا',
                'slug' => 'contact-us',
                'content' => '<h1>اتصل بنا</h1>
<p>
    نحن هنا لمساعدتك! إذا كانت لديك أي استفسارات أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا من خلال الطرق الموضحة أدناه.
</p>

<h2>معلومات التواصل</h2>
<ul>
    <li><strong>البريد الإلكتروني:</strong> <a href="mailto:support@example.com">support@example.com</a></li>
    <li><strong>الهاتف:</strong> <a href="tel:+1234567890">+123-456-7890</a></li>
    <li><strong>العنوان:</strong> شارع XYZ، المدينة ABC، البلد DEF</li>
</ul>

<h2>ساعات العمل</h2>
<p>
    نحن متاحون للرد على استفساراتك خلال الأوقات التالية:
</p>
<ul>
    <li>من الأحد إلى الخميس: 9:00 صباحًا - 6:00 مساءً</li>
    <li>الجمعة والسبت: مغلق</li>
</ul>

<h2>نموذج الاتصال</h2>
<p>
    يمكنك أيضًا إرسال استفسارك مباشرة عبر النموذج أدناه:
</p>
<form action="/contact" method="post">
    <div style="margin-bottom: 10px;">
        <label for="name">الاسم الكامل:</label><br>
        <input type="text" id="name" name="name" required style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="email">البريد الإلكتروني:</label><br>
        <input type="email" id="email" name="email" required style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="subject">الموضوع:</label><br>
        <input type="text" id="subject" name="subject" required style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="message">الرسالة:</label><br>
        <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 8px;"></textarea>
    </div>
    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
        إرسال
    </button>
</form>

<h2>مواقع التواصل الاجتماعي</h2>
<p>
    تابعنا على منصات التواصل الاجتماعي للحصول على أحدث الأخبار والعروض:
</p>
<ul>
    <li><a href="https://facebook.com/example" target="_blank">فيسبوك</a></li>
    <li><a href="https://twitter.com/example" target="_blank">تويتر</a></li>
    <li><a href="https://instagram.com/example" target="_blank">إنستغرام</a></li>
    <li><a href="https://linkedin.com/company/example" target="_blank">لينكدإن</a></li>
</ul>
<p>
    شكراً لتواصلك معنا!
</p>
',
                'meta_title' => 'اتصل بنا',
                'meta_description' => 'صفحة تحتوي على معلومات عن اتصل بنا.',
                'meta_keywords' => 'معلومات, اتصل بنا',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
        //الأسئلة الشائعة
        SupplierPage::create([
                'title' => 'الأسئلة الشائعة',
                'slug' => 'faq',
                'content' => '<h1>الأسئلة الشائعة</h1>
<p>
    لقد قمنا بجمع مجموعة من الأسئلة الشائعة التي قد تساعدك في الحصول على إجابات سريعة لاستفساراتك.
    إذا كنت بحاجة إلى مزيد من المعلومات، لا تتردد في <a href="/contact-us">التواصل معنا</a>.
</p>

<h2>الأسئلة الشائعة</h2>
<div>
    <h3>1. كيف يمكنني إنشاء حساب جديد؟</h3>
    <p>
        لإنشاء حساب جديد، اضغط على زر "تسجيل" في أعلى الصفحة واملأ النموذج بالمعلومات المطلوبة.
    </p>
</div>

<div>
    <h3>2. ما هي طرق الدفع المقبولة؟</h3>
    <p>
        نقبل حاليًا بطاقات الائتمان الرئيسية، الدفع عبر PayPal، والدفع عند الاستلام.
    </p>
</div>

<div>
    <h3>3. كيف يمكنني تتبع طلبي؟</h3>
    <p>
        يمكنك تتبع طلبك من خلال تسجيل الدخول إلى حسابك والانتقال إلى صفحة "طلباتي". ستجد هناك تفاصيل الطلب ورابط تتبع.
    </p>
</div>

<div>
    <h3>4. ما هي سياسة الاستبدال والإرجاع؟</h3>
    <p>
        يمكنك مراجعة صفحة <a href="/return-policy">سياسة الاستبدال والإرجاع</a> للحصول على التفاصيل الكاملة.
    </p>
</div>

<div>
    <h3>5. هل يمكنني تعديل طلبي بعد تأكيده؟</h3>
    <p>
        للأسف، لا يمكن تعديل الطلب بعد تأكيده. يمكنك إلغاء الطلب قبل الشحن وإعادة تقديم طلب جديد.
    </p>
</div>

<div>
    <h3>6. كيف يمكنني الاتصال بخدمة العملاء؟</h3>
    <p>
        يمكنك الاتصال بخدمة العملاء عن طريق زيارة صفحة <a href="/contact-us">اتصل بنا</a>.
    </p>
</div>

<h2>لم تجد إجابتك هنا؟</h2>
<p>
    إذا لم تجد الإجابة التي تبحث عنها، فلا تتردد في التواصل معنا للحصول على المساعدة. نحن هنا لخدمتك!
</p>
',
                'meta_title' => 'الأسئلة الشائعة',
                'meta_description' => 'صفحة تحتوي على معلومات عن الأسئلة الشائعة.',
                'meta_keywords' => 'معلومات, الأسئلة الشائعة',
                'status' => 'published',
                'supplier_id' => $supplier->id, // ربط المنتج بالمورد
            ]);
    //

    }
}
