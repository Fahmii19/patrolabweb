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
        Schema::create('areas', function (Blueprint $table) {
            $table->id(); 
            $table->string('code'); 
            $table->string('name'); 
            $table->string('description')->nullable(); 
            $table->enum('status', ['ACTIVED', 'INACTIVED']); 
            $table->string('img_location')->nullable(); 
            $table->unsignedBigInteger('project_id')->nullable(); 
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
        Schema::dropIfExists('areas');
    }
};
