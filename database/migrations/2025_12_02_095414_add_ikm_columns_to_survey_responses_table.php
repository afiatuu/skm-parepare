<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            //nilai unsur IKM
             $table->unsignedTinyInteger('u1')->nullable();
            $table->unsignedTinyInteger('u2')->nullable();
            $table->unsignedTinyInteger('u3')->nullable();
            $table->unsignedTinyInteger('u4')->nullable();
            $table->unsignedTinyInteger('u5')->nullable();
            $table->unsignedTinyInteger('u6')->nullable();
            $table->unsignedTinyInteger('u7')->nullable();
            $table->unsignedTinyInteger('u8')->nullable();
            $table->unsignedTinyInteger('u9')->nullable();

            // saran/keluhan
            $table->text('saran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn(['u1','u2','u3','u4','u5','u6','u7','u8','u9','saran']);
        });
    }
};
