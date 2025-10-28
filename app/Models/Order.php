<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'total',
        'items_count',
        'shipping_address',
        'billing_address',
        'notes'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COLLECTED_BY_DISPATCH = 'collected_by_dispatch';
    const STATUS_DELIVERED_SUCCESSFULLY = 'delivered_successfully';
    const STATUS_FAILED_DELIVERY = 'failed_delivery';
    const STATUS_ORDER_CANCELLED = 'order_cancelled';

    // Get all available statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COLLECTED_BY_DISPATCH => 'Collected By Dispatch',
            self::STATUS_DELIVERED_SUCCESSFULLY => 'Delivered Successfully',
            self::STATUS_FAILED_DELIVERY => 'Failed Delivery',
            self::STATUS_ORDER_CANCELLED => 'Order Cancelled',
        ];
    }

    // Get formatted total with currency
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    // Get status badge CSS class
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_PROCESSING => 'bg-blue-100 text-blue-800',
            self::STATUS_COLLECTED_BY_DISPATCH => 'bg-purple-100 text-purple-800',
            self::STATUS_DELIVERED_SUCCESSFULLY => 'bg-green-100 text-green-800',
            self::STATUS_FAILED_DELIVERY => 'bg-orange-100 text-orange-800',
            self::STATUS_ORDER_CANCELLED => 'bg-red-100 text-red-800',
        ];

        return $classes[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Check if order can be deleted
    public function canBeDeleted()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Check if status transition is valid
    public function canTransitionTo($newStatus)
    {
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_PROCESSING, self::STATUS_ORDER_CANCELLED],
            self::STATUS_PROCESSING => [self::STATUS_COLLECTED_BY_DISPATCH, self::STATUS_ORDER_CANCELLED],
            self::STATUS_COLLECTED_BY_DISPATCH => [self::STATUS_DELIVERED_SUCCESSFULLY, self::STATUS_FAILED_DELIVERY],
            self::STATUS_DELIVERED_SUCCESSFULLY => [], // Final state
            self::STATUS_FAILED_DELIVERY => [self::STATUS_COLLECTED_BY_DISPATCH], // Can retry delivery
            self::STATUS_ORDER_CANCELLED => [], // Final state
        ];

        return in_array($newStatus, $validTransitions[$this->status] ?? []);
    }

    /**
     * Get the items for this order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to search orders by customer name or email
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('customer_name', 'like', '%' . $search . '%')
              ->orWhere('customer_email', 'like', '%' . $search . '%')
              ->orWhere('customer_phone', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
