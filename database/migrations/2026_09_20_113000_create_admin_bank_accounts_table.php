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
        Schema::create('admin_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('account_type')->default('ccp'); // ccp, baridimob, bank, other
            $table->string('bank_name'); // بريد الجزائر, بريدي موب, BNA, BEA, etc.
            $table->string('account_name'); // اسم صاحب الحساب
            $table->string('account_number')->nullable(); // رقم الحساب
            $table->string('ccp_key', 10)->nullable(); // مفتاح الـ CCP
            $table->string('rip', 30)->nullable(); // رقم التعريف البريدي / البنكي RIP أو RIB
            $table->string('iban', 50)->nullable(); // رقم الحساب الدولي IBAN
            $table->string('swift_code', 20)->nullable(); // كود السويفت BIC / SWIFT
            $table->text('notes')->nullable(); // ملاحظات وإرشادات للعميل
            $table->boolean('is_active')->default(true); // حالة التفعيل
            $table->boolean('is_default')->default(false); // الحساب الافتراضي لهذا النوع
            $table->string('logo')->nullable(); // مسار شعار البنك
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_bank_accounts');
    }
};
