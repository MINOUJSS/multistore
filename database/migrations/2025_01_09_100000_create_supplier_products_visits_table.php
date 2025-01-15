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
        Schema::create('supplier_products_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('supplier_products')->onDelete('cascade'); // ربط المنتج
            $table->string('ip_address')->nullable(); // عنوان IP للزائر
            $table->string('user_agent')->nullable(); // معلومات المتصفح أو الجهاز
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // إذا كان المستخدم مسجلاً
            $table->timestamp('visited_at')->useCurrent(); // وقت الزيارة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products_visits');
    }
};
