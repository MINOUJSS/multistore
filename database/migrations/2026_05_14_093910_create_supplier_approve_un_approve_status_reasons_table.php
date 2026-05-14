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
        Schema::create('supplier_approve_un_approve_status_reasons', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('supplier_id');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('admin_id')->nullable();

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->nullOnDelete();

            $table->enum('status', ['approved', 'unapproved'])
                ->default('unapproved');

            $table->text('reason');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_approve_un_approve_status_reasons');
    }
};
