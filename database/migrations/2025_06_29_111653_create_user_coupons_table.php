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
        Schema::create('user_coupons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('code')->unique(); // كود الكوبون (فريد)
                $table->string('description')->nullable(); // وصف الكوبون
                $table->enum('type', ['fixed', 'percent']); // نوع الخصم (مبلغ ثابت أو نسبة مئوية)
                $table->decimal('value', 10, 2); // قيمة الخصم
                $table->decimal('min_order_amount', 10, 2)->nullable(); // الحد الأدنى للطلب لتطبيق الكوبون
                $table->dateTime('start_date'); // تاريخ بداية الكوبون
                $table->dateTime('end_date'); // تاريخ نهاية الكوبون
                $table->integer('usage_limit')->nullable(); // الحد الأقصى لعدد مرات الاستخدام
                $table->integer('usage_per_user')->nullable(); // الحد الأقصى للاستخدام لكل مستخدم
                $table->boolean('is_active')->default(true); // حالة تفعيل الكوبون
                $table->timestamps(); // timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupons');
    }
};
