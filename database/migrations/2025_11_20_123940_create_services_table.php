<?php
// database\migrations\2025_11_20_123940_create_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // =====================
            // Relasi
            // =====================
            $table->unsignedBigInteger('dinas_id'); // unit / dinas

            // =====================
            // Atribut
            // =====================
            $table->string('nama');

            // =====================
            // Sistem
            // =====================
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
