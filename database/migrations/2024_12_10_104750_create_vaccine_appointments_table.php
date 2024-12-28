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
        Schema::create('vaccine_appointments', function (Blueprint $table) {
            $table->id("vaccine_appointments_id");
            $table->unsignedBigInteger("vaccines_id");
            $table->unsignedBigInteger("patients_id");
            $table->unsignedBigInteger("nurse_id");
            $table->unsignedBigInteger("hospital_addresses_id");
            $table->datetime("vaccine_appointment_date");
            $table->boolean("vaccine_appointment_status")->default(false);
            $table->foreign("vaccines_id")->references("vaccine_id")->on("vaccines");
            $table->foreign("patients_id")->references("patients_id")->on("patients");
            $table->foreign("nurse_id")->references("nurses_id")->on("nurses");
            $table->foreign("hospital_addresses_id")->references("address_id")->on("addresses");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_appointments');
    }
};
