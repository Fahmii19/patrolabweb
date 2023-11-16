<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('self_patrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guard');
            $table->foreignId('id_wilayah');
            $table->foreignId('id_project');
            $table->foreignId('id_area');
            $table->date('tanggal');
            $table->enum('status_lokasi',['aman','kebakaran','pencurian','lain-lain']);
            $table->string('deskripsi');
            $table->json('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('self_patrol');
    }
};
