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
        if (Schema::hasTable('seller_products')) {
            Schema::table('seller_products', function (Blueprint $table) {
                if (!Schema::hasColumn('seller_products', 'disk')) {
                    $table->string('disk')->default('seller')->after('image');
                }
                if (!Schema::hasColumn('seller_products', 'file_disk')) {
                    $table->string('file_disk')->default('seller')->after('file');
                }
            });
        }

        if (Schema::hasTable('seller_product_images')) {
            Schema::table('seller_product_images', function (Blueprint $table) {
                if (!Schema::hasColumn('seller_product_images', 'disk')) {
                    $table->string('disk')->default('seller')->after('image_path');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('seller_products')) {
            Schema::table('seller_products', function (Blueprint $table) {
                if (Schema::hasColumn('seller_products', 'disk')) {
                    $table->dropColumn('disk');
                }
                if (Schema::hasColumn('seller_products', 'file_disk')) {
                    $table->dropColumn('file_disk');
                }
            });
        }

        if (Schema::hasTable('seller_product_images')) {
            Schema::table('seller_product_images', function (Blueprint $table) {
                if (Schema::hasColumn('seller_product_images', 'disk')) {
                    $table->dropColumn('disk');
                }
            });
        }
    }
};
