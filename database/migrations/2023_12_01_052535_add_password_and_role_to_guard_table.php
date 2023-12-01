<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordAndRoleToGuardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guard', function (Blueprint $table) {
            $table->string('password'); // Menambahkan kolom password
            $table->enum('role', ['guard', 'admin_area']); // Menambahkan kolom role dengan tipe enum
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guard', function (Blueprint $table) {
            $table->dropColumn('password'); // Menghapus kolom password
            $table->dropColumn('role'); // Menghapus kolom role
        });
    }
}
