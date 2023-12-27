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
        Schema::create('aset_locations', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('id_aset');
            $table->foreignId('id_wilayah');
            $table->foreignId('id_area');
            $table->enum('jenis_aset',['Operasional','Kantor']);
            $table->date('tanggal_pembelian');
            $table->text('keterangan');
            $table->string('foto');
            $table->integer('jumlah');
            $table->enum('status',['Baik','Cukup Baik','Rusak Sebagian','Rusak']);
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
        Schema::dropIfExists('aset_locations');
    }
};
