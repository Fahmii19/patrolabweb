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
            $table->foreignId('patrol_checkpoint_id');
            $table->foreignId('asset_id');
            $table->enum('status',['SAFE', 'UNSAFE']);
            $table->string('unsafe_description')->nullable();
            $table->string('unsafe_image', 255)->nullable();
            $table->foreignId('asset_unsafe_option_id')->nullable();
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
