<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan limit antrian harian per dokter (default: 100).
     */
    public function up(): void
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->integer('limit_harian')->default(100)->after('bidang_medis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->dropColumn('limit_harian');
        });
    }
};