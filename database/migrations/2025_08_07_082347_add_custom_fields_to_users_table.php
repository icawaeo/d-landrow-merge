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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('email');
            $table->string('position')->nullable()->after('nip');
            $table->string('organization')->nullable()->after('role');
            $table->string('company')->nullable()->after('organization');
            $table->string('business_area')->nullable()->after('company');
            $table->string('personal_sub_area')->nullable()->after('business_area');
            $table->string('unit_organization')->nullable()->after('personal_sub_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
