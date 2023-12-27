<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_wilayah');
            $table->foreignId('id_project');
            $table->foreignId('id_area');
            $table->string('gate_code');
            $table->string('lokasi');
            $table->string('rfid_masuk');
            $table->string('no_kartu');
            $table->string('plat');
            $table->string('pemilik_kartu');
            $table->enum('status',['tamu','karyawan','petugas']);
            $table->dateTime('tanggal_masuk');
            $table->string('foto_masuk');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_vehicle');
    }
};
