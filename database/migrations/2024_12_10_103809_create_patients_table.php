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
            $table->id("patients_id");
            $table->unsignedBigInteger("patients_insurances_id"); //Hasta Sigorta foreign keyi
            $table->string("patients_name",100); //Hasta adı
            $table->string("patients_surname",100); // Hasta Soyadı
            $table->string("patients_phone", 15); // Hasta Telefonu
            $table->string("patients_email");
            $table->char("patients_gender",1); // Hasta cinsiyeti e-k-d
            $table->foreign("patients_insurances_id")->references("insurance_id")->on("insurances");
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
