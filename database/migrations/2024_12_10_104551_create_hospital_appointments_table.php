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
        Schema::create('hospital_appointments', function (Blueprint $table) {
            $table->id("hospital_appointment_id");
            $table->unsignedBigInteger("patient_id");
            $table->unsignedBigInteger("hospital_address_id");
            $table->unsignedBigInteger("hospital_appointment_floor_id");
            $table->unsignedBigInteger("doctor_id");
            $table->unsignedBigInteger("specialties_id");
            $table->string("appointment_name",100);
            $table->datetime("appointment_date_start");
            $table->datetime("appointment_date_end");
            $table->boolean("appointment_status")->default(false);
            $table->foreign("patient_id")->references("patients_id")->on("patients");
            $table->foreign("hospital_address_id")->references("address_id")->on("addresses");
            $table->foreign("hospital_appointment_floor_id")->references("hospital_appointment_floor_id")->on("hospital_appointment_floors");
            $table->foreign("doctor_id")->references("doctor_id")->on("doctors");
            $table->foreign("specialties_id")->references("specialty_id")->on("specialties");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_appointments');
    }
};
