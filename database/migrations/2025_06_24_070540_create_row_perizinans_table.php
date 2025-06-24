<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// dalam file ..._create_row_perizinans_table.php
public function up(): void
{
    Schema::create('row_perizinans', function (Blueprint $table) {
        $table->id();
        // Terhubung dengan tabel 'rows'
        $table->foreignId('row_id')->constrained()->onDelete('cascade');
        $table->string('izin_lingkungan')->nullable();
        $table->string('izin_rt_rw')->nullable(); // Sesuai permintaan terakhir Anda
        $table->string('izin_prinsip')->nullable();
        $table->string('izin_penetapan_lokasi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('row_perizinans');
    }
};
