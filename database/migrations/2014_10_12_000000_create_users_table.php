<?php
// database/migrations/2014_10_12_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // =====================
            // Identitas User
            // =====================
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // =====================
            // Role & Scope Akses
            // =====================
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('opd_kode', 50)->nullable(); // ⬅️ DIGABUNG

            // =====================
            // Sistem
            // =====================
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
