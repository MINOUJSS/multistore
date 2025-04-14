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
        Schema::create('user_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // ربط الفاتورة بالمستخدم
            $table->string('invoice_number')->unique(); // رقم الفاتورة (فريد)
            $table->decimal('amount', 10, 2); // المبلغ الإجمالي
            $table->string('currency', 10)->default('DZD'); // العملة (افتراضي: الدينار الجزائري)
            $table->enum('status', ['pending', 'paid', 'failed','under_review'])->default('pending'); // حالة الفاتورة
            $table->text('description')->nullable(); // وصف أو ملاحظات إضافية
            $table->text('payment_method')->nullable(); // طريقة الدفع
            $table->date('due_date')->nullable(); // تاريخ الاستحقاق
            $table->timestamp('paid_at')->nullable(); // تاريخ الدفع

            $table->timestamps();

            // العلاقة مع جدول المستخدمين
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_invoices');
    }
};
