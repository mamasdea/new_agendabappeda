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
        Schema::create('ruang_rapats', function (Blueprint $table) {
            $table->id();
            $table->string('acara_rr', 255);
            $table->string('bidang_rr', 255)->nullable();
            $table->time('jam_rr')->nullable();
            $table->date('tanggal_rr')->nullable();
            $table->string('tempat_rr', 255)->nullable();
            $table->text('ket_rr')->nullable();
            $table->string('hari_tgl_rr', 100)->nullable();
            $table->timestamps();

            $table->index(['tanggal_rr', 'jam_rr']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_rapats');
    }
};
