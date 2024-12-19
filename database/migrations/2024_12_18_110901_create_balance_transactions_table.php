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
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->bigIncrements('id'); // المفتاح الأساسي
            $table->unsignedBigInteger('user_id'); // معرف المستخدم
            $table->string('transaction_type'); // نوع العملية: إضافة، خصم، مستحقات
            $table->decimal('amount', 15, 2); // المبلغ
            $table->text('description')->nullable(); // وصف العملية
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
        Schema::dropIfExists('balance_transactions');
    }
};
