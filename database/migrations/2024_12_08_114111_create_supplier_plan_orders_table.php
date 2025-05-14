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
        Schema::create('supplier_plan_orders', function (Blueprint $table) {
            $table->bigIncrements('id'); // المفتاح الأساسي
            $table->unsignedBigInteger('plan_id'); // المفتاح الخارجي للخطة
            $table->unsignedBigInteger('supplier_id'); // المفتاح الخارجي للمورد
            $table->string('duration'); // مدة الخطة (شهر، 3 أشهر، إلخ)
            $table->decimal('price', 10, 2); // سعر الطلب
            $table->decimal('discount', 10, 2)->default(0); // الخصم
            $table->string('payment_method')->nullable(); // طريقة الدفع
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending'); // حالة الطلب
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid'); // حالة الدفع
            $table->string('payment_proof')->nullable();
            $table->timestamp('start_date')->nullable(); // تاريخ بدء الاشتراك
            $table->timestamp('end_date')->nullable(); // تاريخ انتهاء الاشتراك
            $table->timestamps(); // الوقت
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade'); // علاقة مع جدول الموردين
            $table->foreign('plan_id')->references('id')->on('supplier_plans')->onDelete('cascade'); // علاقة مع جدول الخطط
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_plan_orders');
    }
};
