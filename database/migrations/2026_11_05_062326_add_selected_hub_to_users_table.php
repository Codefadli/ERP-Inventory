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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('selected_city_id')->nullable()->after('role_id')->constrained('cities')->onDelete('set null');
            $table->foreignId('selected_hub_id')->nullable()->after('selected_city_id')->constrained('hubs')->onDelete('set null');
            
            $table->index('selected_hub_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['selected_city_id']);
            $table->dropForeign(['selected_hub_id']);
            $table->dropColumn(['selected_city_id', 'selected_hub_id']);
        });
    }
};
