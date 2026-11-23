<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'seller_products_visits',
            'supplier_products_visits',
            'seller_orders',
            'supplier_orders',
            'seller_order_abandoneds',
            'supplier_order_abandoneds',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'user_agent')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->text('user_agent')->nullable()->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'seller_products_visits',
            'supplier_products_visits',
            'seller_orders',
            'supplier_orders',
            'seller_order_abandoneds',
            'supplier_order_abandoneds',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'user_agent')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('user_agent', 255)->nullable()->change();
                });
            }
        }
    }
};

