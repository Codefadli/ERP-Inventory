<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('hub_id')->nullable()->after('division_id')
                ->constrained('hubs')->nullOnDelete();
            $table->index('hub_id');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['hub_id']);
            $table->dropIndex(['hub_id']);
            $table->dropColumn('hub_id');
        });
    }
};
