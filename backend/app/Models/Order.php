<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'city', 'subtotal', 'vat_total', 'shipping_charge',
        'discount_total', 'grand_total', 'partial_advance', 'payment_method',
        'payment_status', 'order_status', 'courier_status', 'consignment_id',
        'tracking_url', 'event_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function courierLogs()
    {
        return $this->hasMany(CourierLog::class);
    }
}
