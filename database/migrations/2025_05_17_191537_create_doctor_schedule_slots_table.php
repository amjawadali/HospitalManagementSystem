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
        Schema::create('doctor_schedule_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->date('slot_date');
            $table->time('slot_start');
            $table->time('slot_end');
            $table->enum('status', ['available', 'booked', 'blocked', 'completed'])->default('available');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('blocked_by')->nullable()->comment('Staff ID who blocked this slot');
            $table->text('block_reason')->nullable();
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            // $table->foreign('appointment_id')->references('id')->on('appointments')->nullable();
            $table->foreign('blocked_by')->references('id')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_slots');
    }
};
