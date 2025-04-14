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
        Schema::create('user_invoice_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id'); // الفاتورة الرئيسية
            $table->string('item_name'); // اسم العنصر (المنتج أو الخدمة)
            $table->text('description')->nullable(); // وصف العنصر (اختياري)
            $table->integer('quantity')->default(1); // الكمية
            $table->decimal('unit_price', 10, 2); // السعر للوحدة
            $table->decimal('total', 10, 2); // المجموع = الكمية × السعر

            $table->timestamps();

            // العلاقة مع جدول الفواتير
            $table->foreign('invoice_id')->references('id')->on('user_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_invoice_details');
    }
};
