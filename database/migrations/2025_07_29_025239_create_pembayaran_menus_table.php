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
        Schema::create('pembayaran_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyampaian_id')->constrained('penyampaians')->onDelete('cascade');            
            $table->string('status');
            $table->date('tanggal_pembayaran');
            $table->string('bukti_dokumen')->nullable();
            $table->timestamps();
    });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_menus');
    }
};
