<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier\SupplierPlanAuthorizations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Supplier_Plan_Authorization_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // الخطة المجانية (ID = 1)
            1 => [
                ['key' =>'store','value'=>1,'description'=>'متجر إلكتروني إحترافي','is_enabled'=>true],
                ['key' => 'free_sub_domane','value' =>1,'description' => 'دومين فرعي مجاني','is_enabled' => true],
                ['key' => 'comission_for_orders','value' =>0,'description' =>'إقتطاع على كل طلب (50 طلب مجاني عند أول تسجيل)','is_enabled' => true],
                ['key' => 'comission_for_orders_abandoned','value'=>0,'description' => 'إقتطاع 10 د.ج على كل طلب متروك','is_enabled' =>true],
                ['key' => 'max_products', 'value' => 12,'description' => ' المنتجات المسموح بها (12)','is_enabled' => true],
                //['key' => 'store_visibility','value'=>0,'description' =>'ظهور المتجر للتجار الغير مشتركين في المنصة','is_enabled' => false],
                ['key' => 'max_facebook_pixel', 'value' => 1,'description' => ' بيكسل فيسبوك (1)','is_enabled' => true],
                ['key' => 'max_telegram_notification', 'value' => 1,'description' => 'إشعارات الطلبات على التليجرام','is_enabled' => true],
                ['key' => 'max_tiktok_pixel', 'value' => 0,'description' => ' بيكسل تيكتوك ','is_enabled' => false],
                ['key' => 'max_google_analytics', 'value' => 0,'description' => '  جوجل أناليتيك ','is_enabled' => false],
                ['key' => 'max_microsoft_clarity', 'value' => 0,'description' => '  ميكروسوفت كلاريتي ','is_enabled' => false],
                ['key' => 'google_sheet','value' =>1,'description' =>' جوجل شيت','is_enabled' => false],
                ['key' => 'copy_right' ,'value' => 0, 'description' => 'مع حقوق النشر للمنصة','is_enabled' => true],
            ],

            // الخطة المتوسطة (ID = 2)
            2 => [
                ['key' =>'store','value'=>1,'description'=>'متجر إلكتروني إحترافي','is_enabled'=>true],
                ['key' => 'domane','value' =>1,'description' => 'دومين إحترافي ','is_enabled' => true],
                ['key' => 'comission_for_orders','value' =>0,'description' =>'طلبات غير محدودة (بدون إقتطاعات)','is_enabled' => true],
                ['key' => 'comission_for_orders_abandoned','value'=>1,'description' => 'إقتطاع 5 د.ج على كل طلب متروك','is_enabled' =>true],
                ['key' => 'max_products', 'value' => 100,'description' => ' المنتجات المسموح بها (100)','is_enabled' => true],
                ['key' => 'max_facebook_pixel', 'value' => 2,'description' => ' بيكسل فيسبوك (2)','is_enabled' => true],
                ['key' => 'max_telegram_notification', 'value' => 1,'description' => 'إشعارات الطلبات على التليجرام','is_enabled' => true],
                ['key' => 'max_tiktok_pixel', 'value' => 1,'description' => ' بيكسل تيكتوك (1)','is_enabled' => true],
                ['key' => 'max_google_analytics', 'value' => 1,'description' => '  جوجل أناليتيك (1)','is_enabled' => true],
                ['key' => 'max_microsoft_clarity', 'value' => 1,'description' => '  ميكروسوفت كلاريتي (1)','is_enabled' => true],
                ['key' => 'google_sheet','value' =>1,'description' =>' جوجل شيت','is_enabled' => true],
                ['key' => 'copy_right' ,'value' => 0, 'description' => 'مع حقوق النشر للمنصة','is_enabled' => false],
            ],

            // الخطة المتقدمة (ID = 3)
            3 => [
                ['key' =>'store','value'=>1,'description'=>'متجر إلكتروني إحترافي','is_enabled'=>true],
                ['key' => 'domane','value' =>1,'description' => 'دومين إحترافي ','is_enabled' => true],
                ['key' => 'comission_for_orders','value' =>0,'description' =>'طلبات غير محدودة (بدون إقتطاعات)','is_enabled' => true],
                ['key' => 'comission_for_orders_abandoned','value'=>2,'description' => ' طلب متروكة غير محدودة (بدون إقتطاعات)','is_enabled' =>true],
                ['key' => 'max_products', 'value' => 1000,'description' => ' المنتجات المسموح بها (غير محدودة)','is_enabled' => true],
                ['key' => 'max_facebook_pixel', 'value' => 4,'description' => ' بيكسل فيسبوك (4)','is_enabled' => true],
                ['key' => 'max_telegram_notification', 'value' => 1,'description' => 'إشعارات الطلبات على التليجرام','is_enabled' => true],
                ['key' => 'max_tiktok_pixel', 'value' => 4,'description' => ' بيكسل تيكتوك (4)','is_enabled' => true],
                ['key' => 'max_google_analytics', 'value' => 2,'description' => '  جوجل أناليتيك (2)','is_enabled' => true],
                ['key' => 'max_microsoft_clarity', 'value' => 2,'description' => '  ميكروسوفت كلاريتي (2)','is_enabled' => true],
                ['key' => 'google_sheet','value' =>1,'description' =>' جوجل شيت','is_enabled' => true],
                ['key' => 'copy_right' ,'value' => 1, 'description' => 'مع حقوق النشر للمنصة','is_enabled' => false],
            ],
        ];

        foreach ($permissions as $planId => $rules) {
            foreach ($rules as $permission) {
                SupplierPlanAuthorizations::updateOrCreate(
                    [
                        'plan_id' => $planId,
                        'permission_key' => $permission['key'],
                    ],
                    [
                        'permission_value' => $permission['value'],
                        'description' => $permission['description'],
                        'is_enabled' =>$permission['is_enabled'],
                    ]
                );
            }
        }
    }
}
