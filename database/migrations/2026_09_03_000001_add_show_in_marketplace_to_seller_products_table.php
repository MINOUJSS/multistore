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
        Schema::table('seller_products', function (Blueprint $table) {
            $table->enum('show_in_marketplace', ['yes', 'no'])->default('yes')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_products', function (Blueprint $table) {
            $table->dropColumn('show_in_marketplace');
        });
    }
};
