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
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->nullable();
            $table->string('business_name')->nullable();
            $table->text('welcome_message')->nullable();
            $table->boolean('enable_chat_widget')->default(false);
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('whatsapp_settings')->insert([
            'phone_number' => '+1234567890',
            'business_name' => 'AwaMarket Store',
            'welcome_message' => 'Welcome to AwaMarket! How can we help you today?',
            'enable_chat_widget' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};
