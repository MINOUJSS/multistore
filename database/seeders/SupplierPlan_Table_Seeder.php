<?php

namespace Database\Seeders;

use App\Models\Supplier\SupplierPlan;
use App\Models\Supplier\SupplierPlanPrices;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierPlan_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plan1=SupplierPlan::create([
            'name' => 'المجانية',
            'description' => 'أفضل خيار للمبتدئين',
            'price' => '0',
        ]);
        $plan2=SupplierPlan::create([
            'name' => 'المتقدمة',
            'description' => 'أفضل خيار للشركات النامية',
            'price' => '2500',
        ]);
        $plan2->pricing()->create([
            'duration' => '90',
            'price' => '6500',
        ]);
        $plan2->pricing()->create([
            'duration' => '180',
            'price' => '10000',
        ]);
        $plan3=SupplierPlan::create([
            'name' => 'الإحترافية',
            'description' => 'أفضل خيار للشركات الرائدة في التجارة الإلكترونية',
            'price' => '5000',
        ]);
    }
}
