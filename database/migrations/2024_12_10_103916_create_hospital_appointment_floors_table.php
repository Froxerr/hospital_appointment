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
        Schema::create('hospital_appointment_floors', function (Blueprint $table) {
            $table->id("hospital_appointment_floor_id");
            $table->unsignedBigInteger("hospital_address_id");
            $table->integer("hospital_room_number");
            $table->string("hospital_block_name",100);
            $table->integer("hospital_floor_number");
            $table->foreign("hospital_address_id")->references("address_id")->on("addresses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_appointment_floors');
    }
};
