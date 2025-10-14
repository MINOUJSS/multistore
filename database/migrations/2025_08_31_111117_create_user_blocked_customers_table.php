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
        Schema::create('user_blocked_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // معرف المستخدم
            $table->string('phone')->nullable()->index(); // رقم الهاتف
            $table->string('ip_address', 45)->nullable()->index(); // IP v4 أو v6
            $table->string('device_fingerprint')->nullable()->index(); // بصمة الجهاز
            $table->string('reason')->nullable(); // سبب الحظر
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الحظر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_blocked_customers');
    }
};
