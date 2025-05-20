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
        Schema::create('patient_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkin_id');
            $table->text('current_medications')->nullable();
            $table->text('allergies')->nullable();
            $table->text('surgical_history')->nullable();
            $table->text('family_medical_history')->nullable();
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('patient_checkins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medical_histories');
    }
};
