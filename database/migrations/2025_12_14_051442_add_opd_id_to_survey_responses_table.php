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
            $table->unsignedBigInteger('opd_id')->nullable()->after('category_id');
        });
    }

    public function down()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn('opd_id');
        });
    }
};