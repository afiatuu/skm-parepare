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
        Schema::table('survey_responses', function (Blueprint $table) {

            // TANPA if hasColumn
            if (!Schema::hasColumn('survey_responses', 'completed')) {
                $table->boolean('completed')->default(false)->after('saran');
            }

            if (!Schema::hasColumn('survey_responses', 'approved_by_kepala')) {
                $table->boolean('approved_by_kepala')->default(false)->after('completed');
            }

            if (!Schema::hasColumn('survey_responses', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by_kepala');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            //
        });
    }
};
