<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_ikm', function (Blueprint $table) {
            $table->id();
            $table->string('opd_kode');
            $table->string('judul');
            $table->text('ringkasan')->nullable();
            $table->decimal('nilai_ikm', 5, 2)->default(0);

            // workflow status
            $table->enum('status', ['draft', 'waiting_approval', 'approved', 'published'])
                  ->default('draft');

            // persetujuan Kepala OPD
            $table->boolean('approved_by_kepala')->default(false);
            $table->timestamp('approved_at')->nullable();

            // metadata
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_ikm');
    }
};