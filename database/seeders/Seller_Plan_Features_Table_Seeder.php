<?php

namespace Database\Seeders;

use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanFeature;
use Illuminate\Database\Seeder;

class Seller_Plan_Features_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إضافة المميزات لكل خطة
        $features = [
            ['name' => 'الوصول غير المحدود إلى الميزات الأساسية', 'available' => true],
            ['name' => 'دعم فني على مدار الساعة', 'available' => false], // غير متاح في الخطة الأساسية
            ['name' => 'تقارير دورية وتحليلات', 'available' => true], // متاح في الخطة المتقدمة
            ['name' => 'إمكانية تخصيص الإعدادات', 'available' => true],
            ['name' => 'تحديثات مستمرة وتحسينات', 'available' => true], // متاح في الخطة الشاملة
        ];

        $plans = SellerPlan::all();

        // ربط المميزات بالخطة
        foreach ($plans as $plan) {
            foreach ($features as $feature) {
                // التأكد من أن الميزة متاحة بناءً على الخطة
                if ($plan->name == 'الخطة الأساسية' && $feature['name'] == 'دعم فني على مدار الساعة') {
                    $feature['available'] = false;
                }
                if ($plan->name == 'الخطة الشاملة' && $feature['name'] == 'تحديثات مستمرة وتحسينات') {
                    $feature['available'] = true;
                }

                // إضافة الميزة إلى الجدول
                SellerPlanFeature::create([
                    'plan_id' => $plan->id,
                    'name' => $feature['name'],
                    'available' => $feature['available'],
                ]);
            }
        }
    }
}
