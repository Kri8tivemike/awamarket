<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    protected $table = 'whatsapp_settings';
    
    protected $fillable = [
        'phone_number',
        'business_name',
        'welcome_message',
        'enable_chat_widget',
    ];

    protected $casts = [
        'enable_chat_widget' => 'boolean',
    ];

    /**
     * Get the settings as a singleton
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'phone_number' => '+1234567890',
            'business_name' => 'AwaMarket Store',
            'welcome_message' => 'Welcome to AwaMarket! How can we help you today?',
            'enable_chat_widget' => false,
        ]);
    }
}
