<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Data gudang & lokasi
        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('hub_id')->nullable()->after('gudang')
                ->constrained('hubs')->nullOnDelete();
            $table->index('hub_id');
        });

        // Master data: departemen / supplier / kategori (agar konsisten
        // dengan filter "pemilihan hub" pada halaman masing-masing).
        Schema::table('divisions', function (Blueprint $table) {
            $table->foreignId('hub_id')->nullable()->after('kepala')
                ->constrained('hubs')->nullOnDelete();
            $table->index('hub_id');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('hub_id')->nullable()->after('alamat')
                ->constrained('hubs')->nullOnDelete();
            $table->index('hub_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('hub_id')->nullable()->after('nama')
                ->constrained('hubs')->nullOnDelete();
            $table->index('hub_id');
        });
    }

    public function down(): void
    {
        foreach (['locations', 'divisions', 'suppliers', 'categories'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropForeign(['hub_id']);
                $t->dropIndex(['hub_id']);
                $t->dropColumn('hub_id');
            });
        }
    }
};
