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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('slot_id');

            $table->date('appointment_date'); // Optional if you want date here
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing' ,'canceled', 'completed', 'no_show'])->default('pending');
            $table->timestamp('booking_time')->useCurrent();

            $table->text('reason_for_visit')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('doctor_schedule_slots')->onDelete('cascade');

            // Optional index for faster queries
            $table->index(['doctor_id', 'appointment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
