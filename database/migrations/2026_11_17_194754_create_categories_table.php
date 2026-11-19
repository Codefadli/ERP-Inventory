<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Kode kategori (CAT-001)');
            $table->string('nama', 100)->comment('Nama kategori');
            $table->text('deskripsi')->nullable()->comment('Deskripsi kategori');
            $table->boolean('status')->default(true)->comment('Aktif/Nonaktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
