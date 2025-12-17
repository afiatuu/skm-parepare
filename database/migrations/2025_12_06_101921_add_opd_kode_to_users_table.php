<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // aman kalau kolom belum ada
            if (!Schema::hasColumn('users', 'opd_kode')) {
                $table->string('opd_kode', 50)->nullable()->after('role_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // aman kalau kolom memang belum ada
            if (Schema::hasColumn('users', 'opd_kode')) {
                $table->dropColumn('opd_kode');
            }
        });
    }
};