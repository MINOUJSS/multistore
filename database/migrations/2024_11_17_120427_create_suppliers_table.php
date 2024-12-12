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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('tenant_id');
            $table->string('full_name');
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            $table->string('store_name')->unique();
            //$table->string('phone')->unique();
            // $table->timestamp('phone_verified_at')->nullable();
            $table->string('wilaya')->nullable();
            $table->string('dayra')->nullable();
            $table->string('baladia')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
