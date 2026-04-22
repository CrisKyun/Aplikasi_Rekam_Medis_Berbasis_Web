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
        Schema::create('info_klinik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klinik');
            $table->text('alamat');
            $table->string('no_telepon', 15);
            $table->string('email', 50)->nullable();
            $table->text('jam_operasional');  // format JSON
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_klinik');
    }
};
