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
        Schema::create('seller_service_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('platform_service_id')->constrained('platform_services')->cascadeOnDelete();
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->string('status')->default('active'); // active, expired, consumed, cancelled
            $table->string('billing_type')->default('one_time'); // one_time, limited_period, credit_pack
            $table->integer('validity_days')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('credits_total')->default(0);
            $table->integer('credits_remaining')->default(0);
            $table->string('license_key')->nullable()->index();
            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_service_purchases');
    }
};
