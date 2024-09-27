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
        Schema::create('dayras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wilaya_id');
            $table->foreign('wilaya_id')
            ->references('id')
            ->on('wilayas')
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
        Schema::dropIfExists('dayras');
    }
};
