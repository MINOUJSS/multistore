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
        Schema::create('supplier_products_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('supplier_products')->onDelete('cascade'); // يرتبط بالمنتج
            $table->tinyInteger('rating')->unsigned()->between(1, 5); // التقييم من 1 إلى 5 نجوم
            $table->text('comment')->nullable(); // التعليق (اختياري)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products_reviews');
    }
};
