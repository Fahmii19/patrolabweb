<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guard', function (Blueprint $table) {
            $table->id(); // bigint and primary key
            $table->timestamps(); // created_at and updated_at
            $table->string('address', 255); // varchar(255)
            $table->string('badge_number', 255); // varchar(255)
            $table->string('email', 255); // varchar(255)
            $table->enum('gender', ['MALE', 'FEMALE']); // enum
            $table->string('img_avatar', 255); // varchar(255)
            $table->string('name', 255); // varchar(255)
            $table->string('wa', 255); // varchar(255)
            $table->unsignedBigInteger('pleton_id'); // bigint
            $table->date('dob'); // date
            $table->unsignedInteger('shift_id'); // int

            // Optional: Add foreign key constraints if needed
            // $table->foreign('pleton_id')->references('id')->on('pleton');
            // $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guard');
    }
}
