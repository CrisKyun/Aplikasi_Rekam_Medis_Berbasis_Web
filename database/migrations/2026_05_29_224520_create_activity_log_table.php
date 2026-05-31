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
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('aksi', 100);         // tambah_rekam_medis, edit_pasien, dll
            $table->string('modul', 50);         // rekam_medis, pasien, antrian, dll
            $table->text('deskripsi');           // detail aktivitas
            $table->string('ip_address', 45)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();   // id data yang diubah
            $table->string('target_type', 100)->nullable();        // nama model
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
