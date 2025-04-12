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
        Schema::create('supplier_order_abandoned_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('supplier_order_abandoneds')->onDelete('cascade'); // الطلب
            $table->foreignId('product_id')->constrained('supplier_products')->onDelete('cascade'); // المنتج
            $table->foreignId('variation_id')->nullable()->constrained('supplier_product_variations')->onDelete('set null'); // خيار المنتج (إن وجد)
            $table->foreignId('attribute_id')->nullable()->constrained('supplier_product_attributes')->onDelete('set null'); // خيار المنتج (إن وجد)
            $table->integer('quantity'); // الكمية المطلوبة
            $table->decimal('unit_price', 10, 2); // السعر للوحدة
            $table->decimal('total_price', 10, 2); // إجمالي السعر للعنصر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_order_abandoned_items');
    }
};
