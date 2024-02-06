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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255); 
            $table->string('img_avatar', 255)->nullable();
            $table->string('email', 255)->unique();  // unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255); 
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->string('access_area', 255)->nullable();
            $table->unsignedBigInteger('guard_id')->nullable();
            $table->foreign('guard_id')->references('id')->on('guards');
            $table->string('no_badge', 255)->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
};
