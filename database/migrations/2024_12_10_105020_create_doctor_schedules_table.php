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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id("schedule_id");
            $table->unsignedBigInteger("doctor_id");
            $table->dateTime("work_time_start");
            $table->dateTime("work_time_end");
            $table->boolean("status")->default(false);
            $table->foreign("doctor_id")->references("doctor_id")->on("doctors");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
