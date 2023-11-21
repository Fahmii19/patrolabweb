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
        Schema::table('guards', function (Blueprint $table) {
            $table->unsignedBigInteger('pleton_id')->after('alamat'); // Menambahkan kolom 'pleton_id'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guards', function (Blueprint $table) {
            $table->dropColumn('pleton_id'); // Menghapus kolom 'pleton_id' jika migration di-rollback
        });
    }
};
