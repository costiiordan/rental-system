<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'item_booking_id',
        'name',
        'price',
    ];
    public $timestamps = false;

    public function itemBooking(): HasOne
    {
        return $this->hasOne(ItemBooking::class, 'id', 'item_booking_id');
    }

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
