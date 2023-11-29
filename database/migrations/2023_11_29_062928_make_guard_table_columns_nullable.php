<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeGuardTableColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('guard', function (Blueprint $table) {
            $table->string('address', 255)->nullable()->change();
            $table->string('badge_number', 255)->nullable()->change();
            $table->string('email', 255)->nullable()->change();
            // $table->enum('gender', ['MALE', 'FEMALE'])->nullable()->change(); // Enums might require special handling
            $table->string('img_avatar', 255)->nullable()->change();
            $table->string('name', 255)->nullable()->change();
            $table->string('wa', 255)->nullable()->change();
            $table->unsignedBigInteger('pleton_id')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->unsignedInteger('shift_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('guard', function (Blueprint $table) {
            // Reverse the changes here if needed
        });
    }
}
