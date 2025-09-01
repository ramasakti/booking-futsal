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
        Schema::create('walmur', function (Blueprint $table) {
            $table->id();
            $table->string('nis_anak');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('nis_anak')->references('nis')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walmur');
    }
};
