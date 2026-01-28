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
        Schema::create('seller_offer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('seller_offers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('seller_products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_offer_products');
    }
};
