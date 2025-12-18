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
        Schema::create('disputes_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispute_id')->nullable()->index();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('seller_id')->nullable();
            $table->string('order_number')->nullable();
            $table->text('subject')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('archived_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes_archives');
    }
};
