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
        Schema::create('supplier_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('title'); // عنوان الصفحة
            $table->string('slug')->unique(); // الرابط الدائم للصفحة
            $table->text('content'); // محتوى الصفحة
            $table->string('meta_title')->nullable(); // عنوان ميتا لتحسين SEO
            $table->text('meta_description')->nullable(); // وصف ميتا لتحسين SEO
            $table->string('meta_keywords')->nullable(); // كلمات مفتاحية لتحسين SEO
            $table->enum('status', ['published', 'draft'])->default('draft'); // حالة الصفحة
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_pages');
    }
};
