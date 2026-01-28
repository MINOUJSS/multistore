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
        Schema::create('seller_product_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('seller_products')->onDelete('cascade');
            $table->decimal('discount_percentage', 5, 2)->nullable(); // نسبة الخصم
            $table->decimal('discount_amount', 10, 2)->nullable(); // قيمة الخصم
            $table->date('start_date'); // تاريخ بداية الخصم
            $table->date('end_date'); // تاريخ نهاية الخصم
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الخصم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_product_discounts');
    }
};
