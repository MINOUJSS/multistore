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
            $table->enum('transaction_type', ['addition', 'deduction']); // نوع العملية: إضافة، خصم، مستحقات
            $table->decimal('amount', 15, 2); // المبلغ
            $table->text('description')->nullable(); // وصف العملية
            $table->string('payment_method')->nullable(); // طريقة الدفع
            $table->string('payment_proof')->nullable();//إثبات الدفع
            $table->string('status')->nullable()->default('null');
            $table->boolean('invoiced')->default(false);
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
