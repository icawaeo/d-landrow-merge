<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyampaiansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyampaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('row_id')->constrained('rows')->onDelete('cascade');
            $table->foreignId('penetapan_nilai_id')->constrained('penetapan_nilais')->onDelete('cascade');
            $table->string('status_persetujuan')->nullable();
            $table->date('tanggal_penyampaian')->nullable();
            $table->string('dokumen_penyampaian')->nullable(); // <-- Kolom yang hilang
            $table->text('catatan')->nullable();
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyampaians');
    }
}
