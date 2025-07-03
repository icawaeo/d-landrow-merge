<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_pembayaran-menu_table.php
    public function up()
    {
        Schema::create('pembayaran-menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyampaian_id')->constrained('penyampaian')->onDelete('cascade');
            $table->enum('status', ['TERBAYAR', 'BELUM TERBAYAR'])->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran-menu');
    }
};
