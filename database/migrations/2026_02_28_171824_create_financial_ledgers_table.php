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
        Schema::create('financial_ledgers', function (Blueprint $table) {
            $table->id();

            // من يملك المال (Admin | Supplier | Seller | System)
            $table->nullableMorphs('owner');

            // سبب العملية (Subscription | Order | Withdrawal | Expense)
            $table->nullableMorphs('source');

            $table->decimal('amount', 12, 2);
            $table->enum('type', ['income', 'expense']);
            $table->string('category'); // subscription | order | withdrawal | system
            $table->string('currency')->default('DZD');

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_ledgers');
    }
};
