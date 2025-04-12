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
        Schema::create('supplier_order_abandoneds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // المورد
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // المستخدم الذي قام بالطلب            
            $table->string('order_number')->unique(); // رقم الطلب الفريد
            $table->string('customer_name')->nullable();
            $table->string('phone');
            $table->boolean('phone_visiblity')->default(false);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled', 'returned'])
                  ->default('pending'); // حالة الطلب
            $table->decimal('total_price', 10, 2)->nullable(); // إجمالي السعر
            $table->decimal('shipping_cost', 10, 2)->default(0.00); // تكلفة الشحن
            $table->string('payment_method')->default('cash_on_delivery'); // طريقة الدفع
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // حالة الدفع
            $table->string('shipping_address')->nullable(); // عنوان الشحن
            $table->string('billing_address')->nullable(); // عنوان الفواتير (إذا كان مختلفًا)
            $table->timestamp('order_date')->useCurrent(); // تاريخ الطلب
            $table->boolean('is_readed')->default(false); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_order_abandoneds');
    }
};
