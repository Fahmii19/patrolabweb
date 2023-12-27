<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('name', 255);
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->string('address', 255);
            $table->string('location_long_lat', 255);
            $table->unsignedBigInteger('branch_id');
            $table->unsignedInteger('city_id');
            $table->timestamps();
         });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
