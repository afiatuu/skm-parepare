<?php
// database/migrations/2025_12_14_075050_create_laporan_ikm_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_ikm', function (Blueprint $table) {
            $table->id();

            // =====================
            // Identitas OPD (bisnis)
            // =====================
            $table->string('opd_kode');
            $table->string('opd_nama');

            // =====================
            // Konten Laporan
            // =====================
            $table->string('judul');
            $table->text('ringkasan')->nullable();
            $table->decimal('nilai_ikm', 5, 2)->default(0);

            // =====================
            // Workflow Status
            // =====================
            $table->enum('status', [
                'draft',
                'waiting_approval',
                'approved',
                'published'
            ])->default('draft');

            // =====================
            // Persetujuan Kepala OPD
            // =====================
            $table->boolean('approved_by_kepala')->default(false);
            $table->timestamp('approved_at')->nullable();

            // =====================
            // Publikasi Admin
            // =====================
            $table->unsignedBigInteger('published_by_admin')->nullable();
            $table->timestamp('published_at')->nullable();

            // =====================
            // Metadata
            // =====================
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('published_by_admin')->references('id')->on('users')->onDelete('set null');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_ikm');
    }
};
