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
        Schema::create('nurse_time_offs', function (Blueprint $table) {
            $table->id("nurse_time_off_id");
            $table->unsignedBigInteger("nurse_id");
            $table->boolean("time_off_status");
            $table->dateTime("time_off_date_start");
            $table->dateTime("time_off_date_end");
            $table->foreign("nurse_id")->references("nurses_id")->on("nurses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_time_offs');
    }
};
