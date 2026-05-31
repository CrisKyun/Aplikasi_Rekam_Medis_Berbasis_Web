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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->integer('nomor_antrian');
            $table->time('estimasi_jam');
            $table->text('keluhan_awal')->nullable();
            $table->enum('status_antrian', [
                'menunggu',
                'dipanggil',
                'selesai',
                'batal'
            ])->default('menunggu');
            $table->text('keterangan_pembatalan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
