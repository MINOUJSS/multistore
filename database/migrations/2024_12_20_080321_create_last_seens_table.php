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
        Schema::create('last_seens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // معرف المستخدم
            $table->ipAddress('ip_address')->nullable(); // عنوان IP المستخدم
            $table->string('device')->nullable(); // الجهاز المستخدم (اختياري)
            $table->string('browser')->nullable(); // المتصفح المستخدم (اختياري)
            $table->timestamp('last_seen_at')->useCurrent(); // توقيت تسجيل الدخول
            $table->timestamps();
            //relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_seens');
    }
};
