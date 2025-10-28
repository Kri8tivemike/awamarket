<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Scope for active banner (only one should exist)
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Get the single active banner
    public static function getActiveBanner()
    {
        return self::active()->first();
    }

    // Ensure only one banner can be active at a time
    public static function boot()
    {
        parent::boot();

        static::saving(function ($banner) {
            if ($banner->status) {
                // Deactivate all other banners when this one is activated
                self::where('id', '!=', $banner->id)->update(['status' => false]);
            }
        });
    }
}
