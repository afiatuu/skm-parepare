<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporan_ikm', function (Blueprint $table) {
            $table->unsignedBigInteger('published_by_admin')->nullable()->after('approved_at');
            $table->timestamp('published_at')->nullable()->after('published_by_admin');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_ikm', function (Blueprint $table) {
            $table->dropColumn(['published_by_admin', 'published_at']);
        });
    }
};