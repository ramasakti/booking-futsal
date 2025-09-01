<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('aktivitas_id')->constrained('master_aktivitas');
            $table->date('tanggal');
            $table->enum('tempat_aktivitas', ['Sekolah', 'Rumah']);
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_aktivitas');
    }
};
