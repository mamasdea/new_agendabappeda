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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('acara', 255);
            $table->string('penyelenggara', 255)->nullable();
            $table->time('jam')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tempat', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // opsional untuk filter cepat
            $table->index(['tanggal', 'jam']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
