<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('musyawarahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_tanah_id')->constrained()->onDelete('cascade');
            $table->string('no_tip');
            $table->string('nama_pemilik');
            $table->string('desa');
            $table->decimal('nilai', 15, 2)->default(0); // Angka desimal untuk nilai uang
            $table->string('status')->nullable(); // SETUJU, MENOLAK
            $table->string('bukti_dokumen')->nullable(); // Path untuk file upload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musyawarahs');
    }
};
