<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Drop sort_order column since we only need one banner
            $table->dropColumn('sort_order');
            
            // Ensure only one active banner can exist at a time
            // We'll handle this logic in the application layer
        });
        
        // Delete all existing banners except the first active one
        DB::statement('DELETE FROM banners WHERE id NOT IN (SELECT id FROM (SELECT MIN(id) as id FROM banners WHERE status = 1) as temp)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Add back sort_order column
            $table->integer('sort_order')->default(0);
        });
    }
};
