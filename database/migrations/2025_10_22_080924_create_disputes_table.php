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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();

            // رقم الطلب (للبحث عن المعاملة)
            $table->string('order_number')->index();

            // بيانات الزبون (في حال لم يكن مسجلاً)
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            // المورد أو البائع المعني
            // $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            // $table->enum('user_type', ['supplier', 'seller']);
            $table->string('seller_id')->nullable();

            // موضوع النزاع
            $table->string('subject');
            $table->text('description');

            // الأدلة المرفقة (صور، فواتير...الخ)
            $table->json('attachments')->nullable();

            // حالة النزاع
            $table->enum('status', [
                'open',             // تم إنشاؤه من قبل الزبون
                'in_review',        // قيد المراجعة من موظفي المنصة
                'resolved',         // تم حله بالتراضي
                'escalated',        // تم تحويله للجهات المسؤولة
                'rejected',         // تم رفض النزاع
                'closed',            // تم إغلاق النزاع
            ])->default('open');
            // معرف الموظف
            $table->unsignedBigInteger('admin_id')->nullable();

            // ملاحظات موظف المنصة أو لجنة التحكيم
            $table->text('admin_notes')->nullable();

            // تاريخ الحل أو الإغلاق
            $table->timestamp('resolved_at')->nullable();

            $table->string('access_token')->unique()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
