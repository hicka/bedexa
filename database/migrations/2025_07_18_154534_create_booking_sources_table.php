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
        Schema::create('booking_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('name');            // e.g. Direct, Booking.com, Airbnb
            $table->string('code')->nullable(); // optional slug or short code
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['team_id', 'name']);  // prevent duplicates per property
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_sources');
    }
};
