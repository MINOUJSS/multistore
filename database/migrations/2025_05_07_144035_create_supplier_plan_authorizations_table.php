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
        Schema::create('supplier_plan_authorizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('supplier_plans')->onDelete('cascade');
            $table->string('permission_key'); // مثل: create_products، export_invoices، ...
            $table->string('permission_value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_plan_authorizations');
    }
};
