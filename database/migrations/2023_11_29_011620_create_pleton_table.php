<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePletonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pleton', function (Blueprint $table) {
            $table->id(); // bigint and primary key
            $table->timestamps(); // created_at and updated_at
            $table->string('code', 255); // varchar(255)
            $table->string('name', 255); // varchar(255)
            $table->enum('status', ['ACTIVED', 'INACTIVED']); // enum
            $table->unsignedBigInteger('area_id'); // bigint

            // Index for area_id
            $table->index('area_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pleton');
    }
}
