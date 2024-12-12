<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class App_Domain_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //suppliers
        $tenant =Tenant::create([
            'id'=>'supplier',
            'type'=>'supplier',
            'data'=>null,
        ]);
        $tenant->domains()->create(['domain' => 'supplier.'.request()->host()]);
        
        $tenant1 =Tenant::create([
            'id'=>'test.supplier',
            'type'=>'supplier',
            'data'=>null,
        ]);
        $tenant1->domains()->create(['domain' => 'test.supplier.'.request()->host()]);

        $tenant2 =Tenant::create([
            'id'=>'test1.supplier',
            'type'=>'supplier',
            'data'=>null,
        ]);
        $tenant2->domains()->create(['domain' => 'test1.supplier.'.request()->host()]);

        $tenant3 =Tenant::create([
            'id'=>'test2.supplier',
            'type'=>'supplier',
        ]);
        $tenant3->domains()->create(['domain' => 'test2.supplier.'.request()->host()]);

        //sellers
        $seller =Tenant::create([
            'id' => 'seller',
            'type' => 'seller',
        ]);
        $seller->domains()->create(['domain' => 'seller.'.request()->host()]);
        
        $seller1 =Tenant::create([
            'id' => 'test',
            'type' => 'seller',
        ]);
        $seller1->domains()->create(['domain' => 'test.'.request()->host()]);

        $seller2 =Tenant::create([
            'id' => 'test1',
            'type' => 'seller',
        ]);
        $seller2->domains()->create(['domain' => 'test1.'.request()->host()]);

        $seller3 =Tenant::create([
            'id' => 'test2',
            'type' => 'seller',
        ]);
        $seller3->domains()->create(['domain' => 'test2.'.request()->host()]);

        //shipers
        $shiper =Tenant::create([
            'id' => 'shiper',
            'type' => 'shiper',
        ]);
        $shiper->domains()->create(['domain' => 'shiper.'.request()->host()]);
        
        $shiper1 =Tenant::create([
            'id' => 'test.shiper',
            'type' => 'shipper',
        ]);
        $shiper1->domains()->create(['domain' => 'test.shiper.'.request()->host()]);

        $shiper2 =Tenant::create([
            'id' => 'test1.shiper',
            'type' => 'shipper',
        ]);
        $shiper2->domains()->create(['domain' => 'test1.shiper.'.request()->host()]);

        $shiper3 =Tenant::create([
            'id' => 'test2.shiper',
            'type' => 'shipper',
        ]);
        $shiper3->domains()->create(['domain' => 'test2.shiper.'.request()->host()]);

        //markerters
        $marketer =Tenant::create([
            'id' => 'marketer',
            'type' => 'marketer',
        ]);
        $marketer->domains()->create(['domain' => 'marketer.'.request()->host()]);
        
        $marketer1 =Tenant::create([
            'id' => 'test.marketer',
            'type' => 'marketer',
        ]);
        $marketer1->domains()->create(['domain' => 'test.marketer.'.request()->host()]);

        $marketer2 =Tenant::create([
            'id' => 'test1.marketer',
            'type' => 'marketer',
        ]);
        $marketer2->domains()->create(['domain' => 'test1.marketer.'.request()->host()]);

        $marketer3 =Tenant::create([
            'id' => 'test2.marketer',
            'type' => 'marketer',
        ]);
        $marketer3->domains()->create(['domain' => 'test2.marketer.'.request()->host()]);
    }
}
