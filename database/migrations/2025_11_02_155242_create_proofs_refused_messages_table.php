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
        Schema::create('proofs_refused_messages', function (Blueprint $table) {
            $table->id();

            // ربط المحادثة بإثبات الدفع المرفوض
            $table->foreignId('payment_proof_id')->nullable()
                  ->constrained('users_payments_proofs_refuseds')
                  ->onDelete('cascade');

            // نوع المرسل
            $table->enum('sender_type', ['admin', 'user'])->default('admin');
            $table->unsignedBigInteger('sender_id')->nullable();

            // الرسالة
            $table->text('message')->nullable();

            // المرفقات (صور أو مستندات)
            $table->json('attachments')->nullable();

            // حالة القراءة
            $table->boolean('is_read_by_admin')->default(false);
            $table->boolean('is_read_by_seller')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proofs_refused_messages');
    }
};
