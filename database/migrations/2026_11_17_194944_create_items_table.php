<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique()->comment('Kode SKU produk');
            $table->string('barcode', 50)->unique()->comment('Barcode produk');
            $table->string('nama', 150)->comment('Nama produk');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null');
            $table->string('deskripsi')->nullable()->comment('Deskripsi produk');
            $table->string('foto')->nullable()->comment('URL foto produk');
            $table->string('status')->default('Aktif')->comment('Aktif/Nonaktif');
            $table->integer('stok_minimum')->nullable()->comment('Stok minimum reorder point');
            $table->decimal('harga_beli', 10, 2)->nullable()->comment('Harga beli per unit');
            $table->decimal('harga_jual', 10, 2)->nullable()->comment('Harga jual per unit');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
