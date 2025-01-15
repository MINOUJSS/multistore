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
        Schema::create('supplier_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('supplier_products')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false); // لتحديد الصورة الرئيسية
            $table->integer('order')->default(0); // لتحديد ترتيب الصور
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_product_images');
    }
};
