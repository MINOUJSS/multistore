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
        Schema::create('dispute_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispute_id')->constrained()->onDelete('cascade');
            // من أرسل الرسالة: 'admin', 'customer', 'supplier' (إن أردت)
            $table->enum('sender_type', ['admin', 'customer', 'supplier', 'seller', 'marketer'])->default('customer');
            $table->unsignedBigInteger('sender_id')->nullable(); // null for unregistered customers
            $table->text('message');
            $table->json('attachments')->nullable();
            // حالات القراءة — نستخدم علامتين منفصلتين لأن كل طرف يجب أن يرى إن قرأ الطرف الآخر
            $table->boolean('is_read_by_admin')->default(false);
            $table->boolean('is_read_by_customer')->default(false);
            $table->timestamps();
            // فهارس للبحث بسرعة
            $table->index(['dispute_id', 'created_at']);
            $table->index(['is_read_by_admin', 'is_read_by_customer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispute_messages');
    }
};
