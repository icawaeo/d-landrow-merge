<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('row_inventarisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('row_id')->constrained()->onDelete('cascade');
            $table->string('nama_kecamatan');
            $table->string('status');
            $table->date('tanggal_pelaksanaan');
            $table->string('lampiran_berita_acara')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('row_inventarisasis');
    }
};
