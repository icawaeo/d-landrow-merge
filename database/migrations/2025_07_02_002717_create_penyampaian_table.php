<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyampaianTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyampaian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('row_id')->constrained('rows')->onDelete('cascade');
            $table->foreignId('penetapan_nilai_id')->constrained('penetapan_nilais')->onDelete('cascade');

            $table->enum('status_persetujuan', ['Setuju', 'Tidak Setuju'])->nullable();
            $table->text('catatan')->nullable();
            $table->string('bukti_dokumen')->nullable(); // untuk file upload

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyampaian');
    }
}
