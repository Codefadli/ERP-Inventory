<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Permintaan barang oleh pegawai (status permintaan / approval flow).
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('tiket', 30)->unique();
            $table->string('tipe', 60)->default('Barang Keluar');
            $table->text('rincian')->nullable();
            $table->string('prioritas', 20)->default('Normal');
            $table->string('approver', 100)->nullable();
            $table->string('status', 20)->default('Menunggu'); // Menunggu|Disetujui|Ditolak|Selesai
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->nullOnDelete();
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamps();
        });

        // Hasil stok opname fisik oleh pegawai.
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->nullOnDelete();
            $table->unsignedInteger('qty_sistem')->default(0);
            $table->unsignedInteger('qty_fisik')->default(0);
            $table->integer('selisih')->default(0);
            $table->string('status', 30)->default('Belum Diverifikasi'); // Belum Diverifikasi|Sesuai|Selisih
            $table->string('catatan', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
        Schema::dropIfExists('requests');
    }
};
