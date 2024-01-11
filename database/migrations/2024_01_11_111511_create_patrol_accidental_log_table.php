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
        Schema::create('patrol_accidental_log', function (Blueprint $table) {
            $table->id();
            $table->string('accidental_long_lat_log', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('images', 255);
            $table->string('location_condition_log', 255);
            $table->time('shift_start_time_log')->nullable();
            $table->time('shift_end_time_log')->nullable();
            $table->unsignedBigInteger('guard_id');
            $table->foreign('guard_id')->references('id')->on('guards');
            $table->unsignedBigInteger('location_condition_option_id');
            $table->foreign('location_condition_option_id')->references('id')->on('location_condition_option');
            $table->unsignedBigInteger('pleton_id');
            $table->foreign('pleton_id')->references('id')->on('pleton');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shift');
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
        Schema::dropIfExists('patrol_accidental_log');
    }
};
