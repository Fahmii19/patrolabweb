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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique(); // unique
            $table->string('name', 255);
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branch');
            $table->string('location_long_lat', 255)->nullable();
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');            
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
        Schema::dropIfExists('projects');
    }
};
