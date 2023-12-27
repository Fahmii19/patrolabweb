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
        Schema::create('asset_patrol_checkpoint', function (Blueprint $table) {
            $table->id();
            $table->text('checkpoint_note');
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->unsignedBigInteger('checkpoint_id');
            $table->foreign('checkpoint_id')->references('id')->on('checkpoint');
            $table->unsignedBigInteger('asset_master_id');
            $table->foreign('asset_master_id')->references('id')->on('asset_patrol_master');
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
        Schema::dropIfExists('asset_patrol_checkpoint');
    }
};
