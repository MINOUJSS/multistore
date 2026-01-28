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
        Schema::create('seller_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade'); // المورد
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // المستخدم الذي قام بالطلب
            $table->string('order_number')->unique(); // رقم الطلب الفريد
            $table->string('customer_name')->nullable();
            $table->string('phone');
            $table->boolean('phone_visiblity')->default(false);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])
                  ->default('pending'); // حالة الطلب
            $table->decimal('total_price', 10, 2); // إجمالي السعر
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('shipping_cost', 10, 2)->default(0.00); // تكلفة الشحن
            $table->string('shipping_company')->nullable();
            $table->string('shipping_tracking_number')->nullable();
            $table->enum('shipping_type', ['to_home', 'to_descktop'])->default('to_home');
            $table->enum('free_shipping', ['yes', 'no'])->default('no');
            $table->string('payment_method')->default('cash_on_delivery'); // طريقة الدفع
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // حالة الدفع
            $table->string('shipping_address')->nullable(); // عنوان الشحن
            $table->string('billing_address')->nullable(); // عنوان الفواتير (إذا كان مختلفًا)
            $table->text('note')->nullable();
            $table->timestamp('order_date')->useCurrent(); // تاريخ الطلب
            $table->boolean('is_readed')->default(false);
            $table->string('country_id')->nullable();
            $table->string('wilaya_id')->nullable();
            $table->string('dayra_id')->nullable();
            $table->string('baladia_id')->nullable();
            // -------------------------
            // من قام بالتأكيد (صاحب الحساب)
            $table->foreignId('confirmed_by_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // من قام بالتأكيد (موظف)
            $table->foreignId('confirmed_by_employee_id')
                  ->nullable()
                  ->constrained('user_employees')
                  ->onDelete('set null');

            // حالة التأكيد
            $table->enum('confirmation_status', [
                'pending',       // لم يتم الاتصال بعد
                'call1',         // أول اتصال
                'call2',         // ثاني اتصال
                'call3',         // ثالث اتصال
                'error_phone',   // رقم الهاتف خاطئ
                'no_answer',     // لم يجب
                'confirmed',     // تم التأكيد
            ])->default('pending');

            // وقت التأكيد النهائي (إذا confirmed)
            $table->timestamp('confirmed_at')->nullable();
            // ------------------------
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->string('session_id')->nullable();
            $table->decimal('risk_score', 5, 2)->default(0);
            $table->json('risk_indicators')->nullable();
            $table->enum('fraud_status', [
                'pending', 'approved', 'rejected', 'under_review',
            ])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            // ------------------------
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_orders');
    }
};
