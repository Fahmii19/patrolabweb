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
        Schema::create('asset_patrol_master', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique(); // unique
            $table->string('name', 255);
            $table->text('short_desc')->nullable();
            $table->text('images')->nullable();
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->enum('asset_master_type', ['PATROL', 'CLIENT']);
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
        Schema::dropIfExists('asset_patrol_master');
    }
};
