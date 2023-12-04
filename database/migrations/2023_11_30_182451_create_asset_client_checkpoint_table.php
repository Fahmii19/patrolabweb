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
        Schema::create('asset_client_checkpoint', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_master_id');
            $table->foreignId('checkpoint_id');
            $table->string('checkpoint_note');
            $table->enum('status',['ACTIVED', 'INACTIVED']);
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
        Schema::dropIfExists('asset_client_checkpoint');
    }
};
