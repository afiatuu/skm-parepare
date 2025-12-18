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
        Schema::create('laporan_ikm_arsip', function (Blueprint $table) {
            $table->id();

            // Identitas OPD
            $table->string('opd_kode');

            // Nilai IKM & total responden
            $table->decimal('nilai_ikm', 8, 2)->nullable();
            $table->integer('total_responden')->default(0);

            // Distribusi responden (JSON)
            $table->json('detail_gender')->nullable();
            $table->json('detail_usia')->nullable();
            $table->json('detail_pendidikan')->nullable();
            $table->json('detail_pekerjaan')->nullable();

            // Unsur SKM (JSON rata-rata u1..u9)
            $table->json('detail_unsur')->nullable();

            // Mutu pelayanan
            $table->string('mutu')->nullable();

            // Waktu publikasi
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('laporan_ikm_arsip');
    }
};
