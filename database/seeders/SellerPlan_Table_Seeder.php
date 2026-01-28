<?php

namespace Database\Seeders;

use App\Models\Seller\SellerPlan;
use Illuminate\Database\Seeder;

class SellerPlan_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan1 = SellerPlan::create([
            'name' => 'المجانية',
            'description' => 'أفضل خيار للمبتدئين',
            'price' => '0',
        ]);
        $plan2 = SellerPlan::create([
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
        $plan3 = SellerPlan::create([
            'name' => 'الإحترافية',
            'description' => 'أفضل خيار للشركات الرائدة في التجارة الإلكترونية',
            'price' => '5000',
        ]);
    }
}
