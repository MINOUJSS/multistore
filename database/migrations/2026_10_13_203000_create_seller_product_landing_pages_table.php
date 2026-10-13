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
        Schema::create('seller_product_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('seller_products')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('marketing_angle')->default('general');
            $table->string('hero_headline')->nullable();
            $table->text('hero_subheadline')->nullable();
            $table->json('content_json')->nullable();
            $table->json('theme_settings')->nullable();
            $table->string('status')->default('published'); // published, draft, paused
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('orders_count')->default(0);
            $table->unsignedInteger('credits_used')->default(10);
            $table->timestamps();

            $table->index(['seller_id', 'slug']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_product_landing_pages');
    }
};
