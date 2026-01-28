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
        Schema::create('seller_product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('seller_products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('color')->nullable();
            // $table->string('size')->nullable();
            // $table->string('weight')->nullable();
            // $table->decimal('additional_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_product_variations');
    }
};
