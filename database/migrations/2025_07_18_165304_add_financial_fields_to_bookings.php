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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('room_total',      10, 2)->default(0);   // sum of room prices
            $table->decimal('service_charge',  10, 2)->default(0);   // 10 %
            $table->decimal('tgst',            10, 2)->default(0);   // 12 %
            $table->decimal('green_tax',       10, 2)->default(0);   // $6 pp/night (foreigners)
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->boolean('tax_inclusive')->default(false);
            $table->decimal('total_amount',    10, 2)->default(0);   // grand total
            $table->decimal('total_paid',      10, 2)->default(0);
            $table->decimal('balance_due',     10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
