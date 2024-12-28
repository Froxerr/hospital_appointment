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
        Schema::create('nurse_schedules', function (Blueprint $table) {
            $table->id("nurse_schedule_id");
            $table->unsignedBigInteger("nurse_id");
            $table->string("work_day");
            $table->dateTime("work_time_start");
            $table->dateTime("work_time_end");
            $table->foreign("nurse_id")->references("nurses_id")->on("nurses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_schedules');
    }
};
