<?php

use Carbon\Carbon;
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
        Schema::create('log_records', function (Blueprint $table) {
            $table->id("log_id");
            $table->unsignedBigInteger("user_id");
            $table->dateTime("log_date")->default(Carbon::now());
            $table->text("log_description");
            $table->string("user_name");
            $table->string("user_email");
            $table->string("badge")->default('info'); //Bilgi mi uyarı mı onları kontrol ediyor
            $table->string("ip_address");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_records');
    }
};
