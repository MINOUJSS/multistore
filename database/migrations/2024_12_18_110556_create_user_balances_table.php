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
        Schema::create('user_balances', function (Blueprint $table) {
            $table->bigIncrements('id'); // المفتاح الأساسي
            $table->unsignedBigInteger('user_id'); // معرف المستخدم
            $table->decimal('balance', 15, 2)->default(0); // الرصيد الحالي للمستخدم
            $table->decimal('outstanding_amount', 15, 2)->default(0); // مستحقات الدفع للمنصة
            $table->timestamps();
            // الربط بجدول المستخدمين
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balances');
    }
};
