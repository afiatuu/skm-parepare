<?php
// database/migrations/2025_11_20_111432_create_survey_responses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();

            // =====================
            // Identitas Responden
            // =====================
            $table->string('nama')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('gender')->nullable();
            $table->string('usia')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();

            // =====================
            // Relasi (Master Data)
            // =====================
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('opd_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();

            // =====================
            // Snapshot Data (Saat Survei)
            // =====================
            $table->string('opd_kode')->nullable();
            $table->string('opd_nama')->nullable();
            $table->string('layanan_nama')->nullable();

            // =====================
            // Unsur IKM (Input)
            // =====================
            $table->unsignedTinyInteger('u1')->nullable();
            $table->unsignedTinyInteger('u2')->nullable();
            $table->unsignedTinyInteger('u3')->nullable();
            $table->unsignedTinyInteger('u4')->nullable();
            $table->unsignedTinyInteger('u5')->nullable();
            $table->unsignedTinyInteger('u6')->nullable();
            $table->unsignedTinyInteger('u7')->nullable();
            $table->unsignedTinyInteger('u8')->nullable();
            $table->unsignedTinyInteger('u9')->nullable();

            // =====================
            // Status Teknis & Administratif
            // =====================
            $table->boolean('completed')->default(false);              // selesai isi survei
            $table->boolean('approved_by_kepala')->default(false);    // disahkan kepala OPD
            $table->timestamp('approved_at')->nullable();              // waktu pengesahan

            // =====================
            // Hasil & Masukan
            // =====================
            $table->decimal('nilai_ikm', 5, 2)->nullable();
            $table->text('saran')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
