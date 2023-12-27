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
        Schema::create('patrol_checkpoint_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pleton_id');
            $table->foreign('pleton_id')->references('id')->on('pleton');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shift');
            $table->unsignedBigInteger('checkpoint_id');
            $table->foreign('checkpoint_id')->references('id')->on('checkpoint');
            $table->date('business_date');
            $table->time('shift_start_time_log');
            $table->time('shift_end_time_log');
            $table->string('checkpoint_name_log', 255);
            $table->string('checkpoint_location_log', 255);
            $table->string('checkpoint_location_long_lat_log', 255)->nullable();
            $table->string('checkpoint_location_long_lat', 255)->nullable();
            $table->integer('safe_asset_client_checkpoint_id')->nullable();
            $table->string('safe_asset_client_images', 255)->nullable();
            $table->string('safe_asset_client_code_log', 255)->nullable();
            $table->string('safe_asset_client_name_log', 255)->nullable();
            $table->timestamps();
            // Ada di ERD
            // $table->unsignedBigInteger('created_by');
            // $table->foreign('created_by')->references('id')->on('guards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrol_checkpoint_log');
    }
};
