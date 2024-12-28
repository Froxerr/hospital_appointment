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
        Schema::create('appointment_capacities', function (Blueprint $table) {
            $table->id("appointment_capacity_id");
            $table->unsignedBigInteger("appointment_hospital_id");
            $table->integer("number_of_appointment");
            $table->integer("max_capacity");
            $table->integer("available_capacity");
            $table->foreign("appointment_hospital_id")->references("address_id")->on("addresses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_capacities');
    }
};
