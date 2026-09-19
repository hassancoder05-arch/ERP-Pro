<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')
                ->nullable()
                ->constrained('expense_categories')
                ->nullOnDelete();

            $table->string('title')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->date('expense_date')->nullable();
            $table->enum('payment_method', ['cash', 'bank', 'other'])
                ->default('cash');
            $table->text('description')->nullable();

            $table->index('expense_date');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['expense_category_id']);
            $table->dropIndex(['expense_date']);

            $table->dropColumn([
                'expense_category_id',
                'title',
                'amount',
                'expense_date',
                'payment_method',
                'description',
            ]);
        });
    }
};