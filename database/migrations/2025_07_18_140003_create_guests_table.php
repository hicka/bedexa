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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            $table->string('full_name');
            $table->string('passport_number')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('nationality');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->enum('type', ['local', 'foreign', 'expatriate']);
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
