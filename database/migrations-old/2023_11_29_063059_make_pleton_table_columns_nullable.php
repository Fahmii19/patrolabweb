<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePletonTableColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('pleton', function (Blueprint $table) {
            $table->string('code', 255)->nullable()->change();
            $table->string('name', 255)->nullable()->change();
            // Enums might require special handling to make nullable
            $table->unsignedBigInteger('area_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pleton', function (Blueprint $table) {
            // Reverse the changes here if needed
        });
    }
}
