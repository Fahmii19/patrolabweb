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
        // Pastikan untuk menyesuaikan struktur tabel ini sesuai kebutuhan Anda
        if (!Schema::hasTable('pivot_guard_projects')) {
            Schema::create('pivot_guard_projects', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_project');
                $table->timestamps();

                // Pastikan tabel 'projects' sudah ada
                if (Schema::hasTable('projects')) {
                    // Foreign key constraint
                    $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_guard_projects');
    }
};
