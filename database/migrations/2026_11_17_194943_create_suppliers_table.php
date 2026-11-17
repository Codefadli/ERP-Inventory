<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Kode supplier (SPL-001)');
            $table->string('nama', 100)->comment('Nama supplier');
            $table->string('pic', 100)->nullable()->comment('PIC supplier');
            $table->string('telepon', 20)->nullable()->comment('Nomor telepon');
            $table->string('email', 150)->nullable()->comment('Email supplier');
            $table->string('kota', 50)->nullable()->comment('Kota supplier');
            $table->text('alamat')->nullable()->comment('Alamat supplier');
            $table->boolean('status')->default(true)->comment('Aktif/Nonaktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
