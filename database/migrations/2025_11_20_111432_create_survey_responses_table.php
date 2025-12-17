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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            // identitas responden
            $table->string('nama')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('gender')->nullable();       // L / P
            $table->string('usia')->nullable();         // <12, 12-25, dst
            $table->string('pendidikan')->nullable();   // SD, SMP, SMA, dll
            $table->string('pekerjaan')->nullable();    // ASN, TNI, POLRI, dll
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();

            // pilihan layanan
            $table->unsignedBigInteger('category_id')->nullable(); // Dinas / Pelayanan Kesehatan / Kecamatan
            $table->unsignedBigInteger('dinas_id')->nullable();    // unit/instansi
            $table->unsignedBigInteger('service_id')->nullable();  // jenis layanan (boleh null utk kecamatan)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
