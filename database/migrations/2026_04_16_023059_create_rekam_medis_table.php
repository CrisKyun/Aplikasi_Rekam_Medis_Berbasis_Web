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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('pendaftaran_id')->nullable();
            $table->string('dokter', 100);
            $table->date('tanggal_periksa');
            $table->text('keluhan');
            $table->string('tekanan_darah', 10)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->string('kode_icd10', 10)->nullable();
            $table->string('nama_icd10', 255)->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('resep_obat')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
