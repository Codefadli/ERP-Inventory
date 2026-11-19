<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Kode lokasi/rak (RAK-A1-01)');
            $table->string('nama', 100)->comment('Nama lokasi');
            $table->string('gudang', 50)->comment('Nama gudang');
            $table->string('nama_rak', 50)->nullable()->comment('Nama rak');
            $table->integer('kapasitas')->default(0)->comment('Kapasitas maksimal');
            $table->integer('terisi')->default(0)->comment('Jumlah terisi saat ini');
            $table->text('keterangan')->nullable()->comment('Keterangan lokasi');
            $table->boolean('status')->default(true)->comment('Aktif/Nonaktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'gudang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
