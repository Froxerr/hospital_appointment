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
        Schema::create('patient_appointment_histories', function (Blueprint $table) {
            $table->id("patient_appointment_history_id");
            $table->unsignedBigInteger("patient_history_id");
            $table->unsignedBigInteger("hospital_history_address_id");
            $table->unsignedBigInteger("hospital_history_appointment_floor_id");
            $table->unsignedBigInteger("doctor_history_id");
            $table->unsignedBigInteger("specialties_history_id");
            $table->unsignedBigInteger("appointment_insurance_history_id");
            $table->unsignedBigInteger("appointment_history_id");
            $table->string("appointment_history_name",100);
            $table->datetime("appointment_history_date_start");
            $table->datetime("appointment_history_date_end");
            $table->boolean("appointment_history_status")->default(false);
            $table->foreign("patient_history_id")->references("patients_id")->on("patients");
            $table->foreign("hospital_history_address_id", "pati_appointment_histories_hospital_history_address_id_fk")->references("address_id")->on("addresses");
            $table->foreign("hospital_history_appointment_floor_id", "pati_aptm_his_hp_hst_aptm_floor_id_foreign")->references("hospital_appointment_floor_id")->on("hospital_appointment_floors");
            $table->foreign("doctor_history_id")->references("doctor_id")->on("doctors");
            $table->foreign("specialties_history_id")->references("specialty_id")->on("specialties");
            $table->foreign("appointment_insurance_history_id", "pati_aptm_histories_aptm_ins_history_id_foreign")->references("insurance_id")->on("insurances");
            $table->foreign("appointment_history_id")->references("hospital_appointment_id")->on("hospital_appointments");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_appointment_histories');
    }
};
