<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->default(0);
            $table->date('income_date')->nullable();
            $table->enum('payment_method', [
                'cash',
                'bank',
                'other'
            ])->default('cash');
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn([
                'amount',
                'income_date',
                'payment_method',
                'description',
            ]);
        });
    }
};