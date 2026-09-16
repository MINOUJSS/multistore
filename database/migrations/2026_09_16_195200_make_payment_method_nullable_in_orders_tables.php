<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('seller_orders') && Schema::hasColumn('seller_orders', 'payment_method')) {
            Schema::table('seller_orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash_on_delivery')->nullable()->change();
            });
        }

        if (Schema::hasTable('supplier_orders') && Schema::hasColumn('supplier_orders', 'payment_method')) {
            Schema::table('supplier_orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash_on_delivery')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('seller_orders') && Schema::hasColumn('seller_orders', 'payment_method')) {
            Schema::table('seller_orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash_on_delivery')->nullable(false)->change();
            });
        }

        if (Schema::hasTable('supplier_orders') && Schema::hasColumn('supplier_orders', 'payment_method')) {
            Schema::table('supplier_orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash_on_delivery')->nullable(false)->change();
            });
        }
    }
};
