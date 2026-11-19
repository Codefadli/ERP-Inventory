<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Transaksi Barang Masuk (inbound / penerimaan).
        Schema::create('inbounds', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();               // no. PO / ref penerimaan
            $table->string('surat_jalan', 40)->nullable();      // no. surat jalan supplier
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();
            $table->unsignedInteger('qty')->default(0);
            $table->string('satuan', 20)->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('dock', 30)->nullable();
            $table->string('status', 30)->default('Menunggu QC'); // Menunggu QC|Lolos QC|Karantina|Selesai
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->nullOnDelete();
            $table->string('keterangan', 500)->nullable();
            $table->timestamps();
        });

        // Transaksi Barang Keluar (outbound / pengeluaran).
        Schema::create('outbounds', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();               // no. DO / ref pengeluaran
            $table->string('permintaan', 30)->nullable();       // no. tiket permintaan (REQ-...)
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();
            $table->string('departemen', 100)->nullable();      // unit / departemen pemohon
            $table->string('pic', 100)->nullable();             // penanggung jawab
            $table->unsignedInteger('qty')->default(0);
            $table->string('satuan', 20)->nullable();
            $table->string('tujuan', 150)->nullable();          // tujuan / kurir
            $table->string('status', 30)->default('Menunggu');  // Menunggu|Picking|Selesai
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->nullOnDelete();
            $table->string('keterangan', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbounds');
        Schema::dropIfExists('inbounds');
    }
};
