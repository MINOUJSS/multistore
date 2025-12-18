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
        Schema::create('users_payments_proofs_refuseds', function (Blueprint $table) {
            $table->id();

            // رقم الطلب المرتبط بإثبات الدفع
            $table->string('order_number')->index();

            // معرف المورد أو المستخدم الذي أرسل الإثبات
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // رابط أو مسار صورة إثبات الدفع المرفوضة
            $table->string('proof_path')->nullable();

            // سبب الرفض الذي أدخله الأدمن
            $table->text('refuse_reason')->nullable();

            // ملاحظات إضافية من الأدمن أو النظام
            $table->text('admin_notes')->nullable();

            // حالة الإثبات بعد الرفض
            $table->enum('status', ['in_review','approved','refused', 'archived'])->default('in_review');

            // اسم الأدمن أو الموظف الذي رفض الإثبات
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            // التاريخ الذي تم فيه رفض الإثبات
            $table->timestamp('refused_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_payments_proofs_refuseds');
    }
};
