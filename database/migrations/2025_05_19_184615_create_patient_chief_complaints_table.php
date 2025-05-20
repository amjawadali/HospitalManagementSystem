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
        Schema::create('patient_chief_complaints', function (Blueprint $table) {
      $table->id();
            $table->unsignedBigInteger('checkin_id');
            $table->text('complaint');
            $table->date('onset_date')->nullable();
            $table->integer('duration_value')->nullable();
            $table->string('duration_unit', 20)->nullable();
            $table->integer('severity')->nullable();
            $table->text('associated_symptoms')->nullable();
            $table->text('aggravating_factors')->nullable();
            $table->text('relieving_factors')->nullable();
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('patient_checkins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_chief_complaints');
    }
};
