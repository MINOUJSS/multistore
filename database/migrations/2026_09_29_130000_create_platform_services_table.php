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
        Schema::create('platform_services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->string('icon')->default('fa-solid fa-cube');
            $table->string('category')->default('general'); // payment, ai_tools, store_features, marketing
            $table->decimal('price', 12, 2)->default(0.00); // بالدينار الجزائري DZD
            $table->string('billing_type')->default('one_time'); // one_time, limited_period, credit_pack
            $table->integer('validity_days')->nullable(); // مدة الصلاحية بالأيام
            $table->integer('credits_amount')->nullable(); // عدد النقاط الممنوحة إن وجدت
            $table->string('badge_text')->nullable(); // الأكثر طلباً، حصري، جديد
            $table->string('badge_color')->default('warning'); // warning, success, info, primary
            $table->json('features')->nullable(); // ميزات الخدمة كنقاط
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
        Schema::dropIfExists('platform_services');
    }
};
