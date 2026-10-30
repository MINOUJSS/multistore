<?php

declare(strict_types=1);

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
        Schema::table('domains', function (Blueprint $table) {
            $table->string('cloudflare_id')->nullable()->after('tenant_id');
            $table->string('status')->default('pending')->after('cloudflare_id');
            $table->string('ssl_status')->nullable()->after('status');
            $table->text('verification_errors')->nullable()->after('ssl_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn([
                'cloudflare_id',
                'status',
                'ssl_status',
                'verification_errors',
            ]);
        });
    }
};
