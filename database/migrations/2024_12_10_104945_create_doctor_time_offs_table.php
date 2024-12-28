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
        Schema::create('doctor_time_offs', function (Blueprint $table) {
            $table->id("time_off_id");
            $table->unsignedBigInteger("doctor_id");
            $table->boolean("time_off_status");
            $table->dateTime("time_off_date_start");
            $table->dateTime("time_off_date_end");
            $table->foreign("doctor_id")->references("doctor_id")->on("doctors");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_time_offs');
    }
};
