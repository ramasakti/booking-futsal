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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lapangan_id')->constrained('lapangan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->integer('durasi_jam');
            $table->integer('total_harga');
            $table->integer('saldo_used');
            $table->integer('bayar_midtrans');
            $table->integer('total_bayar');
            $table->string('status');
            $table->string('payment_reference')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
