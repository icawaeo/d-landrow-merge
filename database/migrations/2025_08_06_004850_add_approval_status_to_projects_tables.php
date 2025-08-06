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
        Schema::table('pengadaan_tanahs', function (Blueprint $table) {
            $table->string('status_persetujuan')->default('belum_diajukan')->after('desa');
            $table->unsignedBigInteger('admin1_id')->nullable()->after('status_persetujuan');
            $table->timestamp('admin1_reviewed_at')->nullable()->after('admin1_id');
            $table->unsignedBigInteger('admin2_id')->nullable()->after('admin1_reviewed_at');
            $table->timestamp('admin2_reviewed_at')->nullable()->after('admin2_id');
            $table->unsignedBigInteger('admin3_id')->nullable()->after('admin2_reviewed_at');
            $table->timestamp('admin3_reviewed_at')->nullable()->after('admin3_id');
            $table->text('catatan_penolakan')->nullable()->after('admin3_reviewed_at');
        });

        Schema::table('rows', function (Blueprint $table) {
            $table->string('status_persetujuan')->default('belum_diajukan')->after('desa');
            $table->unsignedBigInteger('admin1_id')->nullable()->after('status_persetujuan');
            $table->timestamp('admin1_reviewed_at')->nullable()->after('admin1_id');
            $table->unsignedBigInteger('admin2_id')->nullable()->after('admin1_reviewed_at');
            $table->timestamp('admin2_reviewed_at')->nullable()->after('admin2_id');
            $table->unsignedBigInteger('admin3_id')->nullable()->after('admin2_reviewed_at');
            $table->timestamp('admin3_reviewed_at')->nullable()->after('admin3_id');
            $table->text('catatan_penolakan')->nullable()->after('admin3_reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengadaan_tanahs', function (Blueprint $table) {
            $table->dropColumn([
                'status_persetujuan', 'admin1_id', 'admin1_reviewed_at',
                'admin2_id', 'admin2_reviewed_at', 'admin3_id', 'admin3_reviewed_at',
                'catatan_penolakan'
            ]);
        });

        Schema::table('rows', function (Blueprint $table) {
            $table->dropColumn([
                'status_persetujuan', 'admin1_id', 'admin1_reviewed_at',
                'admin2_id', 'admin2_reviewed_at', 'admin3_id', 'admin3_reviewed_at',
                'catatan_penolakan'
            ]);
        });
    }
};