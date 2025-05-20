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
        Schema::create('patients', function (Blueprint $table) {
              $table->id();
            $table->string('name');
            $table->string('patient_code')->unique();
            $table->integer('age')->nullable();
            $table->string('cnic')->unique()->nullable();
            $table->string('profile_image')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');
            $table->string('blood_type')->nullable();
            $table->text('allergies')->nullable();
            $table->date('registration_date');
            $table->date('last_visit_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
