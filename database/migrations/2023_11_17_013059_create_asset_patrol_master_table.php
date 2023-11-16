<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_patrol_master', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // Assumed to be a string
            $table->string('name');
            $table->string('asset_master_type')->nullable();
            $table->boolean('status'); // Assumed to be boolean (true/false)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_patrol_master');
    }
};
