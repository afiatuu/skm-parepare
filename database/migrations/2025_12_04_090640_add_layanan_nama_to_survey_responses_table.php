<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->string('opd_kode')->nullable()->after('category_id');
            $table->string('opd_nama')->nullable()->after('opd_kode');
            $table->string('layanan_nama')->nullable()->after('service_id');
        });
    }

    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn(['opd_kode', 'opd_nama', 'layanan_nama']);
        });
    }
};