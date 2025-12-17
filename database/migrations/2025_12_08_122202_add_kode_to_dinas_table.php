<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('dinas', 'kode')) {
            Schema::table('dinas', function (Blueprint $table) {
                $table->string('kode', 50)->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('dinas', function (Blueprint $table) {
            // aman kalau unique-nya belum ada
            try {
                $table->dropUnique('dinas_kode_unique'); // nama default index unique
            } catch (\Throwable $e) {
                // do nothing
            }

            if (Schema::hasColumn('dinas', 'kode')) {
                $table->dropColumn('kode');
            }
        });
    }
};