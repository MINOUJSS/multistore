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
        Schema::create('seller_approve_un_approve_status_reasons', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seller_id');

            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers')
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
        Schema::dropIfExists('seller_approve_un_approve_status_reasons');
    }
};
