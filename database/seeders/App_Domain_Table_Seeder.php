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
        $tenant =Tenant::create(['id' => 'supplier']);
        $tenant->domains()->create(['domain' => 'supplier.multistore.test']);
        
        $tenant1 =Tenant::create(['id' => 'test.supplier']);
        $tenant1->domains()->create(['domain' => 'test.supplier.multistore.test']);

        $tenant2 =Tenant::create(['id' => 'test1.supplier']);
        $tenant2->domains()->create(['domain' => 'test1.supplier.multistore.test']);

        $tenant3 =Tenant::create(['id' => 'test2.supplier']);
        $tenant3->domains()->create(['domain' => 'test2.supplier.multistore.test']);

        //sellers
        $seller =Tenant::create(['id' => 'seller']);
        $seller->domains()->create(['domain' => 'seller.multistore.test']);
        
        $seller1 =Tenant::create(['id' => 'test']);
        $seller1->domains()->create(['domain' => 'test.multistore.test']);

        $seller2 =Tenant::create(['id' => 'test1']);
        $seller2->domains()->create(['domain' => 'test1.multistore.test']);

        $seller3 =Tenant::create(['id' => 'test2']);
        $seller3->domains()->create(['domain' => 'test2.multistore.test']);

        //shipers
        $shiper =Tenant::create(['id' => 'shiper']);
        $shiper->domains()->create(['domain' => 'shiper.multistore.test']);
        
        $shiper1 =Tenant::create(['id' => 'test.shiper']);
        $shiper1->domains()->create(['domain' => 'test.shiper.multistore.test']);

        $shiper2 =Tenant::create(['id' => 'test1.shiper']);
        $shiper2->domains()->create(['domain' => 'test1.shiper.multistore.test']);

        $shiper3 =Tenant::create(['id' => 'test2.shiper']);
        $shiper3->domains()->create(['domain' => 'test2.shiper.multistore.test']);

        //suppliers
        $marketer =Tenant::create(['id' => 'marketer']);
        $marketer->domains()->create(['domain' => 'marketer.multistore.test']);
        
        $marketer1 =Tenant::create(['id' => 'test.marketer']);
        $marketer1->domains()->create(['domain' => 'test.marketer.multistore.test']);

        $marketer2 =Tenant::create(['id' => 'test1.marketer']);
        $marketer2->domains()->create(['domain' => 'test1.marketer.multistore.test']);

        $marketer3 =Tenant::create(['id' => 'test2.marketer']);
        $marketer3->domains()->create(['domain' => 'test2.marketer.multistore.test']);
    }
}
