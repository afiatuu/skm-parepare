<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('survey_questions', 'unsur')) {
                // 1-9 sesuai unsur SKM
                $table->unsignedTinyInteger('unsur')->after('id');
            }

            // opsional tapi sering kepake di form kamu:
            if (!Schema::hasColumn('survey_questions', 'kode')) {
                $table->string('kode', 20)->nullable()->after('unsur');
            }
            if (!Schema::hasColumn('survey_questions', 'urutan')) {
                $table->unsignedInteger('urutan')->default(1)->after('pertanyaan');
            }
            if (!Schema::hasColumn('survey_questions', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('urutan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            // drop kolom yang ada saja
            if (Schema::hasColumn('survey_questions', 'is_active')) $table->dropColumn('is_active');
            if (Schema::hasColumn('survey_questions', 'urutan')) $table->dropColumn('urutan');
            if (Schema::hasColumn('survey_questions', 'kode')) $table->dropColumn('kode');
            if (Schema::hasColumn('survey_questions', 'unsur')) $table->dropColumn('unsur');
        });
    }
};