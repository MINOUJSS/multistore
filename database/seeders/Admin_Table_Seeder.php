<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Admin_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        $admin=Admin::create([
            'name' => 'Amine',
            'email' => 'minoujss@gmail.com',
            'phone' => '0661752052',
            'type' => 'admin',
            'password' => Hash::make('MINOU1984'),
        ]);
    }
}
