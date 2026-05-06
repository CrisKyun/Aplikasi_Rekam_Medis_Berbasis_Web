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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_role', 20); 
            $table->timestamps();
        });
            // Tambahkan foreign key ke users SETELAH roles dibuat
    Schema::table('users', function (Blueprint $table) {
        $table->foreign('role_id')->references('id')->on('roles');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
