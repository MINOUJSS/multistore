<?php

namespace Database\Seeders;

use App\Models\SupplierPlan;
use App\Models\SupplierPlanPrices;
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
            'description' => 'free plan',
            'price' => '0',
        ]);
        $plan2=SupplierPlan::create([
            'name' => 'المتقدمة',
            'description' => 'free plan',
            'price' => '2500',
        ]);
        $plan2->pricing()->create([
            'duration' => '3 أشهر',
            'price' => '6500',
        ]);
        $plan2->pricing()->create([
            'duration' => '6 أشهر',
            'price' => '10000',
        ]);
        $plan3=SupplierPlan::create([
            'name' => 'الإحترافية',
            'description' => 'free plan',
            'price' => '5000',
        ]);
    }
}
