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
            $table->id(); // bigint, auto-increment
            $table->timestamps(); // created_at dan updated_at
            $table->string('code', 255)->nullable(); // varchar(255) nullable
            $table->string('img_location', 255)->nullable(); // varchar(255) nullable
            $table->string('name', 255)->nullable(); // varchar(255) nullable
            $table->string('deskripsi', 255)->nullable(); // varchar(255) nullable
            $table->enum('status', ['ACTIVED', 'INACTIVED'])->nullable(); // enum nullable
            $table->unsignedBigInteger('project_id')->nullable(); // bigint nullable
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
