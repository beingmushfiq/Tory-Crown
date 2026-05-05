<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'order_id', 'courier_id', 'courier_slug', 'tracking_number',
        'consignment_id', 'status', 'charge', 'estimated_delivery',
        'picked_up_at', 'delivered_at', 'webhook_data',
    ];

    protected $casts = [
        'webhook_data'      => 'array',
        'estimated_delivery' => 'date',
        'picked_up_at'      => 'datetime',
        'delivered_at'      => 'datetime',
    ];

    public function order(): BelongsTo   { return $this->belongsTo(Order::class); }
    public function courier(): BelongsTo { return $this->belongsTo(Courier::class); }

    public function getTrackingUrlAttribute(): ?string
    {
        return match($this->courier_slug) {
            'steadfast' => "https://steadfast.com.bd/track/{$this->tracking_number}",
            'pathao'    => "https://pathao.com/track/{$this->consignment_id}",
            default     => null,
        };
    }
}
