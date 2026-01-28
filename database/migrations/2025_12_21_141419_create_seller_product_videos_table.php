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
        Schema::create('seller_product_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('seller_products')
                  ->onDelete('cascade');

            $table->string('title')->nullable();
            $table->enum('type', ['youtube', 'vimeo', 'local'])->default('youtube'); // نوع الفيديو

            $table->string('youtube_url')->nullable(); // إذا كان مصدر الفيديو خارجي
            $table->string('youtube_id')->nullable();

            $table->string('file_path')->nullable(); // في حال رفع فيديو محلي (مثلاً storage/products/videos/video.mp4)
            $table->string('file_disk')->default('public'); // القرص المستخدم (لتعدد التخزين: local, s3, ...)

            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_product_videos');
    }
};
