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
        Schema::create('supplier_store_settings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBiginteger('supplier_id'); // Supplier ID
            $table->string('key'); // Setting key (e.g., "store_name", "currency")
            $table->text('value')->nullable(); // Setting value
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status of the setting
            $table->timestamps(); // created_at and updated_at
            //relationship
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_store_settings');
    }
};
