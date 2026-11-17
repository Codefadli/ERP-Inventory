<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel user_sessions — registry sesi perangkat aktif.
     *
     * Menyimpan metadata sesi login per user tanpa menyimpan session ID mentah.
     * Karena session driver proyek adalah "file", pencabutan dilakukan dengan
     * menghapus file session pada storage/framework/sessions menggunakan hash
     * identifier yang aman.
     */
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('session_id', 64)->unique()->comment('Hash SHA-256 dari session ID');
            $table->string('device_name', 100)->nullable()->comment('Nama perangkat hasil parsing user agent');
            $table->string('platform', 50)->nullable()->comment('Windows, macOS, Android, iOS, Linux');
            $table->string('browser', 80)->nullable()->comment('Chrome, Firefox, Safari, Edge');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('status', 20)->default('active')->comment('active|revoked|expired');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['session_id']);
            $table->index(['last_activity_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};