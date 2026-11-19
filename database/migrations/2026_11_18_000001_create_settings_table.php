<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Konfigurasi aplikasi berbentuk key/value.
     *
     * scope:
     * - global : berlaku untuk seluruh sistem (scope_id = 0)
     * - hub    : berlaku untuk hub tertentu (scope_id = hubs.id)
     * - user   : preferensi pengguna (scope_id = users.id)
     *
     * Nilai rahasia (secret) disimpan terenkripsi dan ditandai is_encrypted.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 150);
            $table->text('value')->nullable();
            $table->string('type', 20)->default('string')->comment('string|integer|boolean|json|secret');
            $table->string('scope', 20)->default('global')->comment('global|hub|user');
            $table->unsignedBigInteger('scope_id')->default(0)->comment('0 untuk global, hubs.id untuk hub, users.id untuk user');
            $table->boolean('is_encrypted')->default(false);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['scope', 'scope_id', 'key']);
            $table->index(['scope', 'scope_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
