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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('branch_type')->default('branch')->nullable();
            $table->string('branch_location')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_slug')->nullable();
            $table->string('is_head_office')->default(0)->nullable();
            $table->tinyInteger('branch_status')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
