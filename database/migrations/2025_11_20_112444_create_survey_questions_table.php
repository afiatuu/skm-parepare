<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('unsur'); // 1..9
            $table->string('kode', 20)->nullable();
            $table->text('pertanyaan');
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['unsur', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};