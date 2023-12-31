<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetPatrolMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_patrol_master', function (Blueprint $table) {
            $table->id(); // bigint
            $table->string('code', 255);
            $table->string('name', 255);
            $table->text('short_desc')->nullable();
            $table->enum('asset_master_type', ['PATROL', 'CLIENT']);
            $table->enum('status', ['ACTIVED', 'INACTIVED']);
            $table->string('image', 255)->nullable();
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
}
