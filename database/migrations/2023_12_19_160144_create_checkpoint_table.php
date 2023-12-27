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
            $table->string('name', 255);
            $table->text('location');
            $table->string('location_long_lat', 100);
            $table->string('qr_code', 255)->unique();
            $table->enum('danger_status', ['LOW', 'MIDDLE', 'HIGH']);
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->unsignedBigInteger('round_id')->nullable();
            $table->foreign('round_id')->references('id')->on('rounds');
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
