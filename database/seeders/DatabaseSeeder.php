<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            Admin_Table_Seeder::class,
            Wilaya_Table_Seeder::class,
            Dayra_Table_Seeder::class,
            Baladia_Table_Seeder::class,
            App_Domain_Table_Seeder::class,
            SupplierPlan_Table_Seeder::class,
        ]);
    }
}
