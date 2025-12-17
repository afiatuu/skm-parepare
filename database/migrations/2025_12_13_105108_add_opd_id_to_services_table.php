<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'opd_id')) {
                $table->unsignedBigInteger('opd_id')->nullable()->after('id');
                $table->foreign('opd_id')->references('id')->on('dinas')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'opd_id')) {
                $table->dropForeign(['opd_id']);
                $table->dropColumn('opd_id');
            }
        });
    }
};