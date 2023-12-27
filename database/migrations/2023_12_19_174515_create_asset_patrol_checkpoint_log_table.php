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
        Schema::create('asset_patrol_checkpoint_log', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code_log', 255);
            $table->string('asset_name_log', 255);
            $table->text('checkpoint_note_log');
            $table->text('unsafe_description');
            $table->text('unsafe_image');
            $table->enum('status', ['SAFE', 'UNSAFE']);
            $table->unsignedBigInteger('patrol_checkpoint_log_id');
            $table->foreign('patrol_checkpoint_log_id')->references('id')->on('patrol_checkpoint_log');
            $table->unsignedBigInteger('asset_unsafe_option_id');
            $table->foreign('asset_unsafe_option_id')->references('id')->on('asset_unsafe_option');
            $table->unsignedBigInteger('asset_patrol_checkpoint_id');
            $table->foreign('asset_patrol_checkpoint_id')->references('id')->on('asset_patrol_checkpoint');
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
        Schema::dropIfExists('asset_patrol_checkpoint_log');
    }
};
