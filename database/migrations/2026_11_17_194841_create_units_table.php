<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Kode satuan (PCS, BOX, RIM, KG, LTR, ROLL, SET)');
            $table->string('nama', 100)->comment('Nama satuan');
            $table->text('keterangan')->nullable()->comment('Keterangan satuan');
            $table->boolean('status')->default(true)->comment('Aktif/Nonaktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
