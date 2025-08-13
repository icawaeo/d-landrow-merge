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
            $table->boolean('is_viewed')->default(false)->after('catatan_penolakan');
        });

        Schema::table('rows', function (Blueprint $table) {
            $table->boolean('is_viewed')->default(false)->after('catatan_penolakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengadaan_tanahs', function (Blueprint $table) {
            $table->dropColumn('is_viewed');
        });

        Schema::table('rows', function (Blueprint $table) {
            $table->dropColumn('is_viewed');
        });
    }
};