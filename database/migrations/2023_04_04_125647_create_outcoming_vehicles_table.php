<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outcoming_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_wilayah');
            $table->foreignId('id_project');
            $table->foreignId('id_area');
            $table->string('gate_code');
            $table->string('lokasi');
            $table->string('rfid_keluar');
            $table->string('no_kartu');
            $table->string('plat');
            $table->string('pemilik_kartu');
            $table->enum('status', ['tamu', 'karyawan', 'petugas']);
            $table->dateTime('tanggal_keluar');
            $table->string('foto_keluar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outcoming_vehicle');
    }
};
