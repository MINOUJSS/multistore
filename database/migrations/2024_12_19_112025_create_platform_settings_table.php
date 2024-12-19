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
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->bigIncrements('id');// المفتاح الأساسي
            $table->string('key')->unique(); // مفتاح الإعداد (مثل: site_name، contact_email)
            $table->text('value')->nullable(); // قيمة الإعداد
            $table->string('type')->default('string'); // نوع القيمة (string، integer، boolean، json)
            $table->text('description')->nullable(); // وصف الإعداد
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الإعداد
            $table->timestamps(); // حقول التوقيت
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
