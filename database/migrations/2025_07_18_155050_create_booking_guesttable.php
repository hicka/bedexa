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
        Schema::create('booking_guest', function (Blueprint $table) {
            // For most pivot tables an auto-id isn’t strictly required,
            // but keeping it makes future extensions easier.
            $table->id();

            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('guest_id')
                ->constrained()
                ->cascadeOnDelete();

            // optional extra fields (uncomment later if needed)
            // $table->enum('role', ['primary', 'companion'])->default('companion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_guest');
    }
};
