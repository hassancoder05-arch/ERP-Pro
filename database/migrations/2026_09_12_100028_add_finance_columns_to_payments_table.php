<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('type', ['customer', 'supplier'])
                ->after('id');

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->nullOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->nullOnDelete();

            $table->decimal('amount', 12, 2)
                ->default(0);

            $table->date('payment_date')
                ->nullable();

            $table->enum('payment_method', ['cash', 'bank', 'other'])
                ->default('cash');

            $table->string('reference')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->index(['type', 'payment_date']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropIndex(['type', 'payment_date']);

            $table->dropColumn([
                'type',
                'customer_id',
                'supplier_id',
                'amount',
                'payment_date',
                'payment_method',
                'reference',
                'notes',
            ]);
        });
    }
};