<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Kode divisi (DIV-IT)');
            $table->string('nama', 100)->comment('Nama divisi');
            $table->string('kepala', 100)->nullable()->comment('Kepala divisi');
            $table->text('keterangan')->nullable()->comment('Keterangan divisi');
            $table->boolean('status')->default(true)->comment('Aktif/Nonaktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
