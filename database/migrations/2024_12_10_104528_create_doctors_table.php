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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id("doctor_id");
            $table->unsignedBigInteger("specialties_id");
            $table->unsignedBigInteger("address_id");
            $table->string("doctor_name",100);
            $table->string("doctor_surname",100);
            $table->string("doctor_phone",15);
            $table->string("doctor_email",100);
            $table->foreign("specialties_id")->references("specialty_id")->on("specialties");
            $table->foreign("address_id")->references("address_id")->on("addresses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
