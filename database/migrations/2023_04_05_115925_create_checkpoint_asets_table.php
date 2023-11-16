<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkpoint_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_check_point');
            $table->string('nama');
            $table->string('indikator');
            $table->string('jumlah');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkpoint_aset');
    }
};
