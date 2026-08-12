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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // e.g. TK-841920
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->default('seller'); // seller, supplier, customer
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            
            $table->enum('category', ['technical', 'financial', 'shipping', 'general'])->default('general');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            $table->string('subject');
            $table->text('message');
            $table->json('attachments')->nullable();
            
            $table->enum('status', ['open', 'in_progress', 'answered', 'closed'])->default('open');
            $table->unsignedBigInteger('assigned_admin_id')->nullable();
            
            $table->timestamp('last_reply_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
