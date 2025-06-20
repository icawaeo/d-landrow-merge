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
    Schema::create('pengadaan_tanahs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_proyek');
        $table->string('kategori');
        $table->integer('jumlah_tower')->nullable();
        $table->string('provinsi')->nullable();
        $table->string('kabupaten')->nullable();
        $table->string('kecamatan')->nullable();
        $table->string('desa')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_tanahs');
    }
};
