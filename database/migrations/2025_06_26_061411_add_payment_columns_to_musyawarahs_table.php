<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('musyawarahs', function (Blueprint $table) {
            // Kolom baru untuk data pembayaran
            $table->string('status_pembayaran')->nullable()->after('status');
            $table->date('tanggal_pembayaran')->nullable()->after('status_pembayaran');
            $table->renameColumn('bukti_dokumen', 'bukti_musyawarah');
            $table->string('bukti_pembayaran')->nullable()->after('tanggal_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('musyawarahs', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'tanggal_pembayaran', 'bukti_pembayaran']);
            $table->renameColumn('bukti_musyawarah', 'bukti_dokumen');
        });
    }
};