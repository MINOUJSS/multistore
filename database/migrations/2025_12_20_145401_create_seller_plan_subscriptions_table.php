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
        Schema::create('seller_plan_subscriptions', function (Blueprint $table) {
            // عمود معرف العلاقة مع المورد
            $table->id();
            // العمود الذي يشير إلى المورد
            $table->unsignedBigInteger('seller_id');
            // العمود الذي يشير إلى خطة الاشتراك
            $table->unsignedBigInteger('plan_id');
            $table->string('duration')->nullable(); // مدة الخطة (شهر، 3 أشهر، إلخ)
            $table->decimal('price', 10, 2); // سعر الطلب
            $table->decimal('discount', 10, 2)->default(0); // الخصم
            $table->string('payment_method')->nullable(); // طريقة الدفع
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid'); // حالة الدفع
            // العمود الذي يحفظ تاريخ بداية الاشتراك
            $table->timestamp('subscription_start_date')->useCurrent();
            // العمود الذي يحفظ تاريخ نهاية الاشتراك
            $table->timestamp('subscription_end_date')->nullable();
            // حالة الاشتراك
            $table->enum('status', ['pending', 'paid', 'free'])->default('free');
            // تغيير الإشتراك
            $table->boolean('change_subscription')->default(false);
            // إنشاء المفتاح الخارجي للمورد
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            // إنشاء المفتاح الخارجي للخطة
            $table->foreign('plan_id')->references('id')->on('seller_plans')->onDelete('cascade');
            // طوابع الوقت (التاريخ والوقت)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_plan_subscriptions');
    }
};
