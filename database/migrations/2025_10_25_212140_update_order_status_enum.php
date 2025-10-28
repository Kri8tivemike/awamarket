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
        // First, change the status column to include both old and new enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'collected_by_dispatch', 'delivered_successfully', 'failed_delivery', 'order_cancelled') DEFAULT 'pending'");
        
        // Update existing 'shipped' status to 'collected_by_dispatch'
        DB::statement("UPDATE orders SET status = 'collected_by_dispatch' WHERE status = 'shipped'");
        
        // Update existing 'delivered' status to 'delivered_successfully'
        DB::statement("UPDATE orders SET status = 'delivered_successfully' WHERE status = 'delivered'");
        
        // Update existing 'cancelled' status to 'order_cancelled'
        DB::statement("UPDATE orders SET status = 'order_cancelled' WHERE status = 'cancelled'");
        
        // Finally, change the status column to use only the new enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'collected_by_dispatch', 'delivered_successfully', 'failed_delivery', 'order_cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old enum values
        DB::statement("UPDATE orders SET status = 'shipped' WHERE status = 'collected_by_dispatch'");
        DB::statement("UPDATE orders SET status = 'delivered' WHERE status = 'delivered_successfully'");
        DB::statement("UPDATE orders SET status = 'cancelled' WHERE status = 'order_cancelled'");
        DB::statement("DELETE FROM orders WHERE status = 'failed_delivery'");
        
        // Change back to old enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }
};
