<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('dokumen_hasil')->truncate();
        
        Schema::table('dokumen_hasil', function (Blueprint $table) {
            // Ini akan menambahkan kolom 'pengadaan_tanah_id'
            // dan menghubungkannya ke tabel 'pengadaan_tanahs'
            $table->foreignId('pengadaan_tanah_id')
                  ->after('id')
                  ->constrained('pengadaan_tanahs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_hasil', function (Blueprint $table) {
            // Ini untuk membatalkan migrasi jika diperlukan
            $table->dropForeign(['pengadaan_tanah_id']);
            $table->dropColumn('pengadaan_tanah_id');
        });
    }
};