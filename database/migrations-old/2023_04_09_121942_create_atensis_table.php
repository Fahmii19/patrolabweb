<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atensi', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->foreignId('id_wilayah');
            $table->foreignId('id_project');
            $table->foreignId('id_area');
            $table->string('judul_atensi');
            $table->enum('prioritas',['High','Low','Medium']);
            $table->DateTime('tanggal_mulai');
            $table->DateTime('tanggal_selesai');
            $table->string('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atensi');
    }
};
