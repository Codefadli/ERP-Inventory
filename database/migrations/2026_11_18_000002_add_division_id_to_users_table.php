<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Halaman Manajemen Pengguna menampilkan divisi & penugasan.
     * Tabel users belum memiliki kolom divisi, sedangkan tabel divisions
     * sudah tersedia sejak migration master data. Kolom ini diperlukan
     * agar filter divisi dan penugasan pengguna dapat disimpan sungguhan.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('division_id')
                ->nullable()
                ->after('role_id')
                ->constrained('divisions')
                ->nullOnDelete();

            $table->index('division_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropIndex(['division_id']);
            $table->dropColumn('division_id');
        });
    }
};
