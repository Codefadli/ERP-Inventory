<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 50)->comment('create|update|delete|activate|deactivate|login|logout|revoke_session');
            $table->string('entity_type', 100)->nullable()->comment('Model class atau entity name');
            $table->unsignedBigInteger('entity_id')->nullable()->comment('ID entitas yang diubah');
            // MySQL 5.6 tidak mengenal tipe kolom JSON (baru ada di 5.7+).
            // longText + cast 'array' pada model menghasilkan perilaku yang sama.
            $table->longText('changes')->nullable()->comment('Before/after untuk field yang diubah');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('result', 20)->default('success')->comment('success|failure');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
            $table->index(['action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};