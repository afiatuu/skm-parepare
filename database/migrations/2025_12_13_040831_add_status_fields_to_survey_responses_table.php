<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            if (!Schema::hasColumn('survey_responses', 'completed')) {
                $table->boolean('completed')->default(false)->after('saran');
            }

            if (!Schema::hasColumn('survey_responses', 'approved_by_kepala')) {
                $table->boolean('approved_by_kepala')->default(false)->after('nilai_ikm');
            }

            if (!Schema::hasColumn('survey_responses', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by_kepala');
            }
        });
    }

    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            if (Schema::hasColumn('survey_responses', 'completed')) {
                $table->dropColumn('completed');
            }
            if (Schema::hasColumn('survey_responses', 'approved_by_kepala')) {
                $table->dropColumn('approved_by_kepala');
            }
            if (Schema::hasColumn('survey_responses', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
        });
    }
};