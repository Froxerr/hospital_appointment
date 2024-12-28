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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id("address_id");
            $table->string("address_name"); //Hastane adı örneğin Pamukkale hastanesi gibi
            $table->unsignedBigInteger("address_district_id"); //Şehir
            $table->string("address_neighborhood", 50); // Mahalle
            $table->string("address_zip", 10); // zip kodu
            $table->foreign("address_district_id")->references("district_id")->on("districts");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
