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
        Schema::create('baladias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dayra_id');
            $table->foreign('dayra_id')
            ->references('id')
            ->on('dayras')
            ->onDelete('cascade');
            $table->string('ar_name')->nullable();
            $table->string('en_name')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baladias');
    }
};