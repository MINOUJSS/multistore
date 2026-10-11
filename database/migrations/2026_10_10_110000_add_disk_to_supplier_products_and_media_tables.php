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
        if (Schema::hasTable('supplier_products')) {
            Schema::table('supplier_products', function (Blueprint $table) {
                if (!Schema::hasColumn('supplier_products', 'disk')) {
                    $table->string('disk')->default('supplier')->after('image');
                }
            });
        }

        if (Schema::hasTable('supplier_product_images')) {
            Schema::table('supplier_product_images', function (Blueprint $table) {
                if (!Schema::hasColumn('supplier_product_images', 'disk')) {
                    $table->string('disk')->default('supplier')->after('image_path');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('supplier_products')) {
            Schema::table('supplier_products', function (Blueprint $table) {
                if (Schema::hasColumn('supplier_products', 'disk')) {
                    $table->dropColumn('disk');
                }
            });
        }

        if (Schema::hasTable('supplier_product_images')) {
            Schema::table('supplier_product_images', function (Blueprint $table) {
                if (Schema::hasColumn('supplier_product_images', 'disk')) {
                    $table->dropColumn('disk');
                }
            });
        }
    }
};
