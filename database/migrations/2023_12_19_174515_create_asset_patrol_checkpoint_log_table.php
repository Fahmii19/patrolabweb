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
            $table->string('id', 255)->primary();
            $table->index('id');
            $table->string('asset_code_log', 255)->nullable();
            $table->string('asset_name_log', 255)->nullable();
            $table->text('checkpoint_note_log')->nullable();
            $table->text('unsafe_description')->nullable();
            $table->text('unsafe_images')->nullable();
            $table->enum('status', ['SAFE', 'UNSAFE']);
            $table->string('asset_unsafe_option_log', 255);
            $table->string('patrol_checkpoint_log_id', 255);
            $table->foreign('patrol_checkpoint_log_id')->references('id')->on('patrol_checkpoint_log');
            $table->unsignedBigInteger('asset_unsafe_option_id')->nullable();
            $table->foreign('asset_unsafe_option_id')->references('id')->on('asset_unsafe_option');
            $table->unsignedBigInteger('asset_patrol_checkpoint_id')->nullable();
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
