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
        Schema::create('pleton_patrol_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pleton_id');
            $table->foreign('pleton_id')->references('id')->on('pleton');
            $table->unsignedBigInteger('patrol_area_id');
            $table->foreign('patrol_area_id')->references('id')->on('patrol_area');
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
        Schema::dropIfExists('pleton_patrol_area');
    }
};
