<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            if (!Schema::hasColumn('survey_responses', 'nilai_ikm')) {
                $table->decimal('nilai_ikm', 5, 2)->nullable()->after('opd_kode');
            }
        });
    }

    public function down()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            if (Schema::hasColumn('survey_responses', 'nilai_ikm')) {
                $table->dropColumn('nilai_ikm');
            }
        });
    }
};
