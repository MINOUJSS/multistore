<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chargily_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->enum("status", ["pending", "paid", "failed"])->default("pending");
            $table->string("currency");
            $table->string("amount");
            $table->string('payment_type')->nullable(); // 'user_invoice', 'supplier_subscription', 'other'
            $table->unsignedBigInteger('payment_reference_id')->nullable(); // ID of the user_invoice or supplier_subscription
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chargily_payments');
    }
};
