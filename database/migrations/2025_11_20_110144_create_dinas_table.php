<?php
// database/migrations/2025_11_20_110144_create_dinas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dinas', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->nullable(); // ⬅️ DIGABUNG DI SINI
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dinas');
    }
};

