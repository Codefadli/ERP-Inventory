<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->comment('Kode role (super_admin, kepala_gudang, hr, pegawai, audit)');
            $table->string('name', 100)->comment('Nama role (Super Admin, Kepala Gudang, HR, Pegawai, Audit)');
            $table->text('description')->nullable()->comment('Deskripsi role');
            $table->boolean('is_system')->default(false)->comment('Role sistem tidak dapat dihapus');
            $table->boolean('status')->default(true)->comment('Status aktif/nonaktif');
            $table->timestamps();
        });

        // Tabel Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique()->comment('Kode permission (catalog.view, product.manage, dll)');
            $table->string('name', 100)->comment('Nama permission');
            $table->string('group', 50)->comment('Grup permission (barang, transaksi, laporan, sistem)');
            $table->text('description')->nullable()->comment('Deskripsi permission');
            $table->timestamps();
        });

        // Tabel Role-Permission (many-to-many)
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();

            // Unique constraint: satu role tidak boleh punya permission yang sama dua kali
            $table->unique(['role_id', 'permission_id']);
        });

        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique()->comment('Username untuk login');
            $table->string('email')->unique()->comment('Email untuk login dan notifikasi');
            $table->string('password')->comment('Password hash (bcrypt/argon2id)');
            $table->string('nama_lengkap', 150)->comment('Nama lengkap pegawai');
            $table->string('nip', 50)->nullable()->comment('Nomor Induk Pegawai');
            $table->string('phone', 20)->nullable()->comment('Nomor telepon');
            $table->foreignId('role_id')->constrained('roles')->comment('Role pengguna');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Status akun');
            $table->integer('failed_login_attempts')->default(0)->comment('Jumlah percobaan login gagal');
            $table->timestamp('locked_until')->nullable()->comment('Waktu hingga akun terkunci');
            $table->timestamp('last_login_at')->nullable()->comment('Waktu login terakhir');
            $table->string('last_login_ip', 45)->nullable()->comment('IP address login terakhir');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes()->comment('Soft delete untuk akun dengan riwayat');
        });

        // Tabel User Tokens (untuk reset password dan aktivasi)
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['activation', 'reset_password'])->comment('Jenis token');
            $table->string('token_hash')->unique()->comment('Hash token (tidak simpan token asli)');
            $table->timestamp('expires_at')->comment('Waktu kedaluwarsa token');
            $table->timestamp('used_at')->nullable()->comment('Waktu token digunakan (sekali pakai)');
            $table->timestamps();

            $table->index(['token_hash', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
