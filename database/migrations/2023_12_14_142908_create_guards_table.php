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
        Schema::create('guards', function (Blueprint $table) {
            $table->id(); 
            $table->string('badge_number', 255)->unique(); // unique
            $table->string('name', 255);
            $table->string('position', 255);
            $table->string('img_avatar', 255)->nullable(); 
            $table->date('dob'); // Date of Birth
            $table->enum('gender', ['MALE', 'FEMALE']); 
            $table->string('email', 255)->unique();  // unique
            $table->string('wa', 255)->unique(); // unique
            $table->string('address', 255); 
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shift');
            $table->unsignedBigInteger('pleton_id');
            $table->foreign('pleton_id')->references('id')->on('pleton');
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
        Schema::dropIfExists('guards');
    }
};
