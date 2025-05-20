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
        Schema::create('patient_vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkin_id');
            $table->string('height', 5, 2); // cm
            $table->string('weight', 5, 2); // kg
            $table->string('bmi', 5, 2); // calculated field
            $table->string('temperature', 4, 1); // °C
            $table->string('systolic_bp'); // mmHg
            $table->string('diastolic_bp'); // mmHg
            $table->string('pulse_rate'); // bpm
            $table->string('respiratory_rate'); // breaths/min
            $table->string('oxygen_saturation', 5, 2); // %
            $table->string('blood_glucose')->nullable(); // mg/dL
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('patient_checkins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_vitals');
    }
};
