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
        Schema::create('supplier_product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('supplier_products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('additional_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_product_variations');
    }
};
