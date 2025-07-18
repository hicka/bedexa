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
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');

            $table->enum('method', ['cash', 'card', 'bank', 'ota', 'online'])
                ->default('cash');               // extend as needed

            $table->decimal('exchange_rate', 10, 4)->nullable(); // if paid in another currency
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payments');
    }
};
