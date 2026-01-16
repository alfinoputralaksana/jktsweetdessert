<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_province',
        'customer_city',
        'customer_postal_code',
        'delivery_type',
        'subtotal',
        'shipping_cost',
        'shipping_provider',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'payment_instructions',
        'virtual_account_number',
        'virtual_account_bank',
        'qris_url',
        'qris_image_url',
        'payment_expired_at',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'payment_expired_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
