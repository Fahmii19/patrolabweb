<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('checkpoint', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('location_long_lat');
            $table->string('qr_code')->unique();
            $table->foreignId('round_id')->nullable();
            $table->enum('status',['ACTIVED','INACTIVED']);
            $table->enum('danger_status', ['LOW', 'MIDDLE', 'HIGH']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkpoint');
    }
};
