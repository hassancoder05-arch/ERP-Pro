
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->string('purchase_number')->unique();

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->restrictOnDelete();

            $table->date('purchase_date');

            $table->string('status')->default('draft');

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamp('received_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

