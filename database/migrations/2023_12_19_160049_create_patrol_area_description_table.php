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
        Schema::create('patrol_area_description', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('img_desc_location')->nullable();
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
        Schema::dropIfExists('patrol_area_description');
    }
};
