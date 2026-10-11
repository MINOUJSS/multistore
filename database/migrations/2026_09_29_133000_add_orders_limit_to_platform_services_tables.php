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
        Schema::table('platform_services', function (Blueprint $table) {
            $table->integer('orders_limit')->nullable()->after('credits_amount'); // عدد الطلبات المسموح بها في الباقة
        });

        Schema::table('seller_service_purchases', function (Blueprint $table) {
            $table->integer('orders_total')->default(0)->after('credits_remaining'); // إجمالي الطلبات الممنوحة
            $table->integer('orders_remaining')->default(0)->after('orders_total'); // الطلبات المتبقية
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('platform_services', function (Blueprint $table) {
            $table->dropColumn('orders_limit');
        });

        Schema::table('seller_service_purchases', function (Blueprint $table) {
            $table->dropColumn(['orders_total', 'orders_remaining']);
        });
    }
};
