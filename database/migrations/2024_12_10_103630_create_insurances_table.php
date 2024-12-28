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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id("insurance_id");
            $table->unsignedBigInteger("insurance_type_id"); //Insurance foregin key ile bağlama işlemi
            $table->datetime("insurance_date_start"); //Insurance başlama tarihi
            $table->datetime("insurance_date_end"); //Insurance bitiş tarihi
            $table->foreign('insurance_type_id')->references("insurance_type_id")->on("insurance_types");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
