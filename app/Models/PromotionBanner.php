<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'alt_text',
        'link',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Scope for active banners
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for ordered banners
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Get active banners in order
    public static function getActiveBanners()
    {
        return self::active()->ordered()->get();
    }
}
