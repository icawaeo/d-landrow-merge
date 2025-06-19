<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIamColumnNotNullableInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah kolom 'iam' menjadi NOT NULL
            // Pastikan tipe datanya sama persis seperti sebelumnya
            $table->string('iam')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika di-rollback, kembalikan menjadi boleh NULL
            $table->string('iam')->nullable()->change();
        });
    }
}