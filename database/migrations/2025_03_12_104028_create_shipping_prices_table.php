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
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط بالمستخدم
            $table->unsignedInteger('wilaya_id'); // معرف الولاية
            $table->boolean('shipping_available_to_wilaya')->default(false);
            $table->decimal('stop_desck_price', 10, 2); // سعر التسليم في نقطة التوصيل
            $table->boolean('shipping_available_to_stop_desck')->default(false);
            $table->decimal('to_home_price', 10, 2); // سعر التوصيل إلى المنزل
            $table->boolean('shipping_available_to_home')->default(false);
            $table->decimal('additional_price', 10, 2)->nullable(); // تكلفة إضافية للبلديات والدوائر
            $table->boolean('additional_price_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_prices');
    }
};
