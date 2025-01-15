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
        Schema::create('supplier_fqas', function (Blueprint $table) {
            $table->id(); // مفتاح أساسي
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('question'); // نص السؤال
            $table->text('answer'); // نص الإجابة
            $table->integer('order')->default(0); // ترتيب العرض (اختياري)
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة السؤال (فعال/غير فعال)
            $table->timestamps(); // تواريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_fqas');
    }
};
