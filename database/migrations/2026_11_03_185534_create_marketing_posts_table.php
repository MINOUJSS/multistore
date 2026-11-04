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
        Schema::create('marketing_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('content');
            $table->string('platform')->default('facebook'); // facebook, instagram, linkedin, blog
            $table->text('hashtags')->nullable();
            $table->text('source_data_summary')->nullable();
            $table->text('prompt_used')->nullable();
            $table->string('status')->default('draft'); // draft, approved, published, rejected
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_posts');
    }
};
