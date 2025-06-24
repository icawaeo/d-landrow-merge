<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perizinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_tanah_id')->constrained()->onDelete('cascade');
            $table->string('izin_lingkungan')->nullable();
            $table->string('ikkpr')->nullable();
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
        Schema::dropIfExists('perizinans');
    }
};
