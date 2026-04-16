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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->char('nik', 16)->unique();       // untuk login
            $table->char('no_kk', 16);               // nomor kartu keluarga
            $table->string('username', 50);
            $table->string('password', 255);          // hash bcrypt
            $table->string('email', 50)->nullable();
            $table->foreignId('role_id')->default(3)->constrained('roles');
            $table->datetime('tanggal_registrasi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
