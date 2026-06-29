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
        Schema::create('temp_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('disk')->default('local');
            $table->string('path');
            $table->string('original_name');
            $table->string('type'); // cover/gallery/digital
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_uploads');
    }
};
