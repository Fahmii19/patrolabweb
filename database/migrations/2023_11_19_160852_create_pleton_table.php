<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePletonTable extends Migration
{
    public function up()
    {
        Schema::create('pleton', function (Blueprint $table) {
            $table->id();
            $table->string('no_badge')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pleton');
    }
}
