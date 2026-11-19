<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Temuan Audit & Ketidaksesuaian (LTA) oleh auditor.
        Schema::create('temuan_audits', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();               // no. LTA / temuan
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->string('tingkat', 20)->default('Sedang');   // Ringan|Sedang|Kritis
            $table->string('status', 30)->default('Temuan Baru'); // Temuan Baru|Diverifikasi|Selesai
            $table->string('lokasi', 150)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temuan_audits');
    }
};
