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
        Schema::create('benefit_section_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benefit_section_id')->constrained('user_benefit_sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('icon');
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_section_elements');
    }
};
