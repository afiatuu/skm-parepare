<?php
// database\migrations\2025_12_15_024630_create_opd_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('opd', function (Blueprint $table) {
            $table->string('kode')->primary(); // kode unik OPD
            $table->string('nama');            // nama OPD

            // 🔑 RELASI KE CATEGORIES
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opd');
    }
};