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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained('hospital_cards');
            $table->foreignId('receptionist_id')->constrained('users');
            $table->json('signs');
            $table->foreignId('nurse_id')->nullable()->constrained('users');
            $table->json('patient_data')->nullable();
            $table->foreignId('cashier_id')->nullable()->constrained('users');
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
