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
        Schema::create('payments_proofs_refuseds_archives', function (Blueprint $table) {
            $table->id();

            // 🔹 معرّف إثبات الدفع الأصلي (إن وجد)
            $table->unsignedBigInteger('original_proof_id')->nullable()->index();

            // 🔹 رقم الطلب
            $table->string('order_number')->nullable()->index();

            // 🔹 بيانات المورد / المستخدم الذي أرسل الإثبات
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();

            // 🔹 مسار صورة الإثبات الأصلي
            $table->string('proof_path')->nullable();

            // 🔹 سبب الرفض
            $table->text('refuse_reason')->nullable();

            // 🔹 ملاحظات إضافية من الأدمن
            $table->text('admin_notes')->nullable();

            // 🔹 بيانات الأدمن الذي رفض الإثبات
            $table->unsignedBigInteger('admin_id')->nullable()->index();
            $table->string('admin_name')->nullable();
            $table->string('admin_email')->nullable();

            // 🔹 الحالة (الأرشيف لا يحتاج إلا "archived")
            $table->enum('status', ['archived'])->default('archived');

            // 🔹 مسار ملف PDF للأرشيف (يحتوي على المحادثة والمرفقات)
            $table->string('archive_pdf_path')->nullable();


            // 🔹 التواريخ
            $table->timestamp('refused_at')->nullable();  // وقت الرفض الأصلي
            $table->timestamp('archived_at')->useCurrent(); // وقت الأرشفة

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_proofs_refuseds_archives');
    }
};
