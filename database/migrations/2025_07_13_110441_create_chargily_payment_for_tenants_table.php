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
        Schema::create('chargily_payment_for_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('currency');
            $table->string('amount');
            $table->string('payment_type')->nullable(); // 'supplier_order', 'other'
            $table->unsignedBigInteger('payment_reference_id')->nullable(); // ID of the user_invoice or supplier_subscription
            $table->string('checkout_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chargily_payment_for_tenants');
    }
};
