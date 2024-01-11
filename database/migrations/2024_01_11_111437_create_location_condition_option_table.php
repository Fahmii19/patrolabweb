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
        Schema::create('location_condition_option', function (Blueprint $table) {
            $table->id();
            $table->string('option_condition', 255);
            $table->string('description', 255)->nullable();
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
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
        Schema::dropIfExists('location_condition_option');
    }
};
